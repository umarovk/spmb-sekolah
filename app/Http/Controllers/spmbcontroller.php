<?php

namespace App\Http\Controllers;

use App\Models\siswa;
use App\Models\Pembayaran;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class spmbcontroller extends Controller
{
    public function index(): View
    {
        $jumlahData = siswa::count();
        $datasiswa = siswa::all();
        $databayar = Pembayaran::all();
        $totalPembayaran = Pembayaran::hitungTotalSeluruhPembayaran();
        $pembayaran = Pembayaran::with('siswa')->get();
        return view('home', compact('jumlahData', 'datasiswa', 'databayar', 'totalPembayaran', 'pembayaran'));
    }


    

    public function tabelpembayaran(): View{
        $datasiswa = Siswa::all();
        $datapembayaran = Pembayaran::with('siswa')->get();
        return view('pembayaran.tabelpembayaran', compact('datapembayaran', 'datasiswa'));
    }

    // Menampilkan detail siswa
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }

    public function createsiswa(): View
    {
        return view('siswa.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        //validate form
        $request->validate([
            'nama' => 'required',
            'jurusan' => 'required',
            'agama' => 'nullable',
            'gender' => 'nullable',
            'nik' => 'nullable',
            'hpsiswa' => 'nullable',
            'tempatlahir' => 'nullable',
            'tanggallahir' => 'nullable',
            'beratbadan' => 'nullable',
            'tinggibadan' => 'nullable',
            'alamat' => 'nullable',
            'email' => 'nullable',
            'nama_wali' => 'nullable',
            'no_telepon_wali' => 'nullable',
            'tahun_masuk' => 'nullable',
            
        ]);

        //upload image
        // $image = $request->file('image');
        // $image->storeAs('public/posts', $image->hashName());

        //create (model)::create
        siswa::create([
            'nama'     => $request->nama,
            'jurusan'   => $request->jurusan,
            'agama'   => $request->agama,
            'gender'   => $request->gender,
            'nik' => $request->nik,
            'hpsiswa' => $request->hpsiswa,
            'tempatlahir' => $request->tempatlahir,
            'tanggallahir' => $request->tanggallahir,
            'beratbadan' => $request->beratbadan,
            'tinggibadan' => $request->tinggibadan,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'nama_wali' => $request->nama_wali,
            'no_telepon_wali' => $request->no_telepon_wali,
            'tahun_masuk' => $request->tahun_masuk
        ]);

        //redirect to index
        // return redirect()->route('documents.index')->with(['success' => 'Data Berhasil Disimpan!']);
        $datasiswa = siswa::all();
        return view('siswa.siswa', compact('datasiswa'));
    }

    public function edit($id)
    {
        $datasiswa = siswa::findOrFail($id);
        return view('siswa.editsiswa', compact('datasiswa'));
    }

    public function update(Request $request, $id)
    {
            $request->validate([
                'nama' => 'required',
                'jurusan' => 'required',
                'agama' => 'nullable',
                'gender' => 'nullable',
                'nik' => 'nullable',
                'hpsiswa' => 'nullable',
                'tempatlahir' => 'nullable',
                'tanggallahir' => 'nullable',
                'beratbadan' => 'nullable',
                'tinggibadan' => 'nullable',
                'alamat' => 'nullable',
                'email' => 'nullable',
                'nama_wali' => 'nullable',
                'no_telepon_wali' => 'nullable',
                'tahun_masuk' => 'nullable',
            ]);

            $datasiswa = siswa::findOrFail($id);
            $datasiswa->nama = $request->nama;
            $datasiswa->jurusan = $request->jurusan;
            $datasiswa->agama = $request->agama;
            $datasiswa->gender = $request->gender;
            $datasiswa->nik = $request->nik;
            $datasiswa->hpsiswa = $request->hpsiswa;
            $datasiswa->tempatlahir = $request->tempatlahir;
            $datasiswa->tanggallahir = $request->tanggallahir;
            $datasiswa->beratbadan = $request->beratbadan;
            $datasiswa->tinggibadan = $request->tinggibadan;
            $datasiswa->alamat = $request->alamat;
            $datasiswa->email = $request->email;
            $datasiswa->nama_wali = $request->nama_wali; 
            $datasiswa->no_telepon_wali = $request->no_telepon_wali;
            $datasiswa->tahun_masuk = $request->tahun_masuk;
            $datasiswa->save();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diupdate.');
    }

    public function destroy($id)
    {
        $datasiswa = siswa::findOrFail($id);
        $datasiswa->delete();
    
        return redirect()->route('documents.index')->with('success', 'Data berhasil dihapus.');
    }

    public function count()
    {
        $jumlahData = siswa::count();

        return view('home', compact('jumlahData'));
    }
}
