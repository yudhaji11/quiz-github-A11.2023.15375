<?php

namespace App\Notifications;

use App\Models\Periksa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BuktiPembayaranUploaded extends Notification
{
    use Queueable;

    protected $periksa;

    public function __construct(Periksa $periksa)
    {
        $this->periksa = $periksa;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $namaPasien = $this->periksa->daftarPoli->pasien->nama 
            ?? $this->periksa->daftarPoli->pasien->name 
            ?? 'Pasien';

        // Cek apakah route dokter riwayat ada, jika tidak gunakan url fallback
        $targetUrl = \Illuminate\Support\Facades\Route::has('dokter.riwayat.index')
            ? route('dokter.riwayat.index')
            : (\Illuminate\Support\Facades\Route::has('dokter.riwayat-pasien.index')
                ? route('dokter.riwayat-pasien.index')
                : url('/dokter/riwayat-pasien'));

        return [
            'periksa_id' => $this->periksa->id,
            'title' => 'Bukti Pembayaran Masuk',
            'pesan' => "Pasien {$namaPasien} telah mengunggah bukti pembayaran.",
            'url' => $targetUrl,
            'icon' => 'fas fa-receipt',
        ];
    }
}