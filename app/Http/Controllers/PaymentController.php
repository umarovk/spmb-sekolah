<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Exports\PaymentExport;
use App\Exports\PaymentExport2;
use App\Services\TelegramNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Dompdf\Dompdf;

class PaymentController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $payment_status = $request->input('payment_status');
        $per_page = $request->input('per_page', 10);

        $siswas = Siswa::with(['pembayarans' => function($query) {
            $query->latest();
        }])
        ->when($search, function($query) use ($search) {
            return $query->where('namasiswa', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
        })
        ->when($payment_status === 'has_payment', function($query) {
            return $query->whereHas('pembayarans');
        })
        ->when($payment_status === 'no_payment', function($query) {
            return $query->whereDoesntHave('pembayarans');
        })
        ->orderByDesc(function($query) {
            $query->select('created_at')
                  ->from('pembayarans')
                  ->whereColumn('siswa_id', 'siswas.id')
                  ->latest()
                  ->limit(1);
        })
        ->paginate($per_page);

        return view('payments.index', compact('siswas', 'search', 'payment_status', 'per_page'));
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
        $request->validate([
            'nominal' => 'required|integer|not_in:0',
            'siswa_id' => 'required|exists:siswas,id',
            'nama_pembayaran' => 'required|string|max:255',
            'jenis_pembayaran' => 'required|in:debit,credit',
            'keterangan' => 'nullable|string',
            'tanggal_bayar' => 'required|date',
        ]);

        try {
            // Generate kode bayar
            $lastPayment = Pembayaran::whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->latest()
                                    ->first();

            $lastNumber = $lastPayment ? intval(substr($lastPayment->kode_bayar, -4)) : 0;
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            $kodeBayar = 'PYM-' . date('Ym') . '-' . $newNumber;

            // Apply negative value if it's a credit/pengembalian
            $nominal = (int) $request->nominal;
            if ($request->jenis_pembayaran === 'credit') {
                $nominal = -abs($nominal);
            } else {
                $nominal = abs($nominal);
            }

            $payment = Pembayaran::create([
                'siswa_id' => $request->siswa_id,
                'kode_bayar' => $kodeBayar,
                'nama_pembayaran' => $request->nama_pembayaran,
                'nominal' => $nominal,
                'keterangan' => $request->keterangan,
                'tanggal_bayar' => $request->tanggal_bayar,
                'teller' => auth()->user()->name ?? 'Admin',
            ]);

            try {
                app(TelegramNotifier::class)->notifyPembayaran($payment);
            } catch (\Throwable $e) {
                \Log::warning('Gagal kirim notif Telegram pembayaran: ' . $e->getMessage());
            }

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
    public function edit($id)
    {
        $bayar = Pembayaran::with('siswa')->findOrFail($id);
        return view('payments.edit', compact('bayar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pembayaran' => 'required|string',
            'nominal' => 'required|numeric|min:1',
            'tanggal_bayar' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $payment = Pembayaran::findOrFail($id);
        $payment->update($request->all());

        return redirect()
            ->route('payments.show', $payment->siswa_id)
            ->with('success', 'Pembayaran berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $payment)
    {
        try {
            $payment->delete();
            return redirect()
                ->route('payments.show', $payment->siswa_id)
                ->with('success', 'Pembayaran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->route('payments.show', $payment->siswa_id)
                ->with('error', 'Gagal menghapus pembayaran');
        }
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
        // Redirect to kwitansi-kembalian if nominal is negative
        if ($payment->nominal < 0) {
            return redirect()->route('payments.print.kwitansi-kembalian', $payment->id);
        }
        return view('payments.kwitansi', compact('payment', 'user'));
    }

    public function printKwitansiKembalian(Pembayaran $payment)
    {
        $user = auth()->user();
        return view('payments.kwitansi-kembalian', compact('payment', 'user'));
    }

    public function printPdf(Pembayaran $payment)
    {
        $pdf = new Dompdf('payments.kwitansi', compact('payment'));
        return $pdf->stream('kwitansi-'.$payment->kode_bayar.'.pdf');
    }

    public function export() 
    {
        $exporter = new PaymentExport();
        $data = $exporter->export();
        
        $filename = 'data-pembayaran-' . date('Y-m-d') . '.csv';
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

    public function export2() 
    {
        $exporter = new PaymentExport2();
        $data = $exporter->export();
        
        $filename = 'data-pembayaran-' . date('Y-m-d') . '.csv';
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
}