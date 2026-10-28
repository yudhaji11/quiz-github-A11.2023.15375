<x-layouts.app title="Pasien Dashboard">
    <div class="p-6 max-w-7xl mx-auto space-y-6">

        {{-- Salam Pembuka --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
            <div>
                <h1 class="text-2xl font-bold text-base-content">
                    Selamat Datang, {{ $user->nama ?? $user->name }} 👋
                </h1>
                <p class="text-sm text-base-content/60">
                    Nomor Rekam Medis (RM): <span class="font-semibold text-primary">{{ $user->no_rm ?? '-' }}</span>
                </p>
            </div>
            <div class="text-xs text-base-content/50">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </div>

        {{-- BANNER ANTRIAN AKTIF --}}
        @if(!empty($antrianAktif))
            <div class="card bg-gradient-to-r from-blue-600 via-indigo-600 to-primary text-white shadow-xl overflow-hidden relative">
                <div class="card-body p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-white/20 pb-4">
                        <div>
                            <div class="inline-flex items-center gap-2 bg-white/20 px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-md mb-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                Antrian Sedang Berlangsung
                            </div>
                            <h2 class="text-xl md:text-2xl font-bold">
                                Poli {{ $antrianAktif->jadwalPeriksa->poli->nama_poli ?? 'Poliklinik' }}
                            </h2>
                            <p class="text-sm text-white/80">
                                Dokter: <span class="font-semibold">{{ $antrianAktif->jadwalPeriksa->dokter->nama ?? $antrianAktif->jadwalPeriksa->dokter->name ?? '-' }}</span>
                                • {{ $antrianAktif->jadwalPeriksa->hari ?? '-' }} ({{ substr($antrianAktif->jadwalPeriksa->jam_mulai ?? '', 0, 5) }} - {{ substr($antrianAktif->jadwalPeriksa->jam_selesai ?? '', 0, 5) }})
                            </p>
                        </div>

                        <div>
                            <a href="{{ route('pasien.riwayat.index') }}" class="btn btn-sm bg-white text-primary hover:bg-slate-100 border-none font-bold shadow">
                                <i class="fas fa-list-alt mr-1"></i> Cek Riwayat
                            </a>
                        </div>
                    </div>

                    {{-- 3 Indikator Antrian --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-white/15 backdrop-blur-md rounded-xl p-4 border border-white/20 flex items-center justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-wider text-white/75 font-semibold">Nomor Anda</div>
                                <div class="text-3xl md:text-4xl font-extrabold mt-1">#{{ $antrianAktif->no_antrian }}</div>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-xl">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                        </div>

                        <div class="bg-white/15 backdrop-blur-md rounded-xl p-4 border border-white/20 flex items-center justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-wider text-white/75 font-semibold">Sedang Dipanggil</div>
                                <div id="display-antrian-sekarang" class="text-3xl md:text-4xl font-extrabold mt-1 text-emerald-300">
                                    #{{ $antrianSekarang }}
                                </div>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-xl text-emerald-300">
                                <i class="fas fa-user-md"></i>
                            </div>
                        </div>

                        <div class="bg-white/15 backdrop-blur-md rounded-xl p-4 border border-white/20 flex items-center justify-between">
                            <div>
                                <div class="text-xs uppercase tracking-wider text-white/75 font-semibold">Sisa Antrian di Depan</div>
                                <div id="display-sisa-antrian" class="text-3xl md:text-4xl font-extrabold mt-1 {{ $sisaAntrian <= 1 ? 'text-amber-300' : 'text-white' }}">
                                    <span>{{ $sisaAntrian }}</span> <span class="text-sm font-normal text-white/80">orang</span>
                                </div>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center text-xl text-amber-300">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>

                    @if($sisaAntrian === 0)
                        <div class="mt-4 bg-emerald-500/20 border border-emerald-400/40 rounded-lg p-2.5 text-xs flex items-center gap-2">
                            <i class="fas fa-bell text-emerald-300 text-sm"></i>
                            <span><strong>Giliran Anda sekarang/selanjutnya!</strong> Harap bersiap di dekat ruang pemeriksaan poli.</span>
                        </div>
                    @endif
                </div>
            </div>
        @else
            {{-- KARTU STATUS KETIKA TIDAK ADA ANTRIAN --}}
            <div class="alert bg-base-100 border border-base-200 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xl">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-base">Tidak ada antrian aktif saat ini</h3>
                        <div class="text-xs text-base-content/60">Silakan daftar periksa jika ingin berkonsultasi dengan dokter.</div>
                    </div>
                </div>
                <div>
                    <a href="{{ \Illuminate\Support\Facades\Route::has('pasien.daftar') ? route('pasien.daftar') : url('/pasien/pendaftaran') }}" class="btn btn-primary btn-sm gap-2">
                        <i class="fas fa-plus"></i> Daftar Pemeriksaan
                    </a>
                </div>
            </div>
        @endif

        {{-- KARTU RINGKASAN AKTIVITAS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="card bg-base-100 border border-base-200 shadow-sm p-4 flex flex-row items-center justify-between">
                <div>
                    <div class="text-xs text-base-content/60 font-medium">Total Konsultasi & Pendaftaran</div>
                    <div class="text-2xl font-bold mt-1">{{ $totalPendaftaran }}</div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                    <i class="fas fa-notes-medical"></i>
                </div>
            </div>

            <div class="card bg-base-100 border border-base-200 shadow-sm p-4 flex flex-row items-center justify-between">
                <div>
                    <div class="text-xs text-base-content/60 font-medium">Pemeriksaan Selesai</div>
                    <div class="text-2xl font-bold mt-1 text-success">{{ $totalSelesai }}</div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-green-100 text-success flex items-center justify-center text-lg">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

    </div>

    @if(!empty($antrianAktif))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const idJadwal = {{ $antrianAktif->id_jadwal }};
                const nomorSaya = {{ $antrianAktif->no_antrian }};

                if (window.Echo) {
                    window.Echo.channel(`antrian.jadwal.${idJadwal}`)
                        .listen('.AntrianUpdated', (e) => {
                            const antrianSekarang = e.antrianSekarang;
                            
                            // 1. Update teks nomor sedang dipanggil
                            const elAntrian = document.getElementById('display-antrian-sekarang');
                            if (elAntrian) {
                                elAntrian.innerText = '#' + (antrianSekarang > nomorSaya ? nomorSaya : antrianSekarang);
                            }

                            // 2. Hitung dan update sisa antrian di depan
                            const sisa = Math.max(0, nomorSaya - antrianSekarang);
                            const elSisa = document.getElementById('display-sisa-antrian');
                            if (elSisa) {
                                elSisa.innerHTML = `<span>${sisa}</span> <span class="text-sm font-normal text-white/80">orang</span>`;
                            }

                            // 3. Notifikasi visual jika giliran tiba
                            if (sisa === 0) {
                                alert('Perhatian: Giliran pemeriksaan Anda telah tiba!');
                            }
                        });
                }
            });
        </script>
    @endif

</x-layouts.app>