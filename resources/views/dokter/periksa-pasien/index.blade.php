<x-layouts.app title="Periksa Pasien">

    {{-- Breadcrumb & Title --}}
    <div class="mb-6">
        <div class="text-xs text-slate-400 flex items-center gap-2 mb-2">
            <span>Poliklinik</span>
            <span>/</span>
            <span class="text-slate-600 font-medium">Periksa Pasien</span>
        </div>
        <h2 class="text-2xl font-bold text-slate-800">
            Periksa Pasien
        </h2>
    </div>

    {{-- Card Container --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-0">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    {{-- Table Head --}}
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 text-xs uppercase tracking-wider">
                            <th class="py-4 px-6 font-semibold">ID</th>
                            <th class="py-4 px-6 font-semibold">PASIEN</th>
                            <th class="py-4 px-6 font-semibold">KELUHAN</th>
                            <th class="py-4 px-6 font-semibold">NO ANTRIAN</th>
                            <th class="py-4 px-6 font-semibold text-right">AKSI</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @forelse ($daftarPasien as $item)
                            <tr class="hover:bg-slate-50/60 transition">
                                {{-- ID / Nomor Urut --}}
                                <td class="py-4 px-6 font-medium text-slate-500">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- Nama Pasien --}}
                                <td class="py-4 px-6 font-bold text-slate-700">
                                    {{ $item->pasien->nama ?? ($item->nama_pasien ?? '-') }}
                                </td>

                                {{-- Keluhan --}}
                                <td class="py-4 px-6 text-slate-500 max-w-xs truncate">
                                    {{ $item->keluhan ?? '-' }}
                                </td>

                                {{-- Nomor Antrian --}}
                                <td class="py-4 px-6 font-semibold text-slate-700">
                                    {{ $item->no_antrian }}
                                </td>

                                {{-- Aksi / Status --}}
                                <td class="py-4 px-6 text-right">
                                        @if ($item->periksas && $item->periksas->isNotEmpty())
                                            {{-- Status Sudah Diperiksa --}}
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                Sudah Diperiksa
                                            </span>
                                        @else
                                            {{-- Tombol Periksa --}}
                                            <a href="{{ route('periksa-pasien.create', $item->id) }}"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-[#f59e0b] hover:bg-[#d97706] text-white rounded-lg text-xs font-semibold shadow-sm transition">
                                                <i class="fas fa-stethoscope text-xs"></i>
                                                Periksa
                                            </a>
                                        @endif
                                    </td>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i class="fas fa-clipboard-user text-3xl text-slate-300"></i>
                                        <span>Belum ada antrian pasien untuk diperiksa.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-layouts.app>