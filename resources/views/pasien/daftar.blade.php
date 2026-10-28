<x-layouts.app title="Daftar Poli">

    {{-- Breadcrumb --}}
    <div class="text-xs text-slate-400 flex items-center gap-2 mb-6">
        <span>Poliklinik</span>
        <span>/</span>
        <span class="text-slate-600 font-medium">Daftar Poli</span>
    </div>

    {{-- Alert Notifikasi --}}
        @if (session('message'))
            <div class="alert alert-success bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl mb-6 text-sm flex items-center gap-2">
                <i class="fas fa-check-circle text-base"></i>
                <span>{{ session('message') }}</span>
            </div>
        @endif
    {{-- Card Container Tengah --}}
    <div class="flex justify-center items-center">
        <div class="card w-full max-w-2xl bg-base-100 shadow-sm rounded-2xl border border-slate-100">
            <div class="card-body p-8 sm:p-10">

                {{-- Judul Form --}}
                <div class="flex items-center justify-center gap-2 mb-8">
                    <span class="text-xl">🗂️</span>
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">
                        Pendaftaran Poli
                    </h2>
                </div>

                <form action="{{ route('pasien.daftar.submit') }}" method="POST">
                    @csrf
                    {{-- ID Pasien yang sedang login --}}
                    <input type="hidden" name="id_pasien" value="{{ $user->id }}">

                    {{-- Nomor Rekam Medis (Readonly) --}}
                    <div class="form-control mb-5">
                        <label class="label pb-1.5" for="no_rm">
                            <span class="text-xs font-semibold text-slate-600">Nomor Rekam Medis</span>
                        </label>
                        <input type="text" id="no_rm" 
                            value="{{ $user->pasien->no_rm ?? ($user->no_rm ?? '202603-005') }}" 
                            readonly
                            class="input input-bordered w-full rounded-lg text-sm bg-slate-50 text-slate-700 font-medium border-slate-200 cursor-not-allowed">
                    </div>

                    {{-- Pilih Poli --}}
                    <div class="form-control mb-5">
                        <label class="label pb-1.5" for="id_poli">
                            <span class="text-xs font-semibold text-slate-600">
                                Pilih Poli <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <select name="id_poli" id="id_poli" 
                            class="select select-bordered w-full rounded-lg text-sm text-slate-600 border-slate-200 focus:border-blue-600 @error('id_poli') select-error @enderror" 
                            required>
                            <option value="">-- Pilih Poli --</option>
                            @foreach ($polis as $poli)
                                <option value="{{ $poli->id }}" {{ old('id_poli') == $poli->id ? 'selected' : '' }}>
                                    {{ $poli->nama_poli }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_poli')
                            <label class="label pt-1">
                                <span class="label-text-alt text-red-500 text-xs">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Pilih Jadwal Periksa --}}
                    <div class="form-control mb-5">
                        <label class="label pb-1.5" for="id_jadwal">
                            <span class="text-xs font-semibold text-slate-600">
                                Pilih Jadwal Periksa <span class="text-red-500">*</span>
                            </span>
                        </label>
                        <select name="id_jadwal" id="id_jadwal" 
                            class="select select-bordered w-full rounded-lg text-sm text-slate-600 border-slate-200 focus:border-blue-600 @error('id_jadwal') select-error @enderror" 
                            required>
                            <option value="">-- Pilih Jadwal --</option>
                            @foreach ($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}" 
                                    data-poli="{{ $jadwal->dokter->id_poli ?? ($jadwal->dokter->poli->id ?? '') }}"
                                    {{ old('id_jadwal') == $jadwal->id ? 'selected' : '' }}>
                                    {{ $jadwal->dokter->nama ?? 'Dokter' }} | {{ $jadwal->hari }} ({{ substr($jadwal->jam_mulai, 0, 5) }} - {{ substr($jadwal->jam_selesai, 0, 5) }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_jadwal')
                            <label class="label pt-1">
                                <span class="label-text-alt text-red-500 text-xs">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Keluhan --}}
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text font-semibold">
                                Keluhan Penyakit<span class="text-red-500">*</span>
                            </span>
                        </label>
                        <textarea 
                            name="keluhan" 
                            class="textarea textarea-bordered h-24 w-full" 
                            placeholder="Tuliskan keluhan atau gejala yang Anda rasakan..." 
                            required>{{ old('keluhan') }}</textarea>
                        @error('keluhan')
                            <span class="text-error text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tombol Daftar Poli --}}
                    <div class="flex justify-end">
                        <button type="submit" 
                            class="px-6 py-2.5 bg-[#2563eb] hover:bg-[#1d4ed8] text-white rounded-lg text-sm font-semibold shadow-sm transition">
                            Daftar Poli
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Script Filter Jadwal Berdasarkan Poli yang Dipilih --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectPoli = document.getElementById('id_poli');
            const selectJadwal = document.getElementById('id_jadwal');
            const allJadwalOptions = Array.from(selectJadwal.querySelectorAll('option')).slice(1); // Simpan semua opsi selain default

            function filterJadwal() {
                const selectedPoliId = selectPoli.value;
                const currentSelectedJadwal = selectJadwal.value;

                selectJadwal.innerHTML = '<option value="">-- Pilih Jadwal --</option>';

                if (!selectedPoliId) {
                    return;
                }

                const filteredOptions = allJadwalOptions.filter(option => {
                    const idPoli = option.getAttribute('data-poli');
                    return !idPoli || idPoli === selectedPoliId;
                });

                if (filteredOptions.length > 0) {
                    filteredOptions.forEach(opt => selectJadwal.appendChild(opt));

                    if (currentSelectedJadwal) {
                        selectJadwal.value = currentSelectedJadwal;
                    }
                } else {
                    const emptyOption = document.createElement('option');
                    emptyOption.value = '';
                    emptyOption.textContent = '-- Belum ada jadwal tersedia untuk poli ini --';
                    emptyOption.disabled = true;
                    selectJadwal.appendChild(emptyOption);
                }
            }

            selectPoli.addEventListener('change', function () {
                filterJadwal();
                selectJadwal.value = ''; // Reset pilihan jadwal saat poli berganti
            });

            // Jalankan filter saat halaman awal dimuat (jika ada old input)
            if (selectPoli.value) {
                filterJadwal();
            }
        });
    </script>

</x-layouts.app>