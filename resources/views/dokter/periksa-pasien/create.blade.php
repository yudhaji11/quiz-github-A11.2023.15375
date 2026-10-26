<x-layouts.app title="Periksa Pasien">

    {{-- Breadcrumb --}}
    <div class="text-xs text-slate-400 flex items-center gap-2 mb-3">
        <span>Poliklinik</span>
        <span>/</span>
        <span class="text-slate-600 font-medium">Periksa Pasien</span>
    </div>

    {{-- Header with Back Button --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('periksa-pasien.index') }}"
            class="flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">
            Periksa Pasien
        </h2>
    </div>

    {{-- Alert Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-error bg-red-50 text-red-700 border border-red-200 rounded-xl mb-6 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Card Container --}}
    <div class="card bg-base-100 shadow-md rounded-2xl border border-slate-200">
        <div class="card-body p-8">

            <form action="{{ route('periksa-pasien.store') }}" method="POST">
                @csrf
                {{-- ID Janji Temu / Daftar Poli Pasien --}}
                <input type="hidden" name="id_daftar_poli" value="{{ $id }}">

                {{-- Hidden input obat_json yang diminta controller --}}
                <input type="hidden" name="obat_json" id="obat_json" value="">

                {{-- Pilih Obat --}}
                <div class="form-control mb-5">
                    <label class="label pb-1.5" for="select-obat">
                        <span class="text-xs font-semibold text-slate-700">
                            Pilih Obat <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <select id="select-obat"
                        class="select select-bordered border-2 px-4 w-full rounded-lg text-sm text-slate-600 focus:border-[#2d4499]">
                        <option value="">-- Pilih Obat --</option>
                        @foreach ($obats as $obat)
                            <option value="{{ $obat->id }}" data-nama="{{ $obat->nama_obat }}" data-harga="{{ $obat->harga }}">
                                {{ $obat->nama_obat }} - {{ $obat->kemasan }} (Rp {{ number_format($obat->harga, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Obat Terpilih Container --}}
                <div class="form-control mb-5">
                    <label class="label pb-1">
                        <span class="text-xs font-semibold text-slate-700">Obat Terpilih</span>
                    </label>
                    <div id="container-obat-terpilih" class="flex flex-wrap gap-2 min-h-[42px] p-2.5 rounded-lg bg-slate-50 border border-dashed border-slate-200">
                        <span id="placeholder-obat" class="text-xs text-slate-400 self-center pl-1">Belum ada obat yang dipilih</span>
                    </div>
                </div>

                {{-- Total Harga Tampilan --}}
                <div class="form-control mb-5">
                    <label class="label pb-1.5" for="total_harga_display">
                        <span class="text-xs font-semibold text-slate-700">Total Harga</span>
                    </label>
                    <input type="text" id="total_harga_display" value="Rp 0" readonly
                        class="input input-bordered border-2 px-4 w-full rounded-lg text-sm bg-slate-50 text-slate-700 font-semibold cursor-not-allowed">
                    {{-- Hidden input integer murni untuk $request->biaya_periksa --}}
                    <input type="hidden" name="biaya_periksa" id="total_harga" value="0">
                </div>

                {{-- Catatan (Opsional) --}}
                <div class="form-control mb-8">
                    <label class="label pb-1.5" for="catatan">
                        <span class="text-xs font-semibold text-slate-700">Catatan (Opsional)</span>
                    </label>
                    <textarea name="catatan" id="catatan" rows="4" placeholder="Masukkan catatan..."
                        class="textarea textarea-bordered border-2 px-4 py-3 w-full rounded-lg text-sm focus:border-[#2d4499] text-slate-700">{{ old('catatan') }}</textarea>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center gap-3">
                    <button type="submit"
                        class="flex items-center gap-2 px-6 py-2.5 bg-[#2d4499] hover:bg-[#1e2d6b] text-white rounded-lg text-sm font-semibold shadow-sm transition">
                        <i class="fas fa-save text-xs"></i>
                        Simpan
                    </button>

                    <a href="{{ route('periksa-pasien.index') }}"
                        class="btn btn-ghost bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg px-6 font-semibold normal-case text-sm">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Script Dynamic Selection & JSON Generator --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectObat = document.getElementById('select-obat');
            const containerObat = document.getElementById('container-obat-terpilih');
            const placeholderObat = document.getElementById('placeholder-obat');
            const totalHargaDisplay = document.getElementById('total_harga_display');
            const totalHargaInput = document.getElementById('total_harga');
            const obatJsonInput = document.getElementById('obat_json');

            let obatTerpilihList = [];

            if (selectObat) {
                selectObat.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    const obatId = selectedOption.value;

                    if (!obatId) return;

                    const namaObat = selectedOption.getAttribute('data-nama');
                    const hargaObat = parseInt(selectedOption.getAttribute('data-harga')) || 0;

                    // Cegah duplikasi item obat
                    if (obatTerpilihList.some(item => item.id == obatId)) {
                        this.value = '';
                        return;
                    }

                    obatTerpilihList.push({
                        id: parseInt(obatId),
                        nama: namaObat,
                        harga: hargaObat
                    });

                    renderObatTerpilih();
                    this.value = '';
                });
            }

            function renderObatTerpilih() {
                containerObat.innerHTML = '';

                if (obatTerpilihList.length === 0) {
                    containerObat.appendChild(placeholderObat);
                } else {
                    obatTerpilihList.forEach((item, index) => {
                        const badge = document.createElement('div');
                        badge.className = 'inline-flex items-center gap-2 bg-slate-100 border border-slate-300 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-medium';
                        badge.innerHTML = `
                            <span>${item.nama}</span>
                            <span class="text-slate-400">|</span>
                            <span class="text-slate-500 font-semibold">Rp ${item.harga.toLocaleString('id-ID')}</span>
                            <button type="button" class="text-slate-400 hover:text-red-500 ml-1 transition" onclick="removeObat(${index})">
                                <i class="fas fa-times"></i>
                            </button>
                        `;
                        containerObat.appendChild(badge);
                    });
                }

                sinkronisasiData();
            }

            window.removeObat = function (index) {
                obatTerpilihList.splice(index, 1);
                renderObatTerpilih();
            };

            function sinkronisasiData() {
                // 1. Kalkulasi Total Harga Obat
                const totalObat = obatTerpilihList.reduce((acc, curr) => acc + curr.harga, 0);
                totalHargaDisplay.value = 'Rp ' + totalObat.toLocaleString('id-ID');
                totalHargaInput.value = totalObat;

                // 2. Format Array ID Obat ke JSON String untuk Controller
                const ids = obatTerpilihList.map(item => item.id);
                obatJsonInput.value = ids.length > 0 ? JSON.stringify(ids) : '';
            }
        });
    </script>

</x-layouts.app>