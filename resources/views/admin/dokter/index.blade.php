<x-layouts.app title="Data Dokter">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Data Dokter
        </h2>

        <a href="{{ route('dokter.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary/90 
                  text-white rounded-xl text-sm font-semibold transition">
            <i class="fas fa-plus text-sm"></i>
            Tambah Dokter
        </a>
    </div>

    {{-- Card Table --}}
    <div class="card bg-base-100 shadow-md rounded-2 border">
        <div class="card-body p-0">

            <div class="overflow-x-auto">
                <table class="table w-full">

                    {{-- Table Head --}}
                    <thead class="bg-slate-100 text-slate-600 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Nama Dokter</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">No. KTP</th>
                            <th class="px-6 py-4">No. HP</th>
                            <th class="px-6 py-4">Alamat</th>
                            <th class="px-6 py-4">Poli</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>

                    {{-- Table Body --}}
                    <tbody class="text-sm text-slate-700">

                        @forelse($dokters as $dokter)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $dokter->nama }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $dokter->email }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $dokter->no_ktp ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $dokter->no_hp ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $dokter->alamat ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    {{ $dokter->poli->nama_poli ?? 'Belum Dipilih' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('dokter.edit', $dokter->id) }}" class="inline-flex items-center gap-1 px-3 py-2 
                                        bg-amber-500 hover:bg-amber-600 
                                        text-white rounded-lg text-xs font-semibold transition">
                                        <i class="fas fa-pen-to-square text-xs"></i>
                                        Edit
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('dokter.destroy', $dokter->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus dokter ini?')" class="inline-flex items-center gap-1 px-3 py-2 
                                             bg-red-500 hover:bg-red-600 
                                             text-white rounded-lg text-xs font-semibold transition">
                                            <i class="fas fa-trash text-xs"></i>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-16 text-slate-400">
                                <i class="fas fa-inbox text-3xl mb-3 block"></i>
                                Belum ada data dokter
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</x-layouts.app>