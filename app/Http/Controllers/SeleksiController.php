<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Services\GoogleSheetsService;
use Illuminate\Support\Facades\Log;

class SeleksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status_filter = $request->input('status_filter');

        $datasiswa = Siswa::with('selektor:id,nama')
            ->when($search, function($query) use ($search) {
                return $query->where('namasiswa', 'like', "%{$search}%")
                            ->orWhere('nisn', 'like', "%{$search}%")
                            ->orWhere('jurusan', 'LIKE', "%{$search}%")
                        ->orWhere('jeniskelamin', 'LIKE', "%{$search}%")
                        ->orWhere('agama', 'LIKE', "%{$search}%")
                        ->orWhere('asrama_tahfidz', 'LIKE', "%{$search}%");
            })
            ->when($status_filter, function($query) use ($status_filter) {
                return $query->where('status_seleksi', $status_filter);
            })
            ->latest()
            ->get();

        return view('seleksi.dataseleksi', compact('datasiswa', 'search', 'status_filter'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak,dipertimbangkan',
            'tanggal_seleksi' => 'required|date'
        ]);

        try {
            $siswa = Siswa::findOrFail($id);
            $user  = auth()->user();

            if (! $siswa->canBeEditedBy($user)) {
                $lockedBy = $siswa->selektor?->nama ?? 'user lain';
                return response()->json([
                    'success' => false,
                    'message' => "Status sudah dikunci oleh {$lockedBy}. Hubungi admin untuk membuka kembali.",
                ], 403);
            }

            $isPending = $request->status === 'pending';

            $siswa->status_seleksi  = $request->status;
            $siswa->tanggalseleksi  = $request->tanggal_seleksi;
            $siswa->selektor_inisial = $isPending
                ? null
                : strtolower(substr(preg_replace('/\s+/', '', $user->nama ?? ''), 0, 3));
            $siswa->selektor_user_id = $isPending ? null : $user->id;
            $siswa->save();

            return response()->json([
                'success'           => true,
                'message'           => 'Status berhasil diupdate',
                'inisial'           => $siswa->selektor_inisial,
                'selektor_user_id'  => $siswa->selektor_user_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Status update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function jawaban(Request $request, $id, GoogleSheetsService $sheets)
    {
        $siswa = Siswa::findOrFail($id);

        if ($request->boolean('refresh')) {
            $sheets->fetchSeleksiRows(true);
        }

        $configured = $sheets->isConfigured();
        $data = $configured ? $sheets->findByStudentName($siswa->namasiswa) : null;

        return view('seleksi.jawaban', [
            'siswa'      => $siswa,
            'data'       => $data,
            'configured' => $configured,
        ]);
    }

    public function export()
    {
        $siswas = Siswa::orderBy('namasiswa')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="Data_Seleksi_Siswa_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($siswas) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['No', 'Nama Siswa', 'Jurusan', 'Gender', 'Tanggal Seleksi', 'Status Seleksi']);
            
            $no = 1;
            foreach ($siswas as $siswa) {
                fputcsv($file, [
                    $no++,
                    $siswa->namasiswa,
                    $siswa->jurusan,
                    $siswa->jeniskelamin,
                    $siswa->tanggalseleksi ? date('d/m/Y', strtotime($siswa->tanggalseleksi)) : '-',
                    ucfirst($siswa->status_seleksi)
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
