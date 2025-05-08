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
        $perPage = $request->input('perPage', 10);

        $datasiswa = Siswa::when($search, function($query) use ($search) {
            return $query->where('namasiswa', 'LIKE', "%{$search}%")
                        ->orWhere('jurusan', 'LIKE', "%{$search}%")
                        ->orWhere('jeniskelamin', 'LIKE', "%{$search}%")
                        ->orWhere('agama', 'LIKE', "%{$search}%")
                        ->orWhere('asrama_tahfidz', 'LIKE', "%{$search}%");
        })
            ->latest()
            ->paginate($perPage);

        return view('seleksi.dataseleksi', compact('datasiswa', 'search', 'perPage'));
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
}
