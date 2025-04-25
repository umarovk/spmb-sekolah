<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $siswa = Siswa::when($keyword, function($query) use ($keyword) {
        $query->where('nama', 'like', "%$keyword%")
              ->orWhere('nis', 'like', "%$keyword%");
    })->get();

    return view('payments.index', compact('siswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $siswa = Siswa::findOrFail($request->input('siswa_id'));
        return view('payments.create', compact('siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $data = $request->all();
        // $bayar = \App\Models\Pembayaran::create($data);
    
        // dd($bayar);

        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_pembayaran' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'tanggal_bayar' => 'required|date',
        ]);

        // Generate kode bayar: PYM-tahun-bulan-4 digit nomor urut
        $lastPayment = Pembayaran::whereMonth('created_at', now()->month)
                             ->whereYear('created_at', now()->year)
                             ->latest()
                             ->first();
        
        $lastNumber = $lastPayment ? intval(substr($lastPayment->kode_bayar, -4)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $kodeBayar = 'PYM-' . date('Ym') . '-' . $newNumber;

        // Simpan pembayaran
        $payment = Pembayaran::create([
            'siswa_id' => $request->siswa_id,
            'kode_bayar' => $kodeBayar,
            'nama_pembayaran' => $request->nama_pembayaran,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'tanggal_bayar' => $request->tanggal_bayar,
            'teller' => Auth::user()->name ?? 'Admin',
        ]);

        return redirect()->route('payments.show', $payment->id)
                         ->with('success', 'Pembayaran berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($siswa_id)
    {
        $siswa = \App\Models\Siswa::with('pembayarans')->findOrFail($siswa_id); // <= penting!
        return view('payments.show', compact('siswa'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $payment)
    {
        $siswaList = Siswa::all();
        return view('payments.edit', compact('payment', 'siswaList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $payment)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_pembayaran' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'tanggal_bayar' => 'required|date',
        ]);

        $payment->update([
            'siswa_id' => $request->siswa_id,
            'nama_pembayaran' => $request->nama_pembayaran,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'tanggal_bayar' => $request->tanggal_bayar,
            'teller' => $request->teller ?? $payment->teller,
        ]);

        return redirect()->route('payments.show', $payment->id)
                         ->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')
                         ->with('success', 'Data pembayaran berhasil dihapus.');
    }

    /**
     * Display payments for a specific student.
     */
    public function bySiswa($siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        $payments = Pembayaran::where('siswa_id', $siswa_id)->latest()->paginate(10);
        
        return view('payments.by_siswa', compact('payments', 'siswa'));
    }

    public function PaymentPerSiswa($siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        $payments = Pembayaran::where('siswa_id', $siswa_id)->latest()->paginate(10);
        
        return view('payments.payment_per_siswa', compact('payments', 'siswa'));
    }
}