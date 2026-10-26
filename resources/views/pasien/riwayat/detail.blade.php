<x-layouts.app title="Detail Riwayat Pendaftaran">

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-4">
        <a href="{{ route('pasien.riwayat.index') }}" class="btn btn-ghost btn-sm gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
        </a>
    </div>

    <div class="card bg-base-100 shadow border border-base-200">
        <div class="card-body p-6">
            <div class="flex justify-between items-start border-b border-base-200 pb-4 mb-4">
                <div>
                    <h2 class="card-title text-xl text-primary font-bold">Detail Pemeriksaan Pasien</h2>
                    <p class="text-xs text-base-content/60">Nomor Antrian: #{{ $daftarPoli->no_antrian }}</p>
                </div>
                <div class="text-right">
                    <span class="text-xs text-base-content/50">Tanggal Periksa:</span>
                    <div class="font-semibold text-sm">{{ \Carbon\Carbon::parse($daftarPoli->periksa->tgl_periksa)->format('d F Y, H:i') }} WIB</div>
                </div>
            </div>

            {{-- Info Dokter & Poli --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-base-200/40 p-4 rounded-lg mb-6 text-sm">
                <div>
                    <span class="text-base-content/60">Poliklinik:</span>
                    <div class="font-semibold">{{ $daftarPoli->jadwalPeriksa->poli->nama_poli ?? '-' }}</div>
                </div>
                <div>
                    <span class="text-base-content/60">Dokter Pemeriksa:</span>
                    <div class="font-semibold">{{ $daftarPoli->jadwalPeriksa->dokter->nama ?? $daftarPoli->jadwalPeriksa->dokter->name ?? '-' }}</div>
                </div>
                <div>
                    <span class="text-base-content/60">Keluhan Awal:</span>
                    <div>{{ $daftarPoli->keluhan ?? '-' }}</div>
                </div>
                <div>
                    <span class="text-base-content/60">Catatan Dokter:</span>
                    <div class="font-medium text-primary">{{ $daftarPoli->periksa->catatan ?? '-' }}</div>
                </div>
            </div>

            {{-- Rincian Obat yang Diberikan --}}
            <h3 class="font-semibold text-base mb-2">Daftar Obat yang Diresepkan</h3>
            <div class="overflow-x-auto mb-6 border border-base-200 rounded-lg">
                <table class="table table-compact w-full">
                    <thead class="bg-base-200/60">
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Kemasan</th>
                            <th class="text-right">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftarPoli->periksa->detailPeriksas as $idx => $detail)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td class="font-medium">{{ $detail->obat->nama_obat ?? '-' }}</td>
                                <td>{{ $detail->obat->kemasan ?? '-' }}</td>
                                <td class="text-right">Rp {{ number_format($detail->obat->harga ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-base-content/50">Tidak ada obat yang diresepkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Total Biaya --}}
            <div class="flex justify-end">
                <div class="w-full md:w-1/2 bg-primary/10 border border-primary/20 p-4 rounded-lg">
                    <div class="flex justify-between items-center text-sm mb-1">
                        <span class="text-base-content/70">Biaya Jasa Dokter:</span>
                        <span>Rp 150.000</span>
                    </div>
                    <div class="flex justify-between items-center text-base font-bold pt-2 border-t border-primary/20 text-primary">
                        <span>Total Biaya Periksa:</span>
                        <span>Rp {{ number_format($daftarPoli->periksa->biaya_periksa ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</x-layouts.app>