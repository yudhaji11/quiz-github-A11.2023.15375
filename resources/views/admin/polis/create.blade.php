<x-layouts.app title="Tambah Poli">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('polis.index') }}"
            class="flex items-center justify-center w-9 h-9 rounded-lg bg-slate-100 text-slate-500 hover:bg-slate-200 transition">
            <i class="fas fa-arrow-left text-xs"></i>
        </a>
        <h2 class="text-xl font-bold text-slate-800">
            Tambah Poli
        </h2>
    </div>

    {{-- Card --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-7">

            <form action="{{ route('polis.store') }}" method="POST">
                @csrf

                {{-- Nama Poli --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Nama Poli <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <input type="text" name="nama_poli" value="{{ old('nama_poli') }}"
                        placeholder="Masukkan nama poli..."
                        class="input input-bordered w-full rounded-lg text-sm @error('nama_poli') input-error @enderror"
                        required>

                    @error('nama_poli')
                    <label class="label pt-1">
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="form-control mb-6">
                    <label class="label pb-1">
                        <span class="text-sm font-semibold text-gray-700">
                            Keterangan <span class="text-red-500">*</span>
                        </span>
                    </label>

                    <textarea name="keterangan" rows="4" placeholder="Masukkan keterangan poli..."
                        class="textarea textarea-bordered w-full rounded-lg text-sm resize-none @error('keterangan') textarea-error @enderror"
                        required>{{ old('keterangan') }}</textarea>

                    @error('keterangan')
                    <label class="label pt-1">
                        <span class="label-text-alt text-red-500">
                            {{ $message }}
                        </span>
                    </label>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="flex items-center gap-2 px-6 py-2.5 bg-[#2d4499] hover:bg-[#1e2d6b] text-white rounded-lg text-sm font-semibold transition">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>

                    <a href="{{ route('polis.index') }}"
                        class="flex items-center gap-2 px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-lg text-sm font-semibold transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</x-layouts.app>