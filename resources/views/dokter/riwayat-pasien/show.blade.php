<x-layouts.app title="Detail Riwayat Pasien">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('riwayat-pasien.index') }}" class="inline-flex items-center justify-center w-9 h-9 
                  rounded-lg bg-slate-100 text-slate-500 
                  hover:bg-slate-200 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">
            Detail Riwayat
        </h2>
    </div>

    <div class="w-full flex flex-col gap-5">

        {{-- Informasi Pasien --}}
        <div class="card bg-base-100 shadow-sm rounded-2xl border border-slate-200">
            <div class="card-body p-0">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="font-bold text-slate-800">Informasi Pasien</h3>
                </div>
                <div class="px-6 py-5 flex flex-col gap-3 text-sm">
                    <div class="flex gap-2">
                        <span class="w-36 text-slate-500 font-medium">Nama Pasien</span>
                        <span class="text-slate-800 font-semibold">{{ $periksa->daftarPoli->pasien->nama }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="w-36 text-slate-500 font-medium">No. Antrian</span>
                        <span class="text-slate-800">{{ $periksa->daftarPoli->no_antrian }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="w-36 text-slate-500 font-medium">Keluhan</span>
                        <span class="text-slate-800">{{ $periksa->daftarPoli->keluhan }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="w-36 text-slate-500 font-medium">Poli</span>
                        <span class="text-slate-800">
                            {{ optional($periksa->daftarPoli->jadwalPeriksa->dokter->poli)->nama_poli }}
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <span class="w-36 text-slate-500 font-medium">Dokter</span>
                        <span class="text-slate-800">{{ $periksa->daftarPoli->jadwalPeriksa->dokter->nama }}</span>
                    </div>
                    <div class="flex gap-2">
                        <span class="w-36 text-slate-500 font-medium">Tanggal Periksa</span>
                        <span class="text-slate-800">{{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d/m/Y
                            H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Catatan Dokter --}}
        <div class="card bg-base-100 shadow-sm rounded-2xl border border-slate-200">
            <div class="card-body p-0">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="font-bold text-slate-800">Catatan Dokter</h3>
                </div>
                <div class="px-6 py-5 text-sm text-slate-600">
                    {{ $periksa->catatan ?: 'Tidak ada catatan' }}
                </div>
            </div>
        </div>

        {{-- Obat yang Diresepkan --}}
        <div class="card bg-base-100 shadow-sm rounded-2xl border border-slate-200">
            <div class="card-body p-0">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="font-bold text-slate-800">Obat yang Diresepkan</h3>
                </div>
                <div class="p-0">
                    @if($periksa->detailPeriksas && $periksa->detailPeriksas->count() > 0)
                    <table class="table table-zebra w-full">
                        <thead class="bg-slate-100 text-slate-500 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">#</th>
                                <th class="px-6 py-4">Nama Obat</th>
                                <th class="px-6 py-4">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($periksa->detailPeriksas as $index => $detail)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">{{ $detail->obat->nama_obat }}</td>
                                <td class="px-6 py-4 text-slate-500">Rp {{ number_format($detail->obat->harga, 0, ',',
                                    '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="px-6 py-5 text-sm text-slate-400">
                        Tidak ada obat yang diresepkan
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Total Biaya --}}
        <div class="card bg-base-100 shadow-sm rounded-2xl border border-slate-200">
            <div class="card-body px-6 py-5 flex items-center justify-between">
                <span class="font-bold text-slate-700">Total Biaya Periksa</span>
                <span class="text-2xl font-bold text-[#2d4499]">
                    Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                </span>
            </div>
        </div>

    </div>

</x-layouts.app>