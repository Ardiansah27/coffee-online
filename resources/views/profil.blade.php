@extends('landing-page.landing-page')

@section('title', 'Profil Saya')
@section('profil')
<section class="max-w-5xl mx-auto px-4 md:px-8 py-16 bg-gradient-to-b from-[#fffaf6] to-[#f4ede5] rounded-3xl shadow-lg mt-24">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2200,
                background: '#ffffff',
                iconColor: '#6f4e37',
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                confirmButtonColor: '#6f4e37',
            });
        @endif
    });
    </script>

    {{-- FORM PROFIL --}}
    <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data"
          class="bg-white/70 backdrop-blur-md p-8 rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 border border-[#e4d6c1]">
        @csrf
        
        <div class="flex flex-col md:flex-row gap-8 items-center">
            {{-- Foto Profil --}}
            <div class="flex flex-col items-center md:w-1/3 space-y-3">
                <div class="relative group">
                    <img id="preview-foto" 
                         src="{{ $user->profile_picture ? asset($user->profile_picture) : ($user->avatar ?? asset('uploads/default-user.png')) }}"
                         alt="Foto Profil"
                         class="w-36 h-36 rounded-full object-cover border-4 border-[#c8a77a] shadow-md group-hover:scale-105 transition duration-300">

                    <button type="button" id="infoFotoBtn"
                            class="absolute -top-1 -right-1 bg-[#8c6239] text-white text-xs w-5 h-5 flex items-center justify-center rounded-full shadow hover:bg-[#6f4e37] transition">!</button>

                    <div id="infoFotoPopup" class="hidden absolute top-6 right-0 z-50 w-56 bg-white border border-[#d6c4b1] rounded-lg shadow-lg p-3 text-xs text-[#4b2e12]">
                        Setelah upload foto, jangan lupa klik <span class="font-semibold">Simpan Perubahan</span>.
                    </div>

                    <label class="absolute bottom-2 right-2 bg-[#6f4e37] hover:bg-[#5a3e2b] text-white text-xs px-2 py-1 rounded cursor-pointer shadow-md transition">
                        Ganti
                        <input type="file" name="profile_picture" class="hidden" id="input-foto">
                    </label>
                </div>
                <span class="text-xs text-[#7b5e45] italic">Format: JPG, PNG (maks. 2MB)</span>
            </div>

       {{-- Info Profil --}}
        <div class="flex-1 w-full space-y-5">
            <div>
                <label class="font-semibold text-[#4b2e12] block mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full border border-[#d6c4b1] rounded-lg p-3 bg-[#fffdfb] focus:ring-2 focus:ring-[#c8a77a] focus:outline-none shadow-sm transition">
            </div>
            <div>
                <label class="font-semibold text-[#4b2e12] block mb-1">Email</label>
                <input type="email" value="{{ $user->email }}" readonly
                       class="w-full border border-[#d6c4b1] rounded-lg p-3 bg-gray-100 cursor-not-allowed shadow-sm text-gray-700">
            </div>
            <div>
                <label class="font-semibold text-[#4b2e12] block mb-1">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                       placeholder="Masukkan nomor aktif..."
                       class="w-full border border-[#d6c4b1] rounded-lg p-3 bg-[#fffdfb] focus:ring-2 focus:ring-[#c8a77a] shadow-sm transition">
            </div>

            {{-- Bagian Judul Alamat & Tombol --}}
          {{-- Bagian Alamat Saya --}}
<div class="mt-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-[#4b3832]">Alamat Saya</h3>
        <div class="flex gap-2">
            <button type="button" onclick="openDaftarAlamatModal()" class="bg-[#f3ece7] text-[#6f4e37] px-4 py-2 rounded-lg border border-[#d2b48c] font-semibold text-sm flex items-center gap-2">
                <i class="fas fa-list"></i> Daftar Alamat
            </button>
           <button type="button" 
    onclick="window.location.href='{{ route('profil.alamat.create') }}'"
    class="bg-[#6f4e37] text-white px-4 py-2 rounded-lg font-semibold text-sm flex items-center gap-2 shadow-sm hover:bg-[#5a3e2b] transition-all">
    <span>+</span> Tambah Baru
</button>
        </div>
    </div>

    {{-- KOLOM ALAMAT UTAMA (STATIS) --}}
    <div class="space-y-3">
        @php $alamatUtama = $alamat->where('is_utama', true)->first(); @endphp
        
        @if($alamatUtama)
            <div class="p-4 bg-gray-50 border border-[#d6c4b1] rounded-xl shadow-sm relative">
                <div class="absolute top-3 right-3">
                    <span class="bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded-full font-bold uppercase">Utama</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-[#a88a64] uppercase tracking-widest">{{ $alamatUtama->label_alamat }}</span>
                    <h4 class="font-bold text-[#4b3832] text-sm">{{ $alamatUtama->nama_penerima }} | {{ $alamatUtama->no_telepon }}</h4>
                    {{-- Ini kolom statis yang tidak bisa di-edit (readonly style) --}}
                    <div class="mt-2 p-3 bg-white border border-gray-200 rounded-lg text-xs text-gray-600 leading-relaxed italic">
                        {{ $alamatUtama->alamat_lengkap }}
                    </div>
                </div>
            </div>
        @else
            <div class="p-4 border-2 border-dashed border-gray-200 rounded-xl text-center">
                <p class="text-xs text-gray-400 italic">Belum ada alamat utama yang dipilih.</p>
            </div>
        @endif
    </div>
</div>
        </div>
    </div> {{-- Penutup flex-col md:flex-row --}}

    <div class="text-center pt-8">
        <button type="submit" class="bg-gradient-to-r from-[#8c6239] to-[#6f4e37] text-white font-semibold px-8 py-3 rounded-full shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300">
            Simpan Perubahan
        </button>
    </div>
</form>
</section>

{{-- SEMUA MODAL Diletakkan di Luar Section Utama agar tidak error layout --}}


<div id="mapModal" class="hidden fixed inset-0 z-[9999] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl relative">
        <div class="p-4 border-b flex justify-between items-center bg-[#fffaf5]">
            <h3 class="font-bold text-[#4b3832]">Tentukan Lokasi Presisi</h3>
            <button onclick="closeMapModal()" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
        </div>
        
        <div class="relative">
            <div class="absolute top-4 right-4 flex flex-col items-end gap-2" style="z-index: 10001 !important;">
                <button type="button" onclick="toggleSearchInput('searchContainer1', 'mapSearchInput1')" 
                    class="bg-[#6f4e37] p-3 rounded-full text-white shadow-lg border-2 border-white active:scale-95 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                
                <div id="searchContainer1" class="hidden opacity-0 translate-y-2 transition-all duration-300 w-64 sm:w-80 shadow-2xl">
                    <div class="relative flex items-center">
                        <input type="text" id="mapSearchInput1" 
                            class="w-full p-3 pr-12 rounded-xl border-2 border-[#6f4e37] focus:outline-none text-sm bg-white shadow-lg text-gray-800" 
                            placeholder="Cari lokasi...">
                        <button type="button" onclick="searchAddressOnMap('mapSearchInput1', 'searchContainer1')" class="absolute right-3 text-[#6f4e37]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div id="mapPopup" style="height: 400px; width: 100%; z-index: 1;"></div>
            
            <div class="absolute bottom-6 left-4 right-4 z-[1001] bg-white/95 p-3 rounded-xl shadow-lg border border-[#d2b48c]">
                <p class="text-[10px] font-bold text-[#6f4e37] uppercase">Lokasi Pinpoint:</p>
                <p id="modalAlamatText" class="text-xs text-gray-700 italic leading-tight mt-1">Geser pin pada peta...</p>
            </div>
        </div>
        <div class="p-4 bg-gray-50 flex flex-col gap-3">
            <input type="hidden" id="modalLat">
            <input type="hidden" id="modalLng">
            <button type="button" onclick="saveMapSelection()" class="w-full bg-[#6f4e37] hover:bg-[#5a3f2d] text-white py-3.5 rounded-xl font-bold shadow-lg uppercase text-xs tracking-widest transition-all">
                KONFIRMASI LOKASI
            </button>
        </div>
    </div>
</div>

<div id="modalDaftarAlamat" class="fixed inset-0 z-[9998] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#fffaf6] w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[85vh]">
        <div class="p-4 border-b flex justify-between items-center bg-white">
            <h3 class="font-bold text-[#4b2e12]">📋 Daftar Alamat Pengiriman</h3>
            <button onclick="closeDaftarAlamatModal()" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
        </div>
       <div class="overflow-y-auto p-4 space-y-3 custom-scrollbar">
@forelse($alamat as $a)
    <div class="p-4 bg-white border {{ $a->is_utama ? 'border-[#6f4e37] ring-1 ring-[#6f4e37]' : 'border-gray-200' }} rounded-xl shadow-sm relative overflow-hidden">
        
        <div class="absolute top-2 right-2 z-20 flex flex-col items-end gap-1">
            <button type="button" 
                onclick="toggleSearchInput('searchContList{{ $a->id }}', 'searchInputList{{ $a->id }}')" 
                class="bg-[#6f4e37] p-1.5 rounded-full text-white shadow-md hover:bg-[#5a3f2d] transition-all active:scale-90 border border-white opacity-40 hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
            <div id="searchContList{{ $a->id }}" class="hidden opacity-0 translate-y-1 transition-all duration-300 w-48 shadow-xl">
                <input type="text" id="searchInputList{{ $a->id }}" class="w-full p-2 rounded-lg border-2 border-[#6f4e37] text-xs" placeholder="Cari...">
            </div>
        </div>

        <div class="flex justify-between items-start gap-2"> 
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-[10px] font-bold text-[#a88a64] uppercase tracking-widest">{{ $a->label_alamat }}</span>
                </div>
                
                <h4 class="font-bold text-[#4b3832] text-sm">{{ $a->nama_penerima }} <span class="text-gray-400 font-normal">| {{ $a->no_telepon }}</span></h4>
                <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">{{ $a->alamat_lengkap }}</p>
            </div>
            
            <button onclick="openMapModal({{ $a->id }}, {{ $a->latitude }}, {{ $a->longitude }})" 
                    class="flex items-center gap-1 text-[10px] font-bold text-blue-600 border border-blue-100 bg-blue-50/50 px-2 py-1 rounded-lg hover:bg-blue-100 transition shrink-0 mt-0.5">
                📍 PIN POINT
            </button>
        </div>

        <div class="mt-3 pt-3 border-t border-gray-50 flex gap-4 text-[11px] font-bold">
            @if(!$a->is_utama)
                <button type="button" class="btn-set-utama text-orange-700 hover:underline" data-id="{{ $a->id }}">JADIKAN UTAMA</button>
            @else
                <span class="text-green-600 flex items-center gap-1 text-[10px]">✔ ALAMAT UTAMA</span>
            @endif
            <button type="button" class="btn-hapus-alamat text-red-500 hover:underline" data-id="{{ $a->id }}">HAPUS</button>
        </div>
    </div>
@empty
    <p class="text-center text-gray-500 py-10 text-sm">Belum ada alamat tersimpan.</p>
@endforelse
</div>
<div id="mapConfirmModal" class="fixed inset-0 z-[9999] hidden bg-black/60 flex items-center justify-center p-4 backdrop-blur-sm">
  <div id="mapModal" class="fixed inset-0 z-[9999] hidden bg-black/60 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl overflow-hidden relative">
        <div class="flex justify-between items-center p-4 border-b bg-[#fffaf5]">
            <h3 class="font-bold text-[#4b3832]">Tentukan Lokasi Presisi</h3>
            <button onclick="closeMapModal()" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
        </div>

        <div class="relative">
            <div class="absolute top-4 right-4 flex flex-col items-end gap-2" style="z-index: 10001 !important;">
                <button type="button" onclick="toggleSearchInput()" 
                    class="bg-[#6f4e37] p-3 rounded-full shadow-2xl border-2 border-white text-white hover:bg-[#5a3f2d] transition-all active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>


                <div id="searchContainer" class="hidden opacity-0 translate-y-2 transition-all duration-300 w-64 sm:w-80 shadow-2xl">
                    <div class="relative flex items-center">
                        <input type="text" id="mapSearchInput" 
                            class="w-full p-3 pr-12 rounded-xl border-2 border-[#6f4e37] focus:outline-none text-sm bg-white shadow-lg" 
                            placeholder="Cari lokasi...">
                        <button type="button" onclick="searchAddressOnMap()" class="absolute right-3 text-[#6f4e37]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>

                    </div>
                </div>
                
            </div>

            <div id="mapPopup" style="height: 400px; width: 100%; z-index: 1;"></div>
            
            <div class="absolute bottom-6 left-4 right-4 z-[1001] bg-white/95 backdrop-blur-sm p-3 rounded-xl shadow-lg border border-[#d2b48c]">
                <p class="text-[10px] font-bold text-[#6f4e37] uppercase tracking-tighter">Lokasi Pinpoint:</p>
                <p id="modalAlamatText" class="text-xs text-gray-700 leading-tight mt-1 italic">Memuat alamat...</p>
            </div>
        </div>

        <div class="p-4 bg-gray-50">
            <input type="hidden" id="currentAlamatId">
            <input type="hidden" id="modalLat">
            <input type="hidden" id="modalLng">
            <button type="button" onclick="saveMapSelection()" class="w-full bg-[#6f4e37] hover:bg-[#5a3f2d] text-white font-bold py-3 rounded-xl transition shadow-lg uppercase text-xs">
                Konfirmasi Lokasi
            </button>
        </div>
    </div>
</div>
</div>
<style>
    /* Mewarnai spinner loading agar tidak biru */
    .swal2-loader {
        border-color: #6f4e37 transparent #6f4e37 transparent !important;
    }
/* HAPUS ICON SEARCH DI DAFTAR ALAMAT SAJA */
#modalDaftarAlamat button {
    display: none;
}

/* TAPI TAMPILKAN KEMBALI TOMBOL PIN POINT */
#modalDaftarAlamat button[onclick*="openMapModal"] {
    display: inline-flex !important;
}

</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- A. NOTIFIKASI FLASH DARI LARAVEL ---
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{!! session('success') !!}", // Gunakan !! agar karakter khusus tidak ter-escape
            showConfirmButton: false,
            timer: 2200,
            iconColor: '#6f4e37',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{!! session('error') !!}",
            confirmButtonColor: '#6f4e37',
        });
    @endif

    // --- B. PREVIEW FOTO ---
    const inputFoto = document.getElementById('input-foto');
    const previewFoto = document.getElementById('preview-foto');
    if (inputFoto && previewFoto) {
        inputFoto.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => previewFoto.src = e.target.result;
                reader.readAsDataURL(file);
            }
        });
    }

    // --- C. INFO POPUP ---
    const btnInfo = document.getElementById('infoFotoBtn');
    const popupInfo = document.getElementById('infoFotoPopup');
    if (btnInfo) {
        btnInfo.onclick = (e) => {
            e.stopPropagation();
            popupInfo.classList.toggle('hidden');
        };
        document.addEventListener('click', () => popupInfo.classList.add('hidden'));
    }

document.addEventListener('click', async function(e) {
    
    // --- 1. LOGIKA JADIKAN UTAMA ---
    const btnUtama = e.target.closest('.btn-set-utama');
    if (btnUtama) {
        e.preventDefault();
        const id = btnUtama.dataset.id;

        // TUTUP MODAL DAFTAR ALAMAT DULU
        closeDaftarAlamatModal();

        // Tunggu sedikit agar animasi modal tutup selesai, baru munculkan Swal
        setTimeout(async () => {
            Swal.fire({
                title: 'Memproses...',
                text: 'Sedang mengatur alamat utama',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            try {
                const res = await fetch(`/profil/alamat-utama/${id}`, {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
             if (data.success) {
    Swal.fire({ 
        icon: 'success', 
        iconColor: '#6f4e37', // Membuat ikon centang jadi cokelat
        title: 'Berhasil!', 
        text: 'Alamat utama diperbarui', 
        confirmButtonColor: '#6f4e37', // Membuat tombol OK jadi cokelat
        timer: 1500, 
        showConfirmButton: false 
    }).then(() => location.reload());
}
            } catch (err) {
                Swal.fire('Error', 'Gagal menghubungi server', 'error').then(() => {
                    openDaftarAlamatModal(); // Buka kembali modal jika error
                });
            }
        }, 300); 
    }

    // --- 2. LOGIKA HAPUS ALAMAT ---
    const btnHapus = e.target.closest('.btn-hapus-alamat');
    if (btnHapus) {
        e.preventDefault();
        const id = btnHapus.dataset.id;

        // TUTUP MODAL DAFTAR ALAMAT DULU
        closeDaftarAlamatModal();

        setTimeout(() => {
            Swal.fire({
                title: 'Hapus Alamat?',
                text: "Ingat ? Data ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6f4e37',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                    try {
                        const res = await fetch(`/profil/alamat/${id}`, {
                            method: 'DELETE',
                            headers: { 
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        const data = await res.json();
                       if (data.success) {
    Swal.fire({
        title: 'Terhapus!',
        text: 'Alamat berhasil dihapus.',
        icon: 'success',
        iconColor: '#6f4e37', // Cokelat
        confirmButtonColor: '#6f4e37' // Cokelat
    }).then(() => location.reload());
}
                    } catch (err) {
                        Swal.fire('Error', 'Gagal menghapus alamat', 'error');
                    }
                } else {
                    // Jika user klik "Batal", buka lagi modal daftar alamatnya
                    openDaftarAlamatModal();
                }
            });
        }, 300);
    }
});


    // --- E. FORM TAMBAH ALAMAT AJAX ---
    const formTambah = document.getElementById('formTambahAlamat');
    if (formTambah) {
        formTambah.onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData(formTambah);
            
            try {
                const res = await fetch("{{ route('profil.alamat.store') }}", { 
                    method: 'POST', 
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const data = await res.json();
                if(data.success) {
                    Swal.fire('Berhasil!', 'Alamat baru ditambahkan', 'success').then(() => location.reload());
                } else {
                    Swal.fire('Gagal', data.error || 'Terjadi kesalahan', 'error');
                }
            } catch (err) {
                Swal.fire('Error', 'Gagal menyimpan alamat', 'error');
            }
        };
    }
});

// Fungsi Modal (Tetap di luar DOMContentLoaded)
// Fungsi untuk Modal Peta (Pin Point)
function openMapModal(id, lat, lng) {
    // 1. Masukkan data ke input hidden agar bisa dikirim ke database
    document.getElementById('currentAlamatId').value = id;
    document.getElementById('modalLat').value = lat;
    document.getElementById('modalLng').value = lng;

    // 2. Tampilkan modal peta
    const modal = document.getElementById('mapConfirmModal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // 3. Pastikan Peta muncul dengan benar (Leaflet fix)
    setTimeout(() => {
        if (typeof map !== 'undefined') {
            map.invalidateSize();
        }
    }, 300);
}

function closeMapModal() {
    const modal = document.getElementById('mapConfirmModal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Fungsi Daftar Alamat (Tetap seperti milik Anda)
function openDaftarAlamatModal() {
    const modal = document.getElementById('modalDaftarAlamat');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeDaftarAlamatModal() {
    const modal = document.getElementById('modalDaftarAlamat');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Fungsi untuk mencari alamat
async function searchAddressOnMap() {
    const query = document.getElementById('mapSearchInput').value;
    
    if (query.length < 3) {
        Swal.fire({
            icon: 'info',
            title: 'Pencarian',
            text: 'Masukkan minimal 3 karakter untuk mencari.',
            confirmButtonColor: '#6f4e37'
        });
        return;
    }

    // Tampilkan loading kecil pada tombol jika perlu
    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`);
        const results = await response.json();

        if (results.length > 0) {
            const { lat, lon, display_name } = results[0];
            const newPos = [parseFloat(lat), parseFloat(lon)];

            // 1. Pindahkan Peta
            mapPopup.setView(newPos, 16);

            // 2. Pindahkan Marker (asumsi nama variabel marker Anda adalah 'markerPopup')
            markerPopup.setLatLng(newPos);

            // 3. Update Input Hidden & Teks Alamat
            document.getElementById('modalLat').value = lat;
            document.getElementById('modalLng').value = lon;
            document.getElementById('modalAlamatText').innerText = display_name;
            
            // 4. Trigger kalkulasi jarak jika fungsi tersebut ada
            // updateDistance(lat, lon); 

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Tidak Ditemukan',
                text: 'Maaf, lokasi tidak ditemukan. Coba gunakan kata kunci lain.',
                confirmButtonColor: '#6f4e37'
            });
        }
    } catch (error) {
        console.error("Search Error:", error);
    }
}

// Tambahkan event listener agar bisa Enter saat mengetik
document.getElementById('mapSearchInput')?.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        searchAddressOnMap();
    }
});

// --- FUNGSI MAPS PIN POINT (UPDATE LOKASI) ---
let popMap, popMarker; // Variabel global untuk peta

// 1. FUNGSI MEMBUKA MODAL PETA
function openMapModal(id, lat, lng) {
    // Tutup modal daftar alamat agar tidak tumpang tindih
    closeDaftarAlamatModal();

    const modal = document.getElementById('mapModal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    // Masukkan data awal ke input hidden
    document.getElementById('currentAlamatId').value = id;
    document.getElementById('modalLat').value = lat;
    document.getElementById('modalLng').value = lng;

    // Inisialisasi atau Update Peta
    setTimeout(() => {
        if (!popMap) {
            popMap = L.map('mapPopup').setView([lat, lng], 17);
            L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(popMap);

            popMarker = L.marker([lat, lng], { draggable: true }).addTo(popMap);

            popMarker.on('dragend', (e) => {
                const pos = e.target.getLatLng();
                updatePopLocation(pos.lat, pos.lng);
            });
        } else {
            popMap.setView([lat, lng], 17);
            popMarker.setLatLng([lat, lng]);
            popMap.invalidateSize();
        }
        updatePopLocation(lat, lng);
    }, 300);
}

// 1. Fungsi Buka/Tutup Input
function toggleSearchInput(containerId, inputId) {
    const container = document.getElementById(containerId);
    const input = document.getElementById(inputId);
    
    if (container.classList.contains('hidden')) {
        container.classList.remove('hidden');
        setTimeout(() => {
            container.classList.remove('opacity-0', 'translate-y-2');
            container.classList.add('opacity-100', 'translate-y-0');
            input.focus();
        }, 10);
    } else {
        container.classList.remove('opacity-100', 'translate-y-0');
        container.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => {
            container.classList.add('hidden');
        }, 300);
    }
}

// 2. Fungsi Cari Lokasi (Menerima parameter ID)
async function searchAddressOnMap(inputId, containerId) {
    const query = document.getElementById(inputId).value;
    if (query.length < 3) return;

    try {
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`);
        const results = await response.json();

        if (results.length > 0) {
            const { lat, lon, display_name } = results[0];
            const newPos = [parseFloat(lat), parseFloat(lon)];
            
            // Pindah posisi peta dan marker (Asumsi variabel peta Anda: popMap & popMarker)
            popMap.setView(newPos, 17);
            popMarker.setLatLng(newPos);
            
            // Update tampilan teks alamat dan input hidden
            document.getElementById('modalLat').value = lat;
            document.getElementById('modalLng').value = lon;
            document.getElementById('modalAlamatText').innerText = display_name;

            // Tutup otomatis bar pencarian setelah ketemu
            toggleSearchInput(containerId, inputId);
        } else {
            alert("Lokasi tidak ditemukan");
        }
    } catch (e) {
        console.error("Error:", e);
    }
}

// 2. FUNGSI UPDATE TEKS ALAMAT & INPUT
function updatePopLocation(lat, lng) {
    document.getElementById('modalLat').value = lat;
    document.getElementById('modalLng').value = lng;
    
    const el = document.getElementById('modalAlamatText');
    if (el) el.innerText = "Mencari alamat...";

    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            if (el) el.innerText = data.display_name || "Lokasi terpilih";
        })
        .catch(() => {
            if (el) el.innerText = "Gagal memuat alamat";
        });
}

// 3. FUNGSI SIMPAN KE DATABASE (FIXED & THEMED)
async function saveMapSelection() {
    const id = document.getElementById('currentAlamatId').value;
    const lat = document.getElementById('modalLat').value;
    const lng = document.getElementById('modalLng').value;
    const alamatTeks = document.getElementById('modalAlamatText').innerText;

    console.log("Payload yang dikirim:", { id, lat, lng, alamatTeks });

    if (!id || !lat || !lng || alamatTeks.includes("Mencari") || alamatTeks.includes("Geser")) {
        Swal.fire({
            icon: 'warning',
            iconColor: '#6f4e37', // Warna ikon cokelat
            title: 'Lokasi Belum Siap',
            text: 'Tunggu sebentar sampai alamat muncul atau geser kembali pinnya.',
            confirmButtonColor: '#6f4e37' // Warna tombol cokelat
        });
        return;
    }

    try {
        closeMapModal(); 
        
        Swal.fire({ 
            title: 'Menyimpan...', 
            text: 'Sedang memperbarui data di database',
            allowOutsideClick: false, 
            didOpen: () => {
                // Memberi warna cokelat pada loading spinner
                const loader = Swal.getHtmlContainer().querySelector('.swal2-loader');
                if (loader) loader.style.borderColor = '#6f4e37 transparent #6f4e37 transparent';
                Swal.showLoading();
            }
        });

        const res = await fetch(`/profil/alamat/update-map/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                latitude: lat, 
                longitude: lng,
                alamat_lengkap: alamatTeks 
            })
        });
        
        const data = await res.json();
        
        if (res.ok && data.success) {
            Swal.fire({
                icon: 'success',
                iconColor: '#6f4e37', // Warna ikon cokelat
                title: 'Berhasil',
                text: 'alamat  telah diperbarui!',
                confirmButtonColor: '#6f4e37' // Warna tombol cokelat
            }).then(() => location.reload());
        } else {
            throw new Error(data.message || 'Gagal memperbarui database.');
        }
    } catch (err) {
        console.error("Error Detail:", err);
        Swal.fire({
            icon: 'error',
            iconColor: '#6f4e37', // Warna ikon cokelat
            title: 'Gagal Simpan',
            text: err.message,
            confirmButtonColor: '#6f4e37' // Warna tombol cokelat
        }).then(() => {
            const modal = document.getElementById('mapModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        });
    }
}

// 4. FUNGSI TUTUP MODAL
function closeMapModal() {
    const modal = document.getElementById('mapModal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// --- MODAL TAMBAH ALAMAT BARU ---
let mapProfil, markerProfil;
function openModal() {
    document.getElementById('modalAlamat').classList.remove('hidden');
    setTimeout(() => {
        const defaultPos = [-6.200000, 106.816666]; // Jakarta Default
        if (!mapProfil) {
            mapProfil = L.map('mapAlamatProfil').setView(defaultPos, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(mapProfil);
            markerProfil = L.marker(defaultPos, { draggable: true }).addTo(mapProfil);
            markerProfil.on('dragend', e => fillLocationData(e.target.getLatLng().lat, e.target.getLatLng().lng));
            mapProfil.on('click', e => { markerProfil.setLatLng(e.latlng); fillLocationData(e.latlng.lat, e.latlng.lng); });
        } else { 
            mapProfil.invalidateSize(); 
        }
    }, 300);
}

function closeModal() { 
    document.getElementById('modalAlamat').classList.add('hidden'); 
    document.body.style.overflow = 'auto';
}

function fillLocationData(lat, lng) {
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            const el = document.getElementById('alamatLengkap');
            if(el && data.display_name) el.value = data.display_name;
        });
}

// SUBMIT FORM TAMBAH ALAMAT
const formTambahAlamat = document.getElementById('formTambahAlamat');
if (formTambahAlamat) {
    formTambahAlamat.addEventListener('submit', async e => {
        e.preventDefault();
        const formData = new FormData(formTambahAlamat);
        try {
            const res = await fetch("{{ route('profil.alamat.store') }}", { 
                method:'POST', 
                headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, 
                body: formData 
            });
            const data = await res.json();
            if(res.ok && data.success) Swal.fire('Berhasil', data.success, 'success').then(() => location.reload());
            else Swal.fire('Gagal', data.error || 'Terjadi kesalahan','error');
        } catch { 
            Swal.fire('Error','Server tidak merespon','error'); 
        }
    });
}

// FITUR GEOLOKASI (LOKASI SAYA)
const btnLokasiSaya = document.getElementById('btnLokasiSaya');
if(btnLokasiSaya){
    btnLokasiSaya.addEventListener('click', () => {
        if(!navigator.geolocation) return;
        btnLokasiSaya.innerHTML='⏳...'; btnLokasiSaya.disabled=true;
        navigator.geolocation.getCurrentPosition(pos=>{
            const {latitude, longitude}=pos.coords;
            const latLng=L.latLng(latitude, longitude);
            markerProfil.setLatLng(latLng); 
            mapProfil.setView(latLng, 17); 
            fillLocationData(latitude, longitude);
            btnLokasiSaya.innerHTML='🎯 Lokasi Saya'; btnLokasiSaya.disabled=false;
        }, ()=>{
            btnLokasiSaya.innerHTML='🎯 Lokasi Saya'; btnLokasiSaya.disabled=false;
            Swal.fire('Gagal','Akses lokasi ditolak','error');
        });
    });
}


</script>

@endsection