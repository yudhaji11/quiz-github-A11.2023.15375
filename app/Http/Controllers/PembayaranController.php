<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Notifications\PembayaranDiverifikasi;
use App\Notifications\BuktiPembayaranUploaded;

class PembayaranController extends Controller
{
    // ==========================================
    // SISI PASIEN
    // ==========================================

    // Menampilkan daftar tagihan pasien yang sedang login
    public function indexPasien()
    {
        $tagihans = Periksa::with(['daftarPoli.jadwalPeriksa.poli', 'daftarPoli.jadwalPeriksa.dokter'])
            ->whereHas('daftarPoli', function ($query) {
                $query->where('id_pasien', Auth::id());
            })
            ->latest('tgl_periksa')
            ->paginate(10);

        return view('pasien.pembayaran.index', compact('tagihans'));
    }

    // Proses upload bukti pembayaran oleh pasien
   public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'bukti_pembayaran.required' => 'File bukti transfer wajib diunggah.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2 MB.',
        ]);

        // Kunci akses: hanya cari tagihan yang benar-benar milik pasien yang sedang login
        $periksa = Periksa::with('daftarPoli.jadwalPeriksa.dokter')
            ->whereHas('daftarPoli', function ($query) {
                $query->where('id_pasien', auth()->id());
            })
            ->findOrFail($id);

        if ($periksa->status_pembayaran === 'lunas') {
            return back()->with('error', 'Tagihan ini sudah lunas.');
        }

        // Hapus file lama jika sebelumnya pernah upload
        if ($periksa->bukti_pembayaran && Storage::disk('public')->exists($periksa->bukti_pembayaran)) {
            Storage::disk('public')->delete($periksa->bukti_pembayaran);
        }

        // Simpan file baru
        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $periksa->update([
            'bukti_pembayaran' => $path,
            'status_pembayaran' => 'menunggu_verifikasi',
            'tgl_bayar' => now(),
        ]);

        // Kirim Notifikasi ke Dokter Pemeriksa
        $dokter = $periksa->daftarPoli->jadwalPeriksa->dokter ?? null;
        if ($dokter) {
            $dokter->notify(new BuktiPembayaranUploaded($periksa));
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
    // ==========================================
    // SISI ADMIN
    // ==========================================

    // Menampilkan daftar pembayaran yang menunggu verifikasi atau sudah lunas
    public function indexAdmin()
    {
        $pembayarans = Periksa::with([
            'daftarPoli.pasien',
            'daftarPoli.jadwalPeriksa.poli',
            'daftarPoli.jadwalPeriksa.dokter'
        ])
        ->whereNotNull('bukti_pembayaran')
        ->latest('tgl_bayar')
        ->paginate(15);

        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    // Aksi admin mengonfirmasi pembayaran menjadi LUNAS
   public function konfirmasiAdmin($id)
    {
        $periksa = Periksa::with('daftarPoli.pasien')->findOrFail($id);

        $periksa->update([
            'status_pembayaran' => 'lunas',
        ]);

        // Kirim Notifikasi ke Pasien
        $pasien = $periksa->daftarPoli->pasien ?? null;
        if ($pasien) {
            $pasien->notify(new PembayaranDiverifikasi($periksa));
        }

        return back()->with('success', 'Pembayaran berhasil diverifikasi dan berstatus LUNAS.');
    }
}