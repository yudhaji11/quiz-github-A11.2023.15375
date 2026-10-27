<x-layouts.app title="Verifikasi Pembayaran Pasien">

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-base-content">Verifikasi Pembayaran Pasien</h1>
        <p class="text-sm text-base-content/60">Periksa bukti transfer dan konfirmasi status pembayaran tagihan</p>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-base-200/50">
                    <tr>
                        <th>No</th>
                        <th>No. RM & Pasien</th>
                        <th>Poli & Dokter</th>
                        <th>Nominal</th>
                        <th>Waktu Upload</th>
                        <th>Bukti Transfer</th>
                        <th>Status</th>
                        <th class="text-center">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $index => $item)
                        <tr class="hover">
                            <td>{{ $pembayarans->firstItem() + $index }}</td>
                            <td>
                                <div class="font-semibold">{{ $item->daftarPoli->pasien->nama ?? $item->daftarPoli->pasien->name ?? '-' }}</div>
                                <div class="text-xs text-base-content/50">RM: {{ $item->daftarPoli->pasien->no_rm ?? '-' }}</div>
                            </td>
                            <td>
                                <div>{{ $item->daftarPoli->jadwalPeriksa->poli->nama_poli ?? '-' }}</div>
                                <div class="text-xs text-base-content/50">{{ $item->daftarPoli->jadwalPeriksa->dokter->nama ?? $item->daftarPoli->jadwalPeriksa->dokter->name ?? '-' }}</div>
                            </td>
                            <td class="font-bold text-primary">
                                Rp {{ number_format($item->biaya_periksa, 0, ',', '.') }}
                            </td>
                            <td class="text-xs">
                                {{ $item->tgl_bayar ? \Carbon\Carbon::parse($item->tgl_bayar)->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td>
                                <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" class="btn btn-xs btn-outline btn-info gap-1">
                                    <i class="fas fa-search-plus"></i> Buka Gambar
                                </a>
                            </td>
                            <td>
                                @if ($item->status_pembayaran === 'lunas')
                                    <span class="badge badge-success text-white badge-sm">LUNAS</span>
                                @else
                                    <span class="badge badge-warning text-white badge-sm">Menunggu Verifikasi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->status_pembayaran !== 'lunas')
                                    <form action="{{ route('admin.pembayaran.konfirmasi', $item->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa pembayaran ini sudah valid dan lunas?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success text-white gap-1">
                                            <i class="fas fa-check"></i> Konfirmasi Lunas
                                        </button>
                                    </form>
                                @else
                                    <span class="text-success text-xs font-semibold">
                                        <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-base-content/50">
                                <i class="fas fa-inbox text-3xl mb-2 block"></i>
                                Belum ada bukti pembayaran yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pembayarans->hasPages())
            <div class="p-4 border-t border-base-200">
                {{ $pembayarans->links() }}
            </div>
        @endif
    </div>
</div>
</x-layouts.app>