<x-layouts.guest title="Register">

    <div class="card bg-base-100 shadow-2xl rounded-2xl w-full max-w-[480px]">
        <div class="card-body p-[40px]">

            {{-- Logo & Title --}}
            <div class="text-center mb-7">
                <img src="{{ asset('images/logo-bengkot.png') }}"
                     class="w-[60px] h-[60px] rounded-[16px] object-cover mx-auto mb-[14px] block">
                <h1 class="text-[1.5rem] font-extrabold text-[#1e2d6b] m-0 mb-[6px]">Poliklinik</h1>
                <p class="text-[0.83rem] text-slate-400 m-0">Buat akun baru</p>
            </div>

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="alert alert-error mb-4 rounded-xl text-[0.83rem]">
                    <i class="fas fa-circle-xmark"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                {{-- Nama Lengkap --}}
                <div class="form-control mb-4">
                    <label class="label pb-1">
                        <span class="text-[0.82rem] font-semibold text-gray-700">Nama Lengkap</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-3 w-full rounded-[10px] border-slate-200 bg-slate-50">
                        <i class="fas fa-user text-slate-400 text-[0.82rem]"></i>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                               placeholder="Masukkan nama lengkap..."
                               class="grow bg-transparent text-slate-800 text-[0.88rem]"
                               required>
                    </label>
                </div>

                {{-- Email --}}
                <div class="form-control mb-4">
                    <label class="label pb-1">
                        <span class="text-[0.82rem] font-semibold text-gray-700">Email</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-3 w-full rounded-[10px] border-slate-200 bg-slate-50">
                        <i class="fas fa-envelope text-slate-400 text-[0.82rem]"></i>
                        <input type="email" name="email" value="{{ old('email') }}"
                               placeholder="Masukkan email..."
                               class="grow bg-transparent text-slate-800 text-[0.88rem]"
                               required>
                    </label>
                </div>

                {{-- Alamat --}}
                <div class="form-control mb-4">
                    <label class="label pb-1">
                        <span class="text-[0.82rem] font-semibold text-gray-700">Alamat</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-3 w-full rounded-[10px] border-slate-200 bg-slate-50">
                        <i class="fas fa-map-marker-alt text-slate-400 text-[0.82rem]"></i>
                        <input type="text" name="alamat" value="{{ old('alamat') }}"
                               placeholder="Masukkan alamat..."
                               class="grow bg-transparent text-slate-800 text-[0.88rem]"
                               required>
                    </label>
                </div>

                {{-- No. HP & No. KTP --}}
                <div class="grid grid-cols-2 gap-[14px] mb-4">
                    <div class="form-control">
                        <label class="label pb-1">
                            <span class="text-[0.82rem] font-semibold text-gray-700">No. HP</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-2 rounded-[10px] border-slate-200 bg-slate-50">
                            <i class="fas fa-phone text-slate-400 text-[0.78rem]"></i>
                            <input type="number" name="no_hp" value="{{ old('no_hp') }}"
                                   placeholder="No. HP..."
                                   class="grow bg-transparent text-slate-800 text-[0.85rem]"
                                   required>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label pb-1">
                            <span class="text-[0.82rem] font-semibold text-gray-700">No. KTP</span>
                        </label>
                        <label class="input input-bordered flex items-center gap-2 rounded-[10px] border-slate-200 bg-slate-50">
                            <i class="fas fa-address-card text-slate-400 text-[0.78rem]"></i>
                            <input type="number" name="no_ktp" value="{{ old('no_ktp') }}"
                                   placeholder="No. KTP..."
                                   class="grow bg-transparent text-slate-800 text-[0.85rem]"
                                   required>
                        </label>
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-control mb-4">
                    <label class="label pb-1">
                        <span class="text-[0.82rem] font-semibold text-gray-700">Password</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-2 w-full rounded-[10px] border-slate-200 bg-slate-50">
                        <i class="fas fa-lock text-slate-400 text-[0.78rem]"></i>
                        <input type="password" name="password" id="password_reg"
                               placeholder="Password..."
                               class="grow bg-transparent text-slate-800 text-[0.85rem]"
                               required>
                        <i class="fas fa-eye text-slate-400 text-[0.78rem] cursor-pointer" id="toggle_reg"
                           onclick="togglePassword('password_reg', 'toggle_reg')"></i>
                    </label>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-control mb-6">
                    <label class="label pb-1">
                        <span class="text-[0.82rem] font-semibold text-gray-700">Konfirmasi Password</span>
                    </label>
                    <label class="input input-bordered flex items-center gap-2 w-full rounded-[10px] border-slate-200 bg-slate-50">
                        <i class="fas fa-lock text-slate-400 text-[0.78rem]"></i>
                        <input type="password" name="password_confirmation" id="password_confirm"
                               placeholder="Ulangi password..."
                               class="grow bg-transparent text-slate-800 text-[0.85rem]"
                               required>
                        <i class="fas fa-eye text-slate-400 text-[0.78rem] cursor-pointer" id="toggle_confirm"
                           onclick="togglePassword('password_confirm', 'toggle_confirm')"></i>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn-primary-gradient">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </form>

            <p class="text-center mt-5 text-[0.83rem] text-slate-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[#2d4499] font-bold no-underline">Login</a>
            </p>

        </div>
    </div>

    @push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
    @endpush

</x-layouts.guest>