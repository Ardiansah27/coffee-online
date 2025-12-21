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

                <div class="mt-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-[#4b2e12]">Alamat Saya</h2>
        {{-- Ganti button menjadi tag <a> --}}
        <a href="{{ route('profil.alamat.create') }}" class="bg-[#8c6239] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#6f4e37] transition inline-flex items-center">
            + Tambah Alamat Baru
        </a>
    </div>
</div>
            </div>
        </div>

        <div class="text-center pt-4">
            <button type="submit"
                    class="bg-gradient-to-r from-[#8c6239] to-[#6f4e37] text-white font-semibold px-8 py-3 rounded-full shadow-md hover:shadow-lg hover:scale-105 transition-all duration-300">
                Simpan Perubahan
            </button>
        </div>
    </form>

    {{-- Modal Alamat --}}
    <div id="modalAlamat" class="fixed inset-0 z-[9999] hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-2">
        <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden animate__animated animate__zoomIn max-h-[95vh] flex flex-col">
            <div class="p-3 border-b flex justify-between items-center bg-[#fffaf6]">
                <h3 class="font-bold text-base text-[#4b2e12]">📍 Tambah Lokasi Alamat</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-2xl px-2">&times;</button>
            </div>
            <div class="overflow-y-auto p-4 custom-scrollbar">
                <form id="formTambahAlamat" autocomplete="off">
                    @csrf
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <input type="text" name="penerima" placeholder="Nama Penerima" class="border border-[#d6c4b1] rounded-lg p-2 bg-[#fffdfb] focus:ring-2 focus:ring-[#c8a77a] text-sm" required>
                        <input type="text" name="telepon" placeholder="Nomor Telepon" class="border border-[#d6c4b1] rounded-lg p-2 bg-[#fffdfb] focus:ring-2 focus:ring-[#c8a77a] text-sm" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="label" placeholder="Label (Contoh: Rumah / Kantor)" class="border border-[#d6c4b1] rounded-lg p-2 w-full bg-[#fffdfb] focus:ring-2 focus:ring-[#c8a77a] text-sm" required>
                    </div>
                    <div class="relative mb-3">
                        <div id="mapAlamatProfil" style="height: 200px;" class="rounded-lg shadow-inner border border-[#d6c4b1] w-full"></div>
                        <button type="button" id="btnLokasiSaya" class="absolute top-2 right-2 z-[1000] bg-white px-2 py-1 rounded-md shadow-md hover:bg-gray-100 text-xs flex items-center gap-1 border border-gray-200">
                            🎯 Lokasi Saya
                        </button>
                    </div>
                    <div class="mb-3">
                        <textarea name="alamat" id="alamatLengkap" rows="2" class="w-full border border-[#d6c4b1] rounded-lg p-2 bg-[#fffdfb] focus:ring-2 focus:ring-[#c8a77a] text-sm" placeholder="Alamat lengkap / patokan..."></textarea>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mb-3">
                        <input type="text" name="kota" id="kota" placeholder="Kota" class="border border-[#d6c4b1] rounded-lg p-2 bg-gray-50 text-xs shadow-sm" readonly>
                        <input type="text" name="provinsi" id="provinsi" placeholder="Provinsi" class="border border-[#d6c4b1] rounded-lg p-2 bg-gray-50 text-xs shadow-sm" readonly>
                        <input type="text" name="kode_pos" id="kode_pos" placeholder="Pos" class="border border-[#d6c4b1] rounded-lg p-2 bg-gray-50 text-xs shadow-sm" readonly>
                    </div>
                    <input type="hidden" name="latitude" id="lat">
                    <input type="hidden" name="longitude" id="lng">
                    <input type="hidden" name="jarak" id="jarak_input">
                    <div class="flex justify-end gap-3 mt-4">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm text-gray-500 font-semibold hover:text-gray-700">Batal</button>
                        <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-full font-bold shadow-lg hover:bg-orange-700 transition text-sm">Konfirmasi Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Daftar Alamat --}}
    <div id="daftarAlamat" class="mt-4">
        @foreach($alamat as $a)
            <div class="p-4 border rounded mb-3 bg-[#fffdfb] shadow-sm hover:shadow-md transition" data-id="{{ $a->id }}">
                <strong class="text-[#4b2e12]">{{ $a->label }}</strong> — {{ $a->penerima }} ({{ $a->telepon }})
                <p>{{ $a->alamat }}</p>
                <p class="text-gray-600">{{ $a->kota }}, {{ $a->provinsi }} ({{ $a->kode_pos }})</p>
                @if(!$a->is_utama)
                    <button class="setUtama text-yellow-600 hover:underline mt-1" data-id="{{ $a->id }}">Jadikan Alamat Utama</button>
                @else
                    <span class="text-green-600 font-semibold">✔ Alamat Utama</span>
                @endif
                <button class="hapusAlamat text-red-600 hover:underline mt-1" data-id="{{ $a->id }}">Hapus</button>
            </div>
        @endforeach
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Preview Foto Profil
    const inputFoto = document.getElementById('input-foto');
    const previewFoto = document.getElementById('preview-foto');
    if (inputFoto && previewFoto) {
        inputFoto.addEventListener('change', () => {
            const file = inputFoto.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => previewFoto.src = e.target.result;
                reader.readAsDataURL(file);
            }
        });
    }

    // Popup Info Foto
    const btnInfo = document.getElementById('infoFotoBtn');
    const popupInfo = document.getElementById('infoFotoPopup');
    if (btnInfo && popupInfo) {
        btnInfo.addEventListener('click', e => {
            e.stopPropagation();
            popupInfo.classList.toggle('hidden');
        });
        document.addEventListener('click', () => popupInfo.classList.add('hidden'));
    }
});

// Modal & Leaflet Map Alamat
let mapProfil, markerProfil;
function openModal() {
    document.getElementById('modalAlamat').classList.remove('hidden');
    setTimeout(() => {
        const defaultPos = [-6.200000, 106.816666];
        if (!mapProfil) {
            mapProfil = L.map('mapAlamatProfil').setView(defaultPos, 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(mapProfil);
            markerProfil = L.marker(defaultPos, { draggable: true }).addTo(mapProfil);
            markerProfil.on('dragend', e => fillLocationData(e.target.getLatLng().lat, e.target.getLatLng().lng));
            mapProfil.on('click', e => { markerProfil.setLatLng(e.latlng); fillLocationData(e.latlng.lat, e.latlng.lng); });
        } else { mapProfil.invalidateSize(); }
    }, 300);
}

function closeModal() { document.getElementById('modalAlamat').classList.add('hidden'); }
function fillLocationData(lat, lng) {
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            if(data.display_name) document.getElementById('alamatLengkap').value = data.display_name;
        });
}

// Submit Tambah Alamat
const formTambahAlamat = document.getElementById('formTambahAlamat');
if (formTambahAlamat) {
    formTambahAlamat.addEventListener('submit', async e => {
        e.preventDefault();
        const formData = new FormData(formTambahAlamat);
        try {
            const res = await fetch("{{ route('profil.alamat.store') }}", { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: formData });
            const data = await res.json();
            if(res.ok && data.success) Swal.fire('Berhasil', data.success, 'success').then(() => location.reload());
            else Swal.fire('Gagal', data.error||'Terjadi kesalahan','error');
        } catch { Swal.fire('Error','Server tidak merespon','error'); }
    });
}

// Hapus & Set Alamat Utama
const daftarAlamat = document.getElementById('daftarAlamat');
if (daftarAlamat) {
    daftarAlamat.addEventListener('click', async e => {
        const id = e.target.dataset.id; if(!id) return;
        if(e.target.classList.contains('hapusAlamat')){
            if(!confirm('Hapus alamat ini?')) return;
            const res = await fetch(`/profil/alamat/${id}`, { method:'DELETE', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
            const data = await res.json();
            if(data.success) e.target.closest('.border').remove();
        }
        if(e.target.classList.contains('setUtama')) await setUtama(id);
    });
}

async function setUtama(id){
    const res = await fetch(`/profil/alamat-utama/${id}`, { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
    const data = await res.json();
    if(data.success) Swal.fire('Berhasil','Alamat utama diperbarui','success').then(()=>location.reload());
}

// Lokasi Saya
const btnLokasiSaya = document.getElementById('btnLokasiSaya');
if(btnLokasiSaya){
    btnLokasiSaya.addEventListener('click', () => {
        if(!navigator.geolocation) return;
        btnLokasiSaya.innerHTML='⏳ Mencari...'; btnLokasiSaya.disabled=true;
        navigator.geolocation.getCurrentPosition(pos=>{
            const {latitude, longitude}=pos.coords;
            const latLng=L.latLng(latitude, longitude);
            markerProfil.setLatLng(latLng); mapProfil.setView(latLng,17); fillLocationData(latitude, longitude);
            btnLokasiSaya.innerHTML='🎯 Lokasi Saya'; btnLokasiSaya.disabled=false;
        }, ()=>{
            btnLokasiSaya.innerHTML='🎯 Lokasi Saya'; btnLokasiSaya.disabled=false;
            Swal.fire('Gagal','Akses lokasi ditolak','error');
        });
    });
}
</script>
@endsection
