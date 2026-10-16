<x-layouts.app title="Edit Jadwal Periksa">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('jadwal-periksa.index') }}" class="inline-flex items-center justify-center w-9 h-9 
                  rounded-lg bg-slate-100 text-slate-500 
                  hover:bg-slate-200 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>

        <h2 class="text-2xl font-bold text-slate-800">
            Edit Jadwal Periksa
        </h2>
    </div>

    {{-- Card --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-8">
            <form action="{{ route('jadwal-periksa.update', $jadwalPeriksa->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Hari --}}
                <div class="form-control mb-6">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Hari <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <select name="hari" id="hari"
                        class="select select-bordered border-2 px-4 w-full rounded-lg @error('hari') select-error @enderror"
                        required>
                        <option value="">Pilih Hari</option>
                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                            <option value="{{ $day }}" {{ (old('hari') ?? $jadwalPeriksa->hari) == $day ? 'selected' : '' }}>
                                {{ $day }}
                            </option>
                        @endforeach
                    </select>

                    @error('hari')
                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Jam Mulai --}}
                <div class="form-control mb-6">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Jam Mulai <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <input type="time" name="jam_mulai" id="jam_mulai"
                        value="{{ old('jam_mulai') ?? $jadwalPeriksa->jam_mulai }}"
                        class="input input-bordered border-2 px-4 w-full rounded-lg @error('jam_mulai') input-error @enderror"
                        required>

                    @error('jam_mulai')
                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Jam Selesai --}}
                <div class="form-control mb-8">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Jam Selesai <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <input type="time" name="jam_selesai" id="jam_selesai"
                        value="{{ old('jam_selesai') ?? $jadwalPeriksa->jam_selesai }}"
                        class="input input-bordered border-2 px-4 w-full rounded-lg @error('jam_selesai') input-error @enderror"
                        required>

                    @error('jam_selesai')
                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit" class="btn bg-[#2d4499] hover:bg-[#1e2d6b]
                                   text-white border-none rounded-lg px-6">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>

                    <a href="{{ route('jadwal-periksa.index') }}" class="btn btn-ghost bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg px-6">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</x-layouts.app>