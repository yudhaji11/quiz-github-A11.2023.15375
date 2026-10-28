<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil pendaftaran poli aktif milik pasien yang belum selesai diperiksa
        $antrianAktif = DaftarPoli::with(['jadwalPeriksa.dokter', 'jadwalPeriksa.poli'])
            ->where('id_pasien', $user->id)
            ->whereDoesntHave('periksa')
            ->latest('id')
            ->first();

        $antrianSekarang = 0;
        $sisaAntrian = 0;

        if ($antrianAktif) {
            // Ambil nomor antrian terakhir yang sudah diperiksa pada jadwal tersebut
            $antrianTerakhirDiperiksa = DaftarPoli::where('id_jadwal', $antrianAktif->id_jadwal)
                ->whereHas('periksa')
                ->max('no_antrian');

            $antrianSekarang = $antrianTerakhirDiperiksa ? ($antrianTerakhirDiperiksa + 1) : 1;

            if ($antrianSekarang > $antrianAktif->no_antrian) {
                $antrianSekarang = $antrianAktif->no_antrian;
            }

            // Hitung pasien yang belum diperiksa sebelum nomor antrian ini
            $sisaAntrian = DaftarPoli::where('id_jadwal', $antrianAktif->id_jadwal)
                ->where('no_antrian', '<', $antrianAktif->no_antrian)
                ->whereDoesntHave('periksa')
                ->count();
        }

        // Statistik ringkas untuk kartu dashboard
        $totalPendaftaran = DaftarPoli::where('id_pasien', $user->id)->count();
        $totalSelesai = DaftarPoli::where('id_pasien', $user->id)->whereHas('periksa')->count();

        return view('pasien.dashboard', compact(
            'user',
            'antrianAktif',
            'antrianSekarang',
            'sisaAntrian',
            'totalPendaftaran',
            'totalSelesai'
        ));
    }
}