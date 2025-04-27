<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Dompdf\Dompdf;

class PaymentController extends Controller
{

    public function test(Request $request)
    {
        $datasiswa = Siswa::all();
        return view('siswa.test', compact('datasiswa'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->input('search');
    $siswas = Siswa::when($search, function($query) use ($search) {
            return $query->where('namasiswa', 'LIKE', "%{$search}%");
        })
        ->with('pembayarans')
        ->get();
    
    return view('payments.index', compact('siswas', 'search'));
}

    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $siswa = Siswa::findOrFail($request->siswa_id);
        return view('payments.create', compact('siswa', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_pembayaran' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'tanggal_bayar' => 'required|date',
        ]);

        // Generate kode bayar
        $lastPayment = Pembayaran::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->latest()
                                ->first();
        
        $lastNumber = $lastPayment ? intval(substr($lastPayment->kode_bayar, -4)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $kodeBayar = 'PYM-' . date('Ym') . '-' . $newNumber;

        $payment = Pembayaran::create([
            'siswa_id' => $request->siswa_id,
            'kode_bayar' => $kodeBayar,
            'nama_pembayaran' => $request->nama_pembayaran,
            'nominal' => $request->nominal,
            'keterangan' => $request->keterangan,
            'tanggal_bayar' => $request->tanggal_bayar,
            'teller' => auth()->user()->name ?? 'Admin',
        ]);

        return redirect()->route('payments.show', $request->siswa_id)
                        ->with('success', 'Pembayaran berhasil disimpan.');

    } catch (\Exception $e) {
        return redirect()->back()
                        ->withInput()
                        ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    /**
     * Display the specified resource.
     */
    public function show($siswa_id)
    {
        $siswa = Siswa::with('pembayarans')->findOrFail($siswa_id);
        return view('payments.show', compact('siswa'));
    }

    public function paymentsdetailsiswa(Pembayaran $siswa_id)
    {
        $siswa = Siswa::findOrFail($siswa_id);
        $riwayatPembayaran = Pembayaran::where('siswa_id', $siswa_id)->get();

        return view('payments.detailsiswa', compact('siswa', 'riwayatPembayaran'));
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





    public function printKwitansi(Pembayaran $payment)
    {
        $user = auth()->user();
        return view('payments.kwitansi', compact('payment', 'user'));
    }

    public function printPdf(Pembayaran $payment)
    {
        $pdf = new Dompdf('payments.kwitansi', compact('payment'));
        return $pdf->stream('kwitansi-'.$payment->kode_bayar.'.pdf');
    }



}