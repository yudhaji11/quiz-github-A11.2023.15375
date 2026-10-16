<x-layouts.app title="Tambah Pasien">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pasien.index') }}" class="flex items-center justify-center w-9 h-9 
                  rounded-lg bg-slate-100 hover:bg-slate-200 
                  text-slate-600 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>

        <h2 class="text-2xl font-bold text-slate-800">
            Tambah Pasien
        </h2>
    </div>

    {{-- Card --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-8">

            <form action="{{ route('pasien.store') }}" method="POST">
                @csrf

                {{-- Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    {{-- Nama --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Nama Pasien <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama pasien..."
                            class="w-full border-2 rounded-lg p-2
                                      focus:border-primary focus:outline-none
                                      @error('nama') border-red-500 @enderror" required>
                        @error('nama')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email..."
                            class="w-full border-2 rounded-lg p-2
                                      focus:border-primary focus:outline-none
                                      @error('email') border-red-500 @enderror" required>
                        @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No KTP --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            No. KTP <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="no_ktp" value="{{ old('no_ktp') }}" placeholder="Masukkan No. KTP..."
                            class="w-full border-2 rounded-lg p-2
                                      focus:border-primary focus:outline-none
                                      @error('no_ktp') border-red-500 @enderror" required>
                        @error('no_ktp')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">
                            No. HP <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="no_hp" value="{{ old('no_hp') }}" placeholder="Masukkan No. HP..."
                            class="w-full border-2 rounded-lg p-2
                                      focus:border-primary focus:outline-none
                                      @error('no_hp') border-red-500 @enderror" required>
                        @error('no_hp')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Alamat --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alamat" rows="3" placeholder="Masukkan alamat..." class="w-full border-2 rounded-lg p-2
                                     focus:border-primary focus:outline-none
                                     @error('alamat') border-red-500 @enderror" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter..." class="w-full border-2 rounded-lg p-2
                                  focus:border-primary focus:outline-none
                                  @error('password') border-red-500 @enderror" required>
                    @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary 
                               hover:bg-primary/90 text-white 
                               font-semibold text-sm transition">
                        <i class="fas fa-save mr-1"></i>
                        Simpan
                    </button>

                    <a href="{{ route('pasien.index') }}" class="px-6 py-2.5 rounded-xl bg-slate-100 
                              hover:bg-slate-200 text-slate-600 
                              font-semibold text-sm transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

</x-layouts.app>