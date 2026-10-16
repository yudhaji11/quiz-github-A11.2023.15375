<aside class="w-full bg-transparent text-slate-300 flex flex-col min-h-screen">

    {{-- ================= BRAND ================= --}}
    <div class="px-5 py-5 border-b border-white/10">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/logo-bengkot.png') }}" class="w-10 h-10 rounded-xl object-cover">

            <div>
                <div class="font-bold text-white text-lg leading-tight">
                    Poliklinik
                </div>

                @if(request()->is('admin*'))
                <span
                    class="text-[10px] font-bold uppercase tracking-wider bg-indigo-400/20 text-indigo-300 border border-indigo-400/30 px-2 py-0.5 rounded-md">
                    Admin
                </span>
                @elseif(request()->is('dokter*'))
                <span
                    class="text-[10px] font-bold uppercase tracking-wider bg-purple-400/20 text-purple-300 border border-purple-400/30 px-2 py-0.5 rounded-md">
                    Dokter
                </span>
                @elseif(request()->is('pasien*'))
                <span
                    class="text-[10px] font-bold uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/30 px-2 py-0.5 rounded-md">
                    Pasien
                </span>
                @endif
            </div>
        </div>
    </div>


    {{-- ================= MENU ================= --}}
    <div class="flex-1 overflow-y-auto px-3 py-4">

        @php
        $baseLink = "flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm transition-all duration-200";
        $inactive = "text-slate-300 hover:bg-white/10 hover:text-white";
        $active = "bg-gradient-to-r from-white/20 to-white/5 text-white font-semibold border border-indigo-400 border-2";
        @endphp


        {{-- ================= ADMIN ================= --}}
        @if(request()->is('admin*'))

        <p class="text-xs font-bold uppercase tracking-widest text-indigo-400 px-3 mb-3">
            Menu Admin
        </p>

        <div class="space-y-1">

            <a href="{{ route('admin.dashboard') }}"
                class="{{ $baseLink }} {{ request()->routeIs('admin.dashboard') ? $active : $inactive }}">
                <i class="fas fa-gauge-high w-4 text-center"></i>
                Dashboard Admin
            </a>
            <a href="{{ route('polis.index') }}"
                class="{{ $baseLink }} {{ request()->routeIs('polis.*') ? $active : $inactive }}">
                <i class="fas fa-hospital w-4 text-center"></i>
                Manajemen Poli
            </a>

            <a href="{{ route('dokter.index') }}"
                class="{{ $baseLink }} {{ request()->routeIs('dokter.*') ? $active : $inactive }}">
                <i class="fas fa-user-doctor w-4 text-center"></i>
                Manajemen Dokter
            </a>

            <a href="{{ route('pasien.index') }}"
                class="{{ $baseLink }} {{ request()->routeIs('pasien.*') ? $active : $inactive }}">
                <i class="fas fa-bed-pulse w-4 text-center"></i>
                Manajemen Pasien
            </a>

            <a href="{{ route('obat.index') }}"
                class="{{ $baseLink }} {{ request()->routeIs('obat.*') ? $active : $inactive }}">
                <i class="fas fa-pills w-4 text-center"></i>
                Manajemen Obat
            </a>
        </div>
        @endif


        {{-- ================= PASIEN ================= --}}
        @if(request()->is('pasien*'))

        <p class="text-xs uppercase tracking-widest text-indigo-400 px-3 mb-3 mt-6">
            Menu Pasien
        </p>

        <div class="space-y-1">

            <a href="{{ route('pasien.dashboard') }}"
                class="{{ $baseLink }} {{ request()->routeIs('pasien.dashboard') ? $active : $inactive }}">
                <i class="fas fa-house-medical w-4 text-center"></i>
                Dashboard Pasien
            </a>
            <a href="{{ route('pasien.daftar') }}"
                class="{{ ($baseLink ?? '') . (request()->routeIs('pasien.daftar') ? $active : $inactive) }}">
                <i class="fas fa-house-medical w-4 text-center"></i>
                Pendaftaran Periksa
            </a>
        </div>
        @endif


        {{-- ================= DOKTER ================= --}}
        @if(request()->is('dokter*'))

        <p class="text-xs uppercase tracking-widest text-indigo-400 px-3 mb-3 mt-6">
            Menu Dokter
        </p>

        <div class="space-y-1">

            <a href="{{ route('dokter.dashboard') }}"
                class="{{ $baseLink }} {{ request()->routeIs('dokter.dashboard') ? $active : $inactive }}">
                <i class="fas fa-stethoscope w-4 text-center"></i>
                Dashboard Dokter
            </a>
            <a href="{{ route('jadwal-periksa.index') }}"
                class="{{ $baseLink }} {{ request()->routeIs('jadwal-periksa.*') ? $active : $inactive }}">
                <i class="fas fa-stethoscope w-4 text-center"></i>
                Jadwal Periksa
            </a>
            <a href="{{ route('periksa-pasien.index') }}"
                class="{{ $baseLink }} {{ request()->routeIs('periksa-pasien.*') ? $active : $inactive }}">
                <i class="fas fa-notes-medical w-4 text-center"></i>
                Periksa Pasien
            </a>
             <a href="{{ route('riwayat-pasien.index') }}"
                 class="{{ $baseLink }} {{ request()->routeIs('riwayat-pasien.*') ? $active : $inactive }}">
                <i class="fas fa-clock-rotate-left w-4 text-center"></i>
                Riwayat Pasien
            </a>
        </div>
        @endif

    </div>


    {{-- ================= LOGOUT ================= --}}
    <div class="p-4 border-t border-white/10">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition-all">
                <i class="fas fa-right-from-bracket w-4"></i>
                Keluar
            </button>
        </form>
    </div>
</aside>