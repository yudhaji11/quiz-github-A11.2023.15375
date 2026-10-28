<?php

namespace App\Notifications;

use App\Models\Periksa;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranDiverifikasi extends Notification
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
        return [
            'periksa_id' => $this->periksa->id,
            'title' => 'Pembayaran Terverifikasi',
            'pesan' => 'Bukti pembayaran Anda telah diverifikasi oleh admin. Status pembayaran: LUNAS.',
            'url' => route('pasien.pembayaran.index'),
            'icon' => 'fas fa-check-circle',
        ];
    }
}