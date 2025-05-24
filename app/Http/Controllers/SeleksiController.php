<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Log;

class SeleksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $perPage = $request->input('perPage', 10);

        $datasiswa = Siswa::when($search, function($query) use ($search) {
                return $query->where('namasiswa', 'like', "%{$search}%")
                            ->orWhere('nisn', 'like', "%{$search}%")
                            ->orWhere('jurusan', 'LIKE', "%{$search}%")
                        ->orWhere('jeniskelamin', 'LIKE', "%{$search}%")
                        ->orWhere('agama', 'LIKE', "%{$search}%")
                        ->orWhere('asrama_tahfidz', 'LIKE', "%{$search}%");
            })
            ->when($status, function($query) use ($status) {
                return $query->where('status_seleksi', $status);
            })
            ->orderBy('namasiswa')
            ->paginate($perPage);

        return view('seleksi.dataseleksi', compact('datasiswa', 'search', 'status', 'perPage'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak,dipertimbangkan'
        ]);

        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->status_seleksi = $request->status;
            $siswa->save();

            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            Log::error('Status update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate status: ' . $e->getMessage()
            ], 500);
        }
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
