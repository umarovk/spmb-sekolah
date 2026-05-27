<?php

namespace App\Http\Controllers;

use App\Models\PengambilanBahan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BahanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status'); // lengkap | sebagian | belum
        $jenisFilter = $request->input('jenis');

        $items = PengambilanBahan::JENIS_BAHAN_LIST;
        $totalItems = count($items);

        $siswas = Siswa::with(['pengambilanBahans' => function($q) {
                $q->where('status', 'diberikan');
            }])
            ->when($search, function($q) use ($search) {
                $q->where(function($qq) use ($search) {
                    $qq->where('namasiswa', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
                });
            })
            ->when($jenisFilter, function($q) use ($jenisFilter) {
                $q->whereHas('pengambilanBahans', function($qq) use ($jenisFilter) {
                    $qq->where('jenis_bahan', $jenisFilter)->where('status', 'diberikan');
                });
            })
            ->orderBy('namasiswa')
            ->get()
            ->map(function ($siswa) use ($items, $totalItems) {
                $taken = $siswa->pengambilanBahans->pluck('jenis_bahan')->unique()->values();
                $siswa->items_taken = $taken;
                $siswa->items_missing = collect($items)->diff($taken)->values();
                $siswa->taken_count = $taken->count();
                $siswa->total_items = $totalItems;
                $siswa->progress_percent = $totalItems > 0 ? round(($taken->count() / $totalItems) * 100) : 0;
                if ($taken->count() === 0) {
                    $siswa->status_label = 'belum';
                } elseif ($taken->count() < $totalItems) {
                    $siswa->status_label = 'sebagian';
                } else {
                    $siswa->status_label = 'lengkap';
                }
                return $siswa;
            });

        if ($status) {
            $siswas = $siswas->where('status_label', $status)->values();
        }

        // Rekap per item
        $rekapItems = [];
        $totalSiswa = Siswa::count();
        foreach ($items as $item) {
            $sudah = PengambilanBahan::where('jenis_bahan', $item)
                ->where('status', 'diberikan')
                ->distinct('siswa_id')
                ->count('siswa_id');
            $rekapItems[] = [
                'nama' => $item,
                'sudah' => $sudah,
                'belum' => max(0, $totalSiswa - $sudah),
                'persen' => $totalSiswa > 0 ? round(($sudah / $totalSiswa) * 100) : 0,
            ];
        }

        // Rekap siswa
        $rekapSiswa = [
            'total' => $totalSiswa,
            'lengkap' => $siswas->where('status_label', 'lengkap')->count(),
            'sebagian' => $siswas->where('status_label', 'sebagian')->count(),
            'belum' => $siswas->where('status_label', 'belum')->count(),
        ];

        // Jika filter aktif, hitung dari semua data tanpa filter
        if ($search || $status || $jenisFilter) {
            $allSiswas = Siswa::with(['pengambilanBahans' => function($q) {
                $q->where('status', 'diberikan');
            }])->get();
            $rekapSiswa['lengkap'] = $allSiswas->filter(fn($s) => $s->pengambilanBahans->pluck('jenis_bahan')->unique()->count() === $totalItems)->count();
            $rekapSiswa['sebagian'] = $allSiswas->filter(function($s) use ($totalItems) {
                $c = $s->pengambilanBahans->pluck('jenis_bahan')->unique()->count();
                return $c > 0 && $c < $totalItems;
            })->count();
            $rekapSiswa['belum'] = $allSiswas->filter(fn($s) => $s->pengambilanBahans->isEmpty())->count();
        }

        return view('bahan.index', compact('siswas', 'search', 'status', 'jenisFilter', 'items', 'rekapItems', 'rekapSiswa'));
    }

    public function manage($siswaId)
    {
        $siswa = Siswa::with(['pengambilanBahans' => function($q) {
            $q->where('status', 'diberikan');
        }])->findOrFail($siswaId);

        $items = PengambilanBahan::JENIS_BAHAN_LIST;
        $taken = $siswa->pengambilanBahans->keyBy('jenis_bahan');

        return view('bahan.manage', compact('siswa', 'items', 'taken'));
    }

    public function updateChecklist(Request $request, $siswaId)
    {
        $siswa = Siswa::findOrFail($siswaId);
        $items = PengambilanBahan::JENIS_BAHAN_LIST;
        $checked = $request->input('items', []);
        $tanggal = $request->input('tanggal_pengambilan') ?: Carbon::now('Asia/Jakarta')->toDateString();
        $keterangan = $request->input('keterangan');

        foreach ($items as $item) {
            $existing = PengambilanBahan::where('siswa_id', $siswa->id)
                ->where('jenis_bahan', $item)
                ->first();

            if (in_array($item, $checked)) {
                if ($existing) {
                    $existing->update([
                        'status' => 'diberikan',
                        'tanggal_pengambilan' => $existing->tanggal_pengambilan ?? $tanggal,
                        'keterangan' => $keterangan ?: $existing->keterangan,
                    ]);
                } else {
                    PengambilanBahan::create([
                        'siswa_id' => $siswa->id,
                        'jenis_bahan' => $item,
                        'nama_bahan' => $item,
                        'jumlah' => 1,
                        'tanggal_pengambilan' => $tanggal,
                        'status' => 'diberikan',
                        'keterangan' => $keterangan,
                    ]);
                }
            } else {
                // Unchecked → hapus record (item dianggap belum diambil)
                if ($existing) {
                    $existing->delete();
                }
            }
        }

        return redirect()->route('bahan.index')
            ->with('success', "Data pengambilan bahan {$siswa->namasiswa} berhasil diperbarui.");
    }

    public function show(PengambilanBahan $bahan)
    {
        return view('bahan.show', compact('bahan'));
    }

    public function create()
    {
        $siswas = Siswa::orderBy('namasiswa')->get();
        return view('bahan.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        // Legacy fallback (jarang dipakai sekarang) — dialihkan ke manage
        if ($request->filled('siswa_id')) {
            return redirect()->route('bahan.manage', $request->siswa_id);
        }
        return redirect()->route('bahan.index');
    }

    public function ubah(PengambilanBahan $bahan)
    {
        return redirect()->route('bahan.manage', $bahan->siswa_id);
    }

    public function update(Request $request, PengambilanBahan $bahan)
    {
        return redirect()->route('bahan.manage', $bahan->siswa_id);
    }

    public function destroy(PengambilanBahan $bahan)
    {
        $siswaId = $bahan->siswa_id;
        $bahan->delete();

        return redirect()->route('bahan.manage', $siswaId)
            ->with('success', 'Item bahan berhasil dihapus.');
    }

    public function export()
    {
        $items = PengambilanBahan::JENIS_BAHAN_LIST;
        $siswas = Siswa::with(['pengambilanBahans' => function($q) {
            $q->where('status', 'diberikan');
        }])->orderBy('namasiswa')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="Data_Pengambilan_Bahan_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($siswas, $items) {
            $file = fopen('php://output', 'w');

            $header = ['No', 'Nama Siswa', 'NISN', 'Jurusan'];
            foreach ($items as $it) {
                $header[] = $it;
            }
            $header[] = 'Progress';
            fputcsv($file, $header);

            $no = 1;
            foreach ($siswas as $siswa) {
                $taken = $siswa->pengambilanBahans->keyBy('jenis_bahan');
                $row = [
                    $no++,
                    $siswa->namasiswa,
                    $siswa->nisn,
                    $siswa->jurusan,
                ];
                $takenCount = 0;
                foreach ($items as $it) {
                    if (isset($taken[$it])) {
                        $tgl = $taken[$it]->tanggal_pengambilan ? $taken[$it]->tanggal_pengambilan->format('d/m/Y') : '-';
                        $row[] = "Sudah ({$tgl})";
                        $takenCount++;
                    } else {
                        $row[] = 'Belum';
                    }
                }
                $row[] = $takenCount . '/' . count($items);
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
