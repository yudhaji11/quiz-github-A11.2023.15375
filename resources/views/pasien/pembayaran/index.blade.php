<x-layouts.app title="Tagihan & Pembayaran">

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-base-content">Tagihan & Pembayaran</h1>
        <p class="text-sm text-base-content/60">Daftar tagihan pemeriksaan dan unggah bukti transfer</p>
    </div>

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-base-200/50">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Periksa</th>
                        <th>Poli & Dokter</th>
                        <th>Total Tagihan</th>
                        <th>Status</th>
                        <th>Bukti Transfer</th>
                        <th class="text-center">Aksi Unggah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tagihans as $index => $item)
                        <tr class="hover">
                            <td>{{ $tagihans->firstItem() + $index }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_periksa)->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="font-semibold">{{ $item->daftarPoli->jadwalPeriksa->poli->nama_poli ?? '-' }}</div>
                                <div class="text-xs text-base-content/60">{{ $item->daftarPoli->jadwalPeriksa->dokter->nama ?? $item->daftarPoli->jadwalPeriksa->dokter->name ?? '-' }}</div>
                            </td>
                            <td class="font-bold text-primary">
                                Rp {{ number_format($item->biaya_periksa, 0, ',', '.') }}
                            </td>
                            <td>
                                @if ($item->status_pembayaran === 'lunas')
                                    <span class="badge badge-success text-white badge-sm">LUNAS</span>
                                @elseif ($item->status_pembayaran === 'menunggu_verifikasi')
                                    <span class="badge badge-warning text-white badge-sm">Menunggu Verifikasi</span>
                                @else
                                    <span class="badge badge-error text-white badge-sm">Belum Bayar</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}" target="_blank" class="btn btn-xs btn-outline btn-info gap-1">
                                        <i class="fas fa-image"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-xs text-base-content/40 italic">Belum diunggah</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->status_pembayaran !== 'lunas')
                                    <button type="button" onclick="document.getElementById('modal-upload-{{ $item->id }}').showModal()" class="btn btn-sm btn-primary gap-1">
                                        <i class="fas fa-upload"></i> {{ $item->bukti_pembayaran ? 'Ganti Bukti' : 'Upload Bukti' }}
                                    </button>

                                    {{-- Modal Upload DaisyUI --}}
                                    <dialog id="modal-upload-{{ $item->id }}" class="modal">
                                        <div class="modal-box text-left">
                                            <form method="dialog">
                                                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                            </form>
                                            <h3 class="font-bold text-lg mb-3">Upload Bukti Transfer</h3>
                                            <p class="text-sm mb-4">Total Biaya: <strong class="text-primary">Rp {{ number_format($item->biaya_periksa, 0, ',', '.') }}</strong></p>

                                            <form action="{{ route('pasien.pembayaran.upload', $item->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-control mb-4">
                                                    <label class="label"><span class="label-text">Pilih Foto Bukti Transfer (JPG/PNG, max 2MB)</span></label>
                                                    <input type="file" name="bukti_pembayaran" class="file-input file-input-bordered w-full" accept="image/*" required />
                                                </div>
                                                <div class="modal-action">
                                                    <button type="button" onclick="document.getElementById('modal-upload-{{ $item->id }}').close()" class="btn btn-ghost">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Kirim Bukti</button>
                                                </div>
                                            </form>
                                        </div>
                                    </dialog>
                                @else
                                    <span class="badge badge-ghost text-xs text-success font-semibold">
                                        <i class="fas fa-check-double mr-1"></i> Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-base-content/50">
                                <i class="fas fa-receipt text-3xl mb-2 block"></i>
                                Belum ada tagihan pemeriksaan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($tagihans->hasPages())
            <div class="p-4 border-t border-base-200">
                {{ $tagihans->links() }}
            </div>
        @endif
    </div>
</div>
</x-layouts.app>