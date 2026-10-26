<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Obat;
use App\Models\JadwalPeriksa;
use App\Models\Periksa;

class ExportController extends Controller
{
    // Helper untuk membuat format Excel tabel rapi (.xls)
    private function downloadExcelHtml(string $filename, array $headers, array $rows)
    {
        $output = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        $output .= '<head><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
        $output .= '<style>
            table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; font-size: 11pt; }
            th { background-color: #2563eb; color: #ffffff; font-weight: bold; padding: 8px 12px; border: 1px solid #cbd5e1; text-align: left; }
            td { padding: 6px 10px; border: 1px solid #e2e8f0; vertical-align: top; }
            .str { mso-number-format:"\@"; } /* Mencegah No. RM / KTP terpotong nol depannya */
            .num { mso-number-format:"\#\,\#\#0"; text-align: right; }
        </style>';
        $output .= '</head><body>';
        $output .= '<table>';

        // Header Tabel
        $output .= '<tr>';
        foreach ($headers as $th) {
            $output .= '<th>' . htmlspecialchars($th) . '</th>';
        }
        $output .= '</tr>';

        // Baris Data
        foreach ($rows as $row) {
            $output .= '<tr>';
            foreach ($row as $cell) {
                // Beri kelas .str agar nomor KTP/RM tetap teks di Excel
                $class = is_numeric($cell) && strlen((string)$cell) > 5 ? 'str' : '';
                $output .= '<td class="' . $class . '">' . htmlspecialchars((string)$cell) . '</td>';
            }
            $output .= '</tr>';
        }

        $output .= '</table></body></html>';

        return response($output, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}.xls\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }

    // 1. Export Data Dokter (Role Admin)
    public function exportDokter()
    {
        $headers = ['ID', 'Nama Dokter', 'Alamat', 'No. HP', 'Email'];
        $dokters = User::whereRaw('LOWER(role) = ?', ['dokter'])->get();
        
        $rows = [];
        foreach ($dokters as $d) {
            $rows[] = [
                $d->id,
                $d->nama ?? $d->name ?? '-',
                $d->alamat ?? '-',
                $d->no_hp ?? '-',
                $d->email,
            ];
        }

        return $this->downloadExcelHtml('data-dokter', $headers, $rows);
    }

    // 2. Export Data Pasien (Role Admin)
    public function exportPasien()
    {
        $headers = ['ID', 'No. RM', 'Nama Pasien', 'No. KTP', 'No. HP', 'Alamat', 'Email'];
        $pasiens = User::whereRaw('LOWER(role) = ?', ['pasien'])->get();

        $rows = [];
        foreach ($pasiens as $p) {
            $rows[] = [
                $p->id,
                $p->no_rm ?? '-',
                $p->nama ?? $p->name ?? '-',
                $p->no_ktp ?? '-',
                $p->no_hp ?? '-',
                $p->alamat ?? '-',
                $p->email,
            ];
        }

        return $this->downloadExcelHtml('data-pasien', $headers, $rows);
    }

    // 3. Export Data Obat (Role Admin)
    public function exportObat()
    {
        $headers = ['ID', 'Nama Obat', 'Kemasan', 'Harga (Rp)', 'Stok'];
        $obats = Obat::all();

        $rows = [];
        foreach ($obats as $o) {
            $rows[] = [
                $o->id,
                $o->nama_obat ?? '-',
                $o->kemasan ?? '-',
                number_format($o->harga ?? 0, 0, ',', '.'),
                $o->stok ?? 0,
            ];
        }

        return $this->downloadExcelHtml('data-obat', $headers, $rows);
    }

    // 4. Export Jadwal Periksa (Role Dokter)
    public function exportJadwal()
    {
        $headers = ['ID', 'Hari', 'Jam Mulai', 'Jam Selesai', 'Status'];
        $jadwals = JadwalPeriksa::where('id_dokter', auth()->id())->get();

        $rows = [];
        foreach ($jadwals as $j) {
            $rows[] = [
                $j->id,
                $j->hari,
                $j->jam_mulai,
                $j->jam_selesai,
                $j->status ?? ($j->aktif ? 'Aktif' : 'Tidak Aktif'),
            ];
        }

        return $this->downloadExcelHtml('jadwal-periksa-saya', $headers, $rows);
    }

    // 5. Export Riwayat Pasien (Role Dokter)
    public function exportRiwayatPasien()
    {
        $headers = ['No. RM', 'Nama Pasien', 'Tanggal Periksa', 'Catatan Dokter', 'Obat Diberikan', 'Biaya Periksa (Rp)'];

        $riwayat = Periksa::with(['daftarPoli.pasien', 'detailPeriksas.obat'])
            ->whereHas('daftarPoli.jadwalPeriksa', function ($q) {
                $q->where('id_dokter', auth()->id());
            })
            ->latest('tgl_periksa')
            ->get();

        $rows = [];
        foreach ($riwayat as $r) {
            $obatList = $r->detailPeriksas->map(function ($d) {
                return $d->obat->nama_obat ?? '';
            })->filter()->implode(', ');

            $rows[] = [
                $r->daftarPoli->pasien->no_rm ?? '-',
                $r->daftarPoli->pasien->nama ?? $r->daftarPoli->pasien->name ?? '-',
                $r->tgl_periksa,
                $r->catatan ?? '-',
                $obatList ?: '-',
                number_format($r->biaya_periksa ?? 0, 0, ',', '.'),
            ];
        }

        return $this->downloadExcelHtml('riwayat-pasien', $headers, $rows);
    }
}