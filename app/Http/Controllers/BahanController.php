<?php

namespace App\Http\Controllers;

use App\Models\PengambilanBahan;
use App\Models\Siswa;
use Illuminate\Http\Request;


class BahanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $siswas = Siswa::with(['pengambilanBahans' => function($query) {
            $query->latest();
        }])
        ->when($search, function($query) use ($search) {
            return $query->where('namasiswa', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
        })
        ->when($status === 'diberikan', function($query) {
            return $query->whereHas('pengambilanBahans', function($query) {
                $query->where('status', 'diberikan');
            });
        })
        ->when($status === 'belum_ambil', function($query) {
            return $query->whereDoesntHave('pengambilanBahans');
        })
        ->orderBy('namasiswa')
        ->get();

        return view('bahan.index', compact('siswas', 'search', 'status'));
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
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_bahan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pengambilan' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['status'] = 'diberikan';

        PengambilanBahan::create($data);

        return redirect()->route('bahan.index')
            ->with('success', 'Data pengambilan bahan berhasil disimpan.');
    }

    public function ubah(PengambilanBahan $bahan)
    {
        $siswas = Siswa::orderBy('namasiswa')->get();
        return view('bahan.ubah', compact('bahan', 'siswas'));
    }

    public function update(Request $request, PengambilanBahan $bahan)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_bahan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pengambilan' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $bahan->update([
            'siswa_id' => $request->siswa_id,
            'nama_bahan' => $request->nama_bahan,
            'jumlah' => $request->jumlah,
            'tanggal_pengambilan' => $request->tanggal_pengambilan,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('bahan.index')
            ->with('success', 'Data pengambilan bahan berhasil diperbarui.');
    }

    public function destroy(PengambilanBahan $bahan)
    {
        $bahan->delete();

        return redirect()->route('bahan.index')
            ->with('success', 'Data pengambilan bahan berhasil dihapus.');
    }

    public function export()
    {
        $siswas = Siswa::with(['pengambilanBahans' => function($query) {
            $query->latest();
        }])->orderBy('namasiswa')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="Data_Pengambilan_Bahan_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($siswas) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['No', 'Nama Siswa', 'Jurusan', 'Tanggal Pengambilan', 'Nama Bahan', 'Jumlah', 'Keterangan']);
            
            $no = 1;
            foreach ($siswas as $siswa) {
                if ($siswa->pengambilanBahans->isNotEmpty()) {
                    foreach ($siswa->pengambilanBahans as $bahan) {
                        fputcsv($file, [
                            $no++,
                            $siswa->namasiswa,
                            $siswa->jurusan,
                            $bahan->tanggal_pengambilan->format('d/m/Y'),
                            $bahan->nama_bahan,
                            $bahan->jumlah,
                            $bahan->keterangan ?? '-'
                        ]);
                    }
                } else {
                    fputcsv($file, [
                        $no++,
                        $siswa->namasiswa,
                        $siswa->jurusan,
                        '-',
                        '-',
                        '-',
                        '-'
                    ]);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
