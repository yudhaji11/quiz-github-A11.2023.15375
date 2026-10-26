<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    // Halaman List Riwayat Pendaftaran Pasien
    public function index()
    {
        // Eager loading optimal untuk mencegah N+1 query problem
        $riwayats = DaftarPoli::with([
            'jadwalPeriksa.dokter',
            'jadwalPeriksa.poli',
            'periksa'
        ])
        ->where('id_pasien', Auth::id())
        ->latest('id')
        ->paginate(10);

        return view('pasien.riwayat.index', compact('riwayats'));
    }

    // Halaman Detail Hasil Pemeriksaan & Biaya
    public function show($id)
    {
        // Cari pendaftaran yang hanya milik pasien yang sedang login (keamanan akses)
        $daftarPoli = DaftarPoli::with([
            'jadwalPeriksa.dokter',
            'jadwalPeriksa.poli',
            'periksa.detailPeriksas.obat'
        ])
        ->where('id_pasien', Auth::id())
        ->findOrFail($id);

        if (!$daftarPoli->periksa) {
            return redirect()->route('pasien.riwayat.index')
                ->with('error', 'Pemeriksaan untuk pendaftaran ini belum dilakukan.');
        }

        return view('pasien.riwayat.detail', compact('daftarPoli'));
    }
}