<?php

namespace App\Events;

use App\Models\DaftarPoli;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AntrianUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $idJadwal;
    public $antrianSekarang;

    public function __construct($idJadwal)
    {
        $this->idJadwal = $idJadwal;

        // Ambil nomor antrian terakhir yang sudah selesai diperiksa
        $terakhirDiperiksa = DaftarPoli::where('id_jadwal', $idJadwal)
            ->whereHas('periksa')
            ->max('no_antrian');

        $this->antrianSekarang = $terakhirDiperiksa ? ($terakhirDiperiksa + 1) : 1;
    }

    // Siarkan ke public channel berdasarkan ID Jadwal
    public function broadcastOn(): array
    {
        return [
            new Channel('antrian.jadwal.' . $this->idJadwal),
        ];
    }

    public function broadcastAs(): string
    {
        return 'AntrianUpdated';
    }
}