<header class="bg-base-100 border-b border-base-300 h-16 flex items-center px-6 gap-4 sticky top-0 z-30 shadow-sm">

    {{-- Mobile Hamburger --}}
    <button onclick="toggleSidebar()" class="btn btn-square btn-ghost lg:hidden">
        <i data-lucide="menu" class="w-5 h-5"></i>
    </button>

    {{-- Breadcrumb --}}
    <div class="flex-1">
        <div class="flex items-center gap-2 text-sm">
            <span class="text-base-content/50">Poliklinik</span>
            <i data-lucide="chevron-right" class="w-4 h-4 text-base-content/30"></i>
            <span class="font-semibold text-base-content">
                {{ $title ?? 'Dashboard' }}
            </span>
        </div>
    </div>
    
    @php
        $unreadNotifications = auth()->user()->unreadNotifications;
        $unreadCount = $unreadNotifications->count();
    @endphp

    <div class="dropdown dropdown-end mr-3">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle relative">
            <i class="fas fa-bell text-lg"></i>
            @if($unreadCount > 0)
                <span class="badge badge-error badge-xs absolute top-2 right-2 p-1 text-[10px] text-white font-bold animate-pulse">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            @endif
        </div>

        <div tabindex="0" class="dropdown-content z-[50] card card-compact w-80 p-0 shadow-lg bg-base-100 border border-base-200 mt-2">
            <div class="card-body p-3">
                <div class="flex items-center justify-between border-b border-base-200 pb-2 mb-1">
                    <span class="font-bold text-sm">Notifikasi ({{ $unreadCount }})</span>
                    @if($unreadCount > 0)
                        <form action="{{ route('notifications.markAllRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs text-primary hover:underline">Tandai semua dibaca</button>
                        </form>
                    @endif
                </div>

                <div class="max-h-72 overflow-y-auto divide-y divide-base-200">
                    @forelse(auth()->user()->notifications()->take(6)->get() as $notif)
                        <a href="{{ route('notifications.read', $notif->id) }}" 
                        class="block p-2 hover:bg-base-200/50 rounded transition-colors {{ $notif->read_at ? 'opacity-60' : 'bg-primary/5 font-medium' }}">
                            <div class="flex items-start gap-2">
                                <div class="mt-1 text-primary">
                                    <i class="{{ $notif->data['icon'] ?? 'fas fa-info-circle' }}"></i>
                                </div>
                                <div class="flex-1 text-xs">
                                    <div class="font-bold text-base-content">{{ $notif->data['title'] ?? 'Info' }}</div>
                                    <div class="text-base-content/80 text-[11px] leading-tight mt-0.5">{{ $notif->data['pesan'] ?? '' }}</div>
                                    <div class="text-[10px] text-base-content/40 mt-1">{{ $notif->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-6 text-base-content/40 text-xs">
                            <i class="far fa-bell-slash text-2xl mb-1 block"></i>
                            Tidak ada notifikasi
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Fullscreen --}}
    <button onclick="toggleFullscreen()" class="btn btn-square btn-ghost">
        <i id="fsIcon" class="fas fa-expand w-5 h-5"></i>
    </button>

    {{-- User Dropdown (DaisyUI) --}}
    <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost flex items-center gap-3 p-1 rounded-full cursor-pointer">
            <div class="text-right hidden sm:block">
                <div class="text-sm font-semibold leading-tight">
                    {{ auth()->user()->nama ?? auth()->user()->name ?? 'Pengguna' }}
                </div>
                <div class="text-xs text-base-content/50 leading-tight capitalize">
                    {{ auth()->user()->role ?? 'Admin Sistem' }}
                </div>
            </div>

            <div class="avatar">
                <div class="w-10 h-10 rounded-full bg-primary text-primary-content flex items-center justify-center">
                    <span class="text-sm font-semibold leading-none">
                        {{ strtoupper(substr(auth()->user()->nama ?? auth()->user()->name ?? 'U', 0, 1)) }}
                    </span>
                </div>
            </div>
        </label>

        {{-- Dropdown Menu --}}
        <ul tabindex="0" class="dropdown-content menu p-2 shadow-lg bg-base-100 rounded-box w-56 mt-2 border border-base-200 z-50">
            <li class="menu-title px-4 py-2 border-b border-base-200">
                <span class="text-xs font-semibold text-base-content/60">Akun: {{ ucfirst(auth()->user()->role) }}</span>
            </li>
            
            {{-- Tombol Buka Modal Ganti Password --}}
            <li>
                <button type="button" onclick="modal_ganti_password.showModal()" class="flex items-center gap-2 py-2">
                    <i class="fas fa-key text-primary"></i> Ganti Password
                </button>
            </li>

            <div class="divider my-1"></div>
            
            {{-- Logout --}}
            <li>
                <form action="{{ route('logout') }}" method="POST" class="p-0">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-error py-2 w-full text-left">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </li>
        </ul>
    </div>

</header>

{{-- Modal Ganti Password (DaisyUI Dialog) --}}
<dialog id="modal_ganti_password" class="modal {{ $errors->has('current_password') || $errors->has('password') ? 'modal-open' : '' }}">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>

        <h3 class="font-bold text-lg mb-4 flex items-center gap-2 text-primary">
            <i class="fas fa-key"></i> Ganti Password
        </h3>

        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Password Lama --}}
            <div class="form-control mb-3">
                <label class="label">
                    <span class="label-text font-medium">Password Lama</span>
                </label>
                <input type="password" 
                       name="current_password" 
                       placeholder="Masukkan password saat ini" 
                       class="input input-bordered w-full @error('current_password') input-error @enderror" 
                       required />
                @error('current_password')
                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div class="form-control mb-3">
                <label class="label">
                    <span class="label-text font-medium">Password Baru</span>
                </label>
                <input type="password" 
                       name="password" 
                       placeholder="Minimal 8 karakter" 
                       class="input input-bordered w-full @error('password') input-error @enderror" 
                       required />
                @error('password')
                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="form-control mb-5">
                <label class="label">
                    <span class="label-text font-medium">Konfirmasi Password Baru</span>
                </label>
                <input type="password" 
                       name="password_confirmation" 
                       placeholder="Ulangi password baru" 
                       class="input input-bordered w-full" 
                       required />
            </div>

            <div class="modal-action">
                <button type="button" onclick="modal_ganti_password.close()" class="btn btn-ghost">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Password</button>
            </div>
        </form>
    </div>
    
    {{-- Klik background untuk tutup --}}
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<script>
    function toggleFullscreen() {
        const icon = document.getElementById('fsIcon');

        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
            icon.classList.remove('fa-expand');
            icon.classList.add('fa-compress');
        } else {
            document.exitFullscreen();
            icon.classList.remove('fa-compress');
            icon.classList.add('fa-expand');
        }
    }
</script>