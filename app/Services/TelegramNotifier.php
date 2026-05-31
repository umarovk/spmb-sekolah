<?php

namespace App\Services;

use App\Models\AppSetting;
use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotifier
{
    public function isEnabled(): bool
    {
        return AppSetting::get('telegram_enabled') === '1'
            && filled($this->token())
            && filled($this->chatId());
    }

    public function token(): ?string
    {
        return AppSetting::get('telegram_bot_token');
    }

    public function chatId(): ?string
    {
        return AppSetting::get('telegram_chat_id');
    }

    public function notifySiswaEnabled(): bool
    {
        return AppSetting::get('telegram_notify_siswa') === '1';
    }

    public function notifyPaymentEnabled(): bool
    {
        return AppSetting::get('telegram_notify_payment') === '1';
    }

    /**
     * Kirim pesan ke chat yang dikonfigurasi.
     * @return array{ok: bool, message?: string, response?: array}
     */
    public function sendMessage(string $text, ?string $token = null, ?string $chatId = null): array
    {
        $token  = $token  ?: $this->token();
        $chatId = $chatId ?: $this->chatId();

        if (! $token || ! $chatId) {
            return ['ok' => false, 'message' => 'Token atau chat_id Telegram belum di-set.'];
        }

        try {
            $response = Http::timeout(10)
                ->asJson()
                ->withoutVerifying()
                ->post("https://api.telegram.org/bot{$token}/sendMessage", [
                    'chat_id'    => $chatId,
                    'text'       => $text,
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ]);

            $json = $response->json();

            if ($response->successful() && ($json['ok'] ?? false)) {
                return ['ok' => true, 'response' => $json];
            }

            $err = $json['description'] ?? ('HTTP ' . $response->status());
            return ['ok' => false, 'message' => $err, 'response' => $json];
        } catch (\Throwable $e) {
            Log::warning('Telegram sendMessage failed', ['error' => $e->getMessage()]);
            return ['ok' => false, 'message' => $e->getMessage()];
        }
    }

    public function notifySiswaBaru(Siswa $siswa): void
    {
        if (! $this->isEnabled() || ! $this->notifySiswaEnabled()) {
            return;
        }

        $now = Carbon::now('Asia/Jakarta')->translatedFormat('d F Y, H:i') . ' WIB';
        $sekolah = AppSetting::get('app_name') ?: 'SPMB Sekolah';

        $lines = [
            "🎓 <b>Pendaftar Baru</b>",
            "<i>{$sekolah}</i>",
            "",
            "👤 <b>" . e($siswa->namasiswa) . "</b>",
            "🎯 Jurusan: <b>" . e($siswa->jurusan ?: '-') . "</b>",
            "📋 Jalur: " . e($siswa->jalurdaftar ?: '-'),
        ];

        if ($siswa->nisn) {
            $lines[] = "🔢 NISN: <code>" . e($siswa->nisn) . "</code>";
        }
        if ($siswa->sekolah_asal) {
            $lines[] = "🏫 Asal: " . e($siswa->sekolah_asal);
        }
        if ($siswa->nomorsiswa_kontak ?? $siswa->nomor_ayah ?? $siswa->nomor_ibu ?? null) {
            $kontak = $siswa->nomorsiswa_kontak ?: $siswa->nomor_ayah ?: $siswa->nomor_ibu;
            $lines[] = "📞 Kontak: " . e($kontak);
        }

        $lines[] = "";
        $lines[] = "🕐 " . $now;

        $this->sendMessage(implode("\n", $lines));
    }

    public function notifyPembayaran(Pembayaran $payment): void
    {
        if (! $this->isEnabled() || ! $this->notifyPaymentEnabled()) {
            return;
        }

        $payment->loadMissing('siswa');
        $now = Carbon::now('Asia/Jakarta')->translatedFormat('d F Y, H:i') . ' WIB';
        $sekolah = AppSetting::get('app_name') ?: 'SPMB Sekolah';
        $nominal = 'Rp ' . number_format((float) $payment->nominal, 0, ',', '.');

        $lines = [
            "💰 <b>Pembayaran Masuk</b>",
            "<i>{$sekolah}</i>",
            "",
            "👤 Siswa: <b>" . e(optional($payment->siswa)->namasiswa ?: '-') . "</b>",
            "🎯 Jurusan: " . e(optional($payment->siswa)->jurusan ?: '-'),
            "📝 Jenis: <b>" . e($payment->nama_pembayaran ?: '-') . "</b>",
            "💵 Nominal: <b>{$nominal}</b>",
            "🔖 Kode: <code>" . e($payment->kode_bayar ?: '-') . "</code>",
            "👨‍💼 Teller: " . e($payment->teller ?: '-'),
        ];

        if ($payment->keterangan) {
            $lines[] = "📌 Ket: " . e($payment->keterangan);
        }

        $lines[] = "";
        $lines[] = "🕐 " . $now;

        $this->sendMessage(implode("\n", $lines));
    }
}
