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


<div id="mapModal" class="hidden fixed inset-0 z-[9999] bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-2xl overflow-hidden shadow-2xl">
        <div class="p-4 border-b flex justify-between items-center bg-[#fffaf5]">
            <h3 class="font-bold text-[#4b3832]">Tentukan Lokasi Presisi</h3>
            <button onclick="closeMapModal()" class="text-gray-400 text-2xl">&times;</button>
        </div>
        <div class="relative">
            <div id="mapPopup" style="height: 380px; width: 100%;"></div>
            <div class="absolute bottom-4 left-4 right-4 bg-white/95 p-3 rounded-xl shadow-lg z-[1000] border border-[#d2b48c]">
                <p class="text-[10px] font-bold text-[#6f4e37] uppercase">Lokasi Pinpoint:</p>
                <p id="modalAlamatText" class="text-xs text-gray-700 italic">Geser pin pada peta...</p>
            </div>
        </div>
        <div class="p-4 bg-white flex flex-col gap-3">
            <input type="hidden" id="currentAlamatId"><input type="hidden" id="modalLat"><input type="hidden" id="modalLng">
            <button onclick="saveMapSelection()" class="w-full bg-[#6f4e37] text-white py-3.5 rounded-xl font-bold shadow-lg">
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
                <div class="p-4 bg-white border {{ $a->is_utama ? 'border-[#6f4e37] ring-1 ring-[#6f4e37]' : 'border-gray-200' }} rounded-xl shadow-sm relative">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <span class="text-[10px] font-bold text-[#a88a64] uppercase tracking-widest">{{ $a->label_alamat }}</span>
                            <h4 class="font-bold text-[#4b3832] text-sm">{{ $a->nama_penerima }} <span class="text-gray-400 font-normal">| {{ $a->no_telepon }}</span></h4>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $a->alamat_lengkap }}</p>
                        </div>
                        <button onclick="openMapModal({{ $a->id }}, {{ $a->latitude }}, {{ $a->longitude }})" 
                                class="flex items-center gap-1 text-[10px] font-bold text-blue-600 border border-blue-100 px-2 py-1 rounded-lg hover:bg-blue-50 transition">
                            📍 PIN POINT
                        </button>
                    </div>
                    {{-- Di dalam Modal Daftar Alamat --}}
<div class="mt-3 pt-3 border-t border-gray-50 flex gap-4 text-[11px] font-bold">
    @if(!$a->is_utama)
        <button type="button" class="btn-set-utama text-orange-700 hover:underline" data-id="{{ $a->id }}">
            JADIKAN UTAMA
        </button>
    @else
        <span class="text-green-600 flex items-center gap-1">✔ ALAMAT UTAMA</span>
    @endif
    
    <button type="button" class="btn-hapus-alamat text-red-500 hover:underline" data-id="{{ $a->id }}">
        HAPUS
    </button>
</div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-10 text-sm">Belum ada alamat tersimpan.</p>
            @endforelse
        </div>
    </div>
</div>
<style>
    /* Mewarnai spinner loading agar tidak biru */
    .swal2-loader {
        border-color: #6f4e37 transparent #6f4e37 transparent !important;
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
function openModal() {
    document.getElementById('modalAlamat').classList.remove('hidden');
}
function closeModal() {
    document.getElementById('modalAlamat').classList.add('hidden');
}

// --- FUNGSI MAPS PIN POINT (UPDATE LOKASI) ---
let popMap, popMarker;
function openMapModal(id, lat, lng) {
    document.getElementById('mapModal').classList.remove('hidden');
    document.getElementById('currentAlamatId').value = id;

    setTimeout(() => {
        if (!popMap) {
            popMap = L.map('mapPopup').setView([lat, lng], 17);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(popMap);
            popMarker = L.marker([lat, lng], { draggable: true }).addTo(popMap);

            popMarker.on('dragend', (e) => updatePopLocation(e.target.getLatLng().lat, e.target.getLatLng().lng));
            popMap.on('click', (e) => {
                popMarker.setLatLng(e.latlng);
                updatePopLocation(e.latlng.lat, e.latlng.lng);
            });
        } else {
            popMap.setView([lat, lng], 17);
            popMarker.setLatLng([lat, lng]);
            popMap.invalidateSize();
        }
        updatePopLocation(lat, lng);
    }, 300);
}

function closeMapModal() {
    document.getElementById('mapModal').classList.add('hidden');
}

function updatePopLocation(lat, lng) {
    document.getElementById('modalLat').value = lat;
    document.getElementById('modalLng').value = lng;
    
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            const el = document.getElementById('modalAlamatText');
            if(el) el.innerText = data.display_name || "Lokasi terpilih";
        });
}

async function saveMapSelection() {
    const id = document.getElementById('currentAlamatId').value;
    const lat = document.getElementById('modalLat').value;
    const lng = document.getElementById('modalLng').value;

    Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

    try {
        const res = await fetch(`/profil/alamat/update-map/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ latitude: lat, longitude: lng })
        });
        const data = await res.json();
        if (data.success) {
            Swal.fire('Berhasil', 'Titik lokasi diperbarui', 'success').then(() => location.reload());
        }
    } catch (err) {
        Swal.fire('Error', 'Gagal menyimpan perubahan', 'error');
    }
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