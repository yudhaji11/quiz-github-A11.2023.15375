<x-layouts.app title="Riwayat Pendaftaran Poli">

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-base-content">Riwayat Pendaftaran Poli</h1>
            <p class="text-sm text-base-content/60">Daftar riwayat konsultasi dan antrian pemeriksaan Anda</p>
        </div>
    </div>

    @if (session('error'))
        <div class="alert alert-error mb-4 text-white shadow-sm">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead class="bg-base-200/50">
                    <tr>
                        <th>No</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                        <th>Jadwal / Hari</th>
                        <th>No. Antrian</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($riwayats as $index => $item)
                        <tr class="hover">
                            <td>{{ $riwayats->firstItem() + $index }}</td>
                            <td class="font-semibold">{{ $item->jadwalPeriksa->poli->nama_poli ?? '-' }}</td>
                            <td>{{ $item->jadwalPeriksa->dokter->nama ?? $item->jadwalPeriksa->dokter->name ?? '-' }}</td>
                            <td>
                                <span class="badge badge-ghost badge-sm">
                                    {{ $item->jadwalPeriksa->hari ?? '-' }} ({{ substr($item->jadwalPeriksa->jam_mulai ?? '', 0, 5) }} - {{ substr($item->jadwalPeriksa->jam_selesai ?? '', 0, 5) }})
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-primary font-bold text-xs px-2.5 py-1">
                                    #{{ $item->no_antrian }}
                                </span>
                            </td>
                            <td>
                                @if ($item->periksa)
                                    <span class="badge badge-success text-white badge-sm gap-1">
                                        <i class="fas fa-check-circle text-xs"></i> Sudah Diperiksa
                                    </span>
                                @else
                                    <span class="badge badge-warning text-white badge-sm gap-1">
                                        <i class="fas fa-clock text-xs"></i> Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->periksa)
                                    <a href="{{ route('pasien.riwayat.show', $item->id) }}" class="btn btn-sm btn-info text-white gap-1">
                                        <i class="fas fa-file-medical-alt"></i> Detail
                                    </a>
                                @else
                                    <span class="text-xs text-base-content/40 italic">Belum ada detail</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-base-content/50">
                                <i class="fas fa-calendar-times text-3xl mb-2 block"></i>
                                Belum ada riwayat pendaftaran poli.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($riwayats->hasPages())
            <div class="p-4 border-t border-base-200">
                {{ $riwayats->links() }}
            </div>
        @endif
    </div>
</div>
</x-layouts.app>