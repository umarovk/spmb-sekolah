<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswas = Siswa::latest()->paginate(10);
        $jumlahData = Siswa::count();
        $datasiswa = Siswa::all();
        $databayar = Pembayaran::all();
        $totalPembayaran = Pembayaran::totalPembayaran();
        $pembayaran = Pembayaran::with('siswa')->get();
        
        // Add this code for chart data
        $jurusanData = [
            'tkj' => Siswa::where('jurusan', 'Teknik Komputer Jaringan')->count(),
            'tsm' => Siswa::where('jurusan', 'Teknik Sepeda Motor')->count()
        ];

        // Add gender chart data
        $genderData = [
            'laki' => Siswa::where('jeniskelamin', 'Laki-laki')->count(),
            'perempuan' => Siswa::where('jeniskelamin', 'Perempuan')->count()
        ];

        // Add payment status chart data
        $paymentStatusData = [
            'sudah_bayar' => Siswa::whereHas('pembayarans')->count(),
            'belum_bayar' => Siswa::whereDoesntHave('pembayarans')->count()
        ];

        // Get all daily registration data
        $dailyRegistrations = Siswa::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'count' => $item->count
                ];
            });

        // Get all daily payment data
        $dailyPayments = Pembayaran::selectRaw('DATE(tanggal_bayar) as date, SUM(nominal) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'total' => $item->total
                ];
            });

        return view('home', compact(
            'jumlahData', 
            'datasiswa', 
            'databayar', 
            'pembayaran', 
            'totalPembayaran',
            'jurusanData',
            'genderData',
            'paymentStatusData',
            'dailyRegistrations',
            'dailyPayments'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('siswa.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'namasiswa' => 'required',
            'jurusan' => 'required',
            'agama' => 'nullable',
            'nik' => 'nullable',
            'jeniskelamin' => 'nullable',
            'nomorsiswa' => 'nullable',
            'tempatlahir' => 'nullable',
            'tanggallahir' => 'nullable',
            'tinggibadan' => 'nullable',
            'beratbadan' => 'nullable',
            'email' => 'nullable',
            'alamat' => 'nullable|string',
            'transport' => 'nullable',
            'sekolah_asal' => 'nullable',
            'npsn' => 'nullable',
            'nisn' => 'nullable',
            'nis' => 'nullable',
            'ijazah' => 'nullable',
            'skhun' => 'nullable',
            'nomorkip' => 'nullable',
            'nomorkps' => 'nullable',
            'nomorkks' => 'nullable',
            'nomorujian_nasional' => 'nullable',
            'jumlah_saudara' => 'nullable',
            'akta_lahir' => 'nullable',
            'kartu_keluarga' => 'nullable',
            'kebutuhan_khusus' => 'nullable',
            'jenis_tinggal' => 'nullable',
            'nama_ayah' => 'nullable',
            'pendidikan_ayah' => 'nullable',
            'tempat_lahir_ayah' => 'nullable',
            'tanggal_lahir_ayah' => 'nullable',
            'alamat_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable',
            'penghasilan_ayah' => 'nullable',
            'nomor_ayah' => 'nullable',
            'nama_ibu' => 'nullable',
            'pendidikan_ibu' => 'nullable',
            'tempat_lahir_ibu' => 'nullable',
            'tanggal_lahir_ibu' => 'nullable',
            'alamat_ibu' => 'nullable',
            'pekerjaan_ibu' => 'nullable',
            'penghasilan_ibu' => 'nullable',
            'nomor_ibu' => 'nullable',
            'nama_wali' => 'nullable',
            'alamat_wali' => 'nullable',
            'nomor_wali' => 'nullable',
            'penghasilan_wali' => 'nullable',
            'asrama_tahfidz' => 'required|in:Bersedia,Tidak',
            'jalurdaftar' => 'required|in:Reguler,Prestasi'
        ]);

        siswa::create([
            'namasiswa' => $request->namasiswa, 
            'jurusan' => $request->jurusan, 
            'jeniskelamin' => $request->jeniskelamin, 
            'agama' => $request->agama, 
            'tempatlahir' => $request->tempatlahir, 
            'tanggallahir' => $request->tanggallahir, 
            'tahunmasuk' => $request->tahunmasuk,

            'nik' => $request->nik, 
            'nisn' => $request->nisn, 
            'nis' => $request->nis, 
            'nomorsiswa' => $request->nomorsiswa, 
            'nomorkip' => $request->nomorkip, 
            'nomorkps' => $request->nomorkps, 
            'nomorkks' => $request->nomorkks,

            'kebutuhan_khusus' => $request->kebutuhan_khusus, 
            'akta_lahir' => $request->akta_lahir, 
            'kartu_keluarga' => $request->kartu_keluarga, 
            'email' => $request->email, 
            'alamat' => $request->alamat,

            'nomorsiswa_kontak' => $request->nomorsiswa_kontak, 
            'sekolah_asal' => $request->sekolah_asal, 
            'npsn' => $request->npsn, 
            'ijazah' => $request->ijazah, 
            'skhun' => $request->skhun,

            'nomor_ujian_nasional' => $request->nomor_ujian_nasional, 
            'tinggibadan' => $request->tinggibadan, 
            'beratbadan' => $request->beratbadan, 
            'transport' => $request->transport,

            'jenis_tinggal' => $request->jenis_tinggal, 
            'jumlah_saudara' => $request->jumlah_saudara, 
            'nama_ayah' => $request->nama_ayah, 
            'pendidikan_ayah' => $request->pendidikan_ayah,

            'tempat_lahir_ayah' => $request->tempat_lahir_ayah, 
            'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah, 
            'alamat_ayah' => $request->alamat_ayah, 
            'pekerjaan_ayah' => $request->pekerjaan_ayah,

            'penghasilan_ayah' => $request->penghasilan_ayah, 
            'nomor_ayah' => $request->nomor_ayah, 
            'nama_ibu' => $request->nama_ibu, 
            'pendidikan_ibu' => $request->pendidikan_ibu,

            'tempat_lahir_ibu' => $request->tempat_lahir_ibu, 
            'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu, 
            'alamat_ibu' => $request->alamat_ibu, 
            'pekerjaan_ibu' => $request->pekerjaan_ibu,

            'penghasilan_ibu' => $request->penghasilan_ibu, 
            'nomor_ibu' => $request->nomor_ibu, 
            'nama_wali' => $request->nama_wali, 
            'alamat_wali' => $request->alamat_wali,

            'nomor_wali' => $request->nomor_wali, 
            'penghasilan_wali' => $request->penghasilan_wali,
            'asrama_tahfidz' => $request->asrama_tahfidz,
            'jalurdaftar' => $request->jalurdaftar,
        ]);

        return redirect()->route('tabelsiswa')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        return view('siswa.show', compact('siswa'));

    }

    /**
     * Show the form for editing the specified resource.
     */

    public function ubah($id)
    {
    $datasiswa = Siswa::findOrFail($id);
    // return view('siswa.editsiswa', compact('datasiswa'));
    return view('siswa.edit', compact('datasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'namasiswa' => 'required',
            'jurusan' => 'required',
            'agama' => 'nullable',
            'nik' => 'nullable',
            'jeniskelamin' => 'nullable',
            'nomorsiswa' => 'nullable',
            'tempatlahir' => 'nullable',
            'tanggallahir' => 'nullable',
            'tinggibadan' => 'nullable',
            'beratbadan' => 'nullable',
            'email' => 'nullable',
            'alamat' => 'nullable|string',
            'transport' => 'nullable',
            'sekolah_asal' => 'nullable',
            'npsn' => 'nullable',
            'nisn' => 'nullable',
            'nis' => 'nullable',
            'ijazah' => 'nullable',
            'skhun' => 'nullable',
            'nomorkip' => 'nullable',
            'nomorkps' => 'nullable',
            'nomorkks' => 'nullable',
            'nomorujian_nasional' => 'nullable',
            'jumlah_saudara' => 'nullable',
            'akta_lahir' => 'nullable',
            'kartu_keluarga' => 'nullable',
            'kebutuhan_khusus' => 'nullable',
            'jenis_tinggal' => 'nullable',
            'nama_ayah' => 'nullable',
            'pendidikan_ayah' => 'nullable',
            'tempat_lahir_ayah' => 'nullable',
            'tanggal_lahir_ayah' => 'nullable',
            'alamat_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable',
            'penghasilan_ayah' => 'nullable',
            'nomor_ayah' => 'nullable',
            'nama_ibu' => 'nullable',
            'pendidikan_ibu' => 'nullable',
            'tempat_lahir_ibu' => 'nullable',
            'tanggal_lahir_ibu' => 'nullable',
            'alamat_ibu' => 'nullable',
            'pekerjaan_ibu' => 'nullable',
            'penghasilan_ibu' => 'nullable',
            'nomor_ibu' => 'nullable',
            'nama_wali' => 'nullable',
            'alamat_wali' => 'nullable',
            'nomor_wali' => 'nullable',
            'penghasilan_wali' => 'nullable',
            'asrama_tahfidz' => 'required|in:Bersedia,Tidak',
            'jalurdaftar' => 'required|in:Reguler,Prestasi'
        ]);

        $datasiswa = Siswa::findOrFail($id);

        $datasiswa->namasiswa = $request->namasiswa; 
            $datasiswa->jurusan = $request->jurusan; 
            $datasiswa->jeniskelamin = $request->jeniskelamin; 
            $datasiswa->agama = $request->agama; 
            $datasiswa->tempatlahir = $request->tempatlahir; 
            $datasiswa->tanggallahir = $request->tanggallahir; 
            $datasiswa->tahunmasuk = $request->tahunmasuk;

            $datasiswa->nik = $request->nik; 
            $datasiswa->nisn = $request->nisn; 
            $datasiswa->nis = $request->nis; 
            $datasiswa->nomorsiswa = $request->nomorsiswa; 
            $datasiswa->nomorkip = $request->nomorkip; 
            $datasiswa->nomorkps = $request->nomorkps; 
            $datasiswa->nomorkks = $request->nomorkks;

            $datasiswa->kebutuhan_khusus = $request->kebutuhan_khusus; 
            $datasiswa->akta_lahir = $request->akta_lahir; 
            $datasiswa->kartu_keluarga = $request->kartu_keluarga; 
            $datasiswa->email = $request->email; 
            $datasiswa->alamat = $request->alamat;

            $datasiswa->nomorsiswa_kontak = $request->nomorsiswa_kontak; 
            $datasiswa->sekolah_asal = $request->sekolah_asal; 
            $datasiswa->npsn = $request->npsn; 
            $datasiswa->ijazah = $request->ijazah; 
            $datasiswa->skhun = $request->skhun;

            $datasiswa->nomor_ujian_nasional = $request->nomor_ujian_nasional; 
            $datasiswa->tinggibadan = $request->tinggibadan; 
            $datasiswa->beratbadan = $request->beratbadan; 
            $datasiswa->transport = $request->transport;

            $datasiswa->jenis_tinggal = $request->jenis_tinggal; 
            $datasiswa->jumlah_saudara = $request->jumlah_saudara; 
            $datasiswa->nama_ayah = $request->nama_ayah; 
            $datasiswa->pendidikan_ayah = $request->pendidikan_ayah;

            $datasiswa->tempat_lahir_ayah = $request->tempat_lahir_ayah; 
            $datasiswa->tanggal_lahir_ayah = $request->tanggal_lahir_ayah; 
            $datasiswa->alamat_ayah = $request->alamat_ayah; 
            $datasiswa->pekerjaan_ayah = $request->pekerjaan_ayah;

            $datasiswa->penghasilan_ayah = $request->penghasilan_ayah; 
            $datasiswa->nomor_ayah = $request->nomor_ayah; 
            $datasiswa->nama_ibu = $request->nama_ibu; 
            $datasiswa->pendidikan_ibu = $request->pendidikan_ibu;

            $datasiswa->tempat_lahir_ibu = $request->tempat_lahir_ibu; 
            $datasiswa->tanggal_lahir_ibu = $request->tanggal_lahir_ibu; 
            $datasiswa->alamat_ibu = $request->alamat_ibu; 
            $datasiswa->pekerjaan_ibu = $request->pekerjaan_ibu;

            $datasiswa->penghasilan_ibu = $request->penghasilan_ibu; 
            $datasiswa->nomor_ibu = $request->nomor_ibu; 
            $datasiswa->nama_wali = $request->nama_wali; 
            $datasiswa->alamat_wali = $request->alamat_wali;

            $datasiswa->nomor_wali = $request->nomor_wali; 
            $datasiswa->penghasilan_wali = $request->penghasilan_wali;
            $datasiswa->asrama_tahfidz = $request->asrama_tahfidz;
            $datasiswa->jalurdaftar = $request->jalurdaftar;

        $datasiswa->save();

    return redirect()->route('siswa.index')->with('success', 'Dokumen berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $datasiswa = Siswa::findOrFail($id);
            
            // Cek apakah siswa memiliki pembayaran
            if ($datasiswa->pembayarans()->exists()) {
                return redirect()
                    ->route('tabelsiswa')
                    ->with('error', 'Tidak dapat menghapus data siswa karena memiliki riwayat pembayaran.');
            }

            $datasiswa->delete();
            return redirect()
                ->route('tabelsiswa')
                ->with('success', 'Data siswa berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->route('tabelsiswa')
                ->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
        }
    }


    public function tabelsiswa(Request $request)
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

        return view('siswa.siswa', compact('datasiswa', 'search', 'perPage'));
    }

    public function test(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);

        $datasiswa = Siswa::when($search, function($query) use ($search) {
                return $query->where('namasiswa', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->paginate($perPage);

        return view('siswa.test', compact('datasiswa', 'search', 'perPage'));
    }

    public function printSuratKeterangan(Siswa $siswa)
    {
        $user = auth()->user();
        $tanggal = $siswa->created_at->translatedFormat('d F Y');
        return view('siswa.surat-keterangan', compact('siswa', 'tanggal', 'user'));
    }


    public function printSuratDiterima (Siswa $siswa)
    {
        $user = auth()->user();
        $tanggal = now()->translatedFormat('d F Y');
        return view('siswa.surat-diterima', compact('siswa', 'tanggal', 'user'));
    }

    public function export() 
    {
        $exporter = new SiswaExport();
        $data = $exporter->export();
        
        $filename = 'data-siswa-' . date('Y-m-d') . '.csv';
        $filepath = storage_path('app/public/' . $filename);
        
        // Create CSV file
        $fp = fopen($filepath, 'w');
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
        
        // Return download response
        return response()->download($filepath, $filename, [
            'Content-Type' => 'text/csv',
        ])->deleteFileAfterSend();
    }

    public function rangkuman()
    {
        // Total Pendaftar
        $totalPendaftar = [
            'total' => Siswa::count(),
            'tkj' => Siswa::where('jurusan', 'Teknik Komputer Jaringan')->count(),
            'tsm' => Siswa::where('jurusan', 'Teknik Sepeda Motor')->count()
        ];

        // Siswa Diterima
        $siswaDiterima = [
            'total' => Siswa::where('status_seleksi', 'diterima')->count(),
            'tkj' => Siswa::where('jurusan', 'Teknik Komputer Jaringan')
                         ->where('status_seleksi', 'diterima')
                         ->count(),
            'tsm' => Siswa::where('jurusan', 'Teknik Sepeda Motor')
                         ->where('status_seleksi', 'diterima')
                         ->count()
        ];

        // Siswa Ditolak
        $siswaDitolak = [
            'total' => Siswa::where('status_seleksi', 'ditolak')->count(),
            'tkj' => Siswa::where('jurusan', 'Teknik Komputer Jaringan')
                         ->where('status_seleksi', 'ditolak')
                         ->count(),
            'tsm' => Siswa::where('jurusan', 'Teknik Sepeda Motor')
                         ->where('status_seleksi', 'ditolak')
                         ->count()
        ];

        // Siswa Dipertimbangkan
        $siswaDipertimbangkan = [
            'total' => Siswa::where('status_seleksi', 'dipertimbangkan')->count(),
            'tkj' => Siswa::where('jurusan', 'Teknik Komputer Jaringan')
                         ->where('status_seleksi', 'dipertimbangkan')
                         ->count(),
            'tsm' => Siswa::where('jurusan', 'Teknik Sepeda Motor')
                         ->where('status_seleksi', 'dipertimbangkan')
                         ->count()
        ];

        // Siswa Belum Seleksi
        $siswaBelumSeleksi = [
            'total' => Siswa::where('status_seleksi', 'pending')->count(),
            'tkj' => Siswa::where('jurusan', 'Teknik Komputer Jaringan')
                         ->where('status_seleksi', 'pending')
                         ->count(),
            'tsm' => Siswa::where('jurusan', 'Teknik Sepeda Motor')
                         ->where('status_seleksi', 'pending')
                         ->count()
        ];

        // Siswa Sudah DU
        $siswaSudahDU = [
            'total' => Siswa::whereHas('pembayarans')->count(),
            'tkj' => Siswa::where('jurusan', 'Teknik Komputer Jaringan')
                         ->whereHas('pembayarans')
                         ->count(),
            'tsm' => Siswa::where('jurusan', 'Teknik Sepeda Motor')
                         ->whereHas('pembayarans')
                         ->count()
        ];

        // Total Transaksi DU
        $totalTransaksiDU = Pembayaran::sum('nominal');

        return view('siswa.rangkuman', compact(
            'totalPendaftar',
            'siswaDiterima',
            'siswaDitolak',
            'siswaDipertimbangkan',
            'siswaBelumSeleksi',
            'siswaSudahDU',
            'totalTransaksiDU'
        ));
    }
}
