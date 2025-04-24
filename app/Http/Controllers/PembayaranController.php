<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\View\View;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PembayaranController extends Controller
{
    // Menampilkan daftar pembayaran

    public function index(){

        $pembayarans = Pembayaran::with('siswa')->latest()->paginate(10);
        return view('pembayarans.index', compact('pembayarans'));
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_pembayaran' => 'required|string|max:255',
            'jumlah' => 'required|numeric',
            'tanggal_pembayaran' => 'required|date',
            'metode_pembayaran' => 'required|string|max:255',
            'status_pembayaran' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'bukti_pembayaran' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');
            $validated['bukti_pembayaran'] = $path;
        }

        Pembayaran::create($validated);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil ditambahkan');
    }



    public function indexo()
    {
        $pembayaran = Pembayaran::with('siswa')->get();
        $datasiswa = Siswa::all();
        return view('pembayaran.indexbayar', compact('pembayaran', 'datasiswa'));
        // return view('pembayaran.indexbayar');
    }

    public function indexpembayaran(): View
    {
        $jumlahData = siswa::count();
        $datasiswa = siswa::all();
        $databayar = Pembayaran::all();
        $totalPembayaran = Pembayaran::hitungTotalSeluruhPembayaran();
        $pembayaran = Pembayaran::with('siswa')->get();
        return view('pembayaran.tambahbayar', compact('jumlahData', 'datasiswa', 'databayar', 'totalPembayaran', 'pembayaran'));

    }

    // Menampilkan form tambah pembayaran
    public function create()
    {
        //cek apakah funtion ini terhubung ke database siswa
        $siswas = Siswa::orderBy('nama')->get();
        return view('pembayarans.createbayar', compact('siswas'));
    }

    // Menghapus data pembayaran
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil dihapus');
        
    }

    

    // // Menyimpan data pembayaran baru
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'siswa_id' => 'required|exists:Siswa,id',
    //         'jenis_pembayaran' => 'required',
    //         'jumlah' => 'required|numeric',
    //         'tanggal_pembayaran' => 'required|date',
    //         'metode_pembayaran' => 'required',
    //         'status_pembayaran' => 'required',
    //         'keterangan' => 'nullable',
    //         'bukti_pembayaran' => 'nullable',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     $data = $request->all();

    //     Pembayaran::create($data);
    //     return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil ditambahkan');
    // }

    // Menampilkan detail pembayaran
    public function show($id)
    {
        $pembayaran = Pembayaran::with('siswa')->findOrFail($id);
        return view('pembayaran.show', compact('pembayaran'));
    }

    // Menampilkan form edit pembayaran
    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $siswa = Siswa::all();
        return view('pembayaran.edit', compact('pembayaran', 'siswa'));
    }

    // Memperbarui data pembayaran
    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pembayaran' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal_pembayaran' => 'required|date',
            'metode_pembayaran' => 'required',
            'status_pembayaran' => 'required',
            'keterangan' => 'nullable',
            'bukti_pembayaran' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        $pembayaran->update($data);
        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil diperbarui');
    

    }

    

    // Menampilkan daftar pembayaran berdasarkan siswa
    public function getBySiswa($siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        // $pembayaran = Pembayaran::where('siswa_id', $siswa_id)->get();
        // return view('pembayaran.by_siswa', compact('pembayaran', 'siswa'));
        return view('pembayaran.by_siswa', compact('siswa'));
    }

    
}
