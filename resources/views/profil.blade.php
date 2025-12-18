@extends('landing-page.landing-page')

@section('title', 'Profil Saya')

@section('profil')
<section class="max-w-5xl mx-auto px-4 md:px-8 py-16 bg-gradient-to-b from-[#fffaf6] to-[#f4ede5] rounded-3xl shadow-lg mt-24">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 p-3 rounded-lg mb-6 text-center shadow-sm animate-pulse">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM PROFIL --}}
<form action="{{ route('profil.alamat.store') }}" method="POST" enctype="multipart/form-data"
      class="bg-white/70 backdrop-blur-md p-8 rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 border border-[#e4d6c1]">
    @csrf
    <div class="flex flex-col md:flex-row gap-8 items-center">
        <!-- Foto Profil -->
        <div class="flex flex-col items-center md:w-1/3 space-y-3">
            <div class="relative group">
                <img src="{{ asset($user->profile_picture ?? 'uploads/default-user.png') }}"
                     alt="Foto Profil"
                     class="w-36 h-36 rounded-full object-cover border-4 border-[#c8a77a] shadow-md group-hover:scale-105 transition duration-300">
                <label class="absolute bottom-2 right-2 bg-[#6f4e37] hover:bg-[#5a3e2b] text-white text-xs px-2 py-1 rounded cursor-pointer shadow-md transition">
                    Ganti
                    <input type="file" name="profile_picture" class="hidden">
                </label>
            </div>
            <span class="text-xs text-[#7b5e45] italic">Format: JPG, PNG (maks. 2MB)</span>
        </div>

        <!-- Data Profil -->
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

            {{-- Field Pilih Alamat --}}
            <div>
                <label class="font-semibold text-[#4b2e12] block mb-1">Alamat Default</label>
                <select name="alamat_id" class="w-full border border-[#d6c4b1] rounded-lg p-3 bg-[#fffdfb] focus:ring-2 focus:ring-[#c8a77a] shadow-sm transition">
                    @if($alamat->count() > 0)
                        @foreach($alamat as $a)
                            <option value="{{ $a->id }}" {{ ($alamatUtama && $a->id == $alamatUtama->id) ? 'selected' : '' }}>
                                {{ $a->label }} — {{ $a->alamat }}, {{ $a->kota }}, {{ $a->provinsi }}
                            </option>
                        @endforeach
                    @else
                        <option value="">Belum ada alamat. Tambahkan di bawah.</option>
                    @endif
                </select>
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


    {{-- BAGIAN ALAMAT --}}
    <div class="mt-12 bg-white/80 backdrop-blur-md p-8 rounded-2xl shadow-xl border border-[#e4d6c1]">
        <h2 class="text-2xl font-bold text-[#4b2e12] mb-4 text-center">📍 Alamat Pengantaran</h2>

{{-- Form Tambah Alamat dengan Google Maps --}}
<div class="mt-6 p-6 border rounded-xl bg-white/90 shadow-lg">
    <h3 class="font-semibold text-[#6f4e37] mb-4 text-lg">📍 Tambah Alamat Baru</h3>
    <form id="formTambahAlamat">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="label" placeholder="Label (Rumah/Kantor dll)" class="w-full p-2 border rounded" >
            <input type="text" name="penerima" placeholder="Nama Penerima" class="w-full p-2 border rounded" >
            <input type="text" name="telepon" placeholder="Nomor Telepon" class="w-full p-2 border rounded" >
            <textarea name="alamat" id="alamatLengkap" placeholder="Alamat Lengkap" class="w-full p-2 border rounded" ></textarea>
            <input type="text" name="kota" id="kota" placeholder="Kota/Kabupaten" class="w-full p-2 border rounded">
            <input type="text" name="provinsi" id="provinsi" placeholder="Provinsi" class="w-full p-2 border rounded">
            <input type="text" name="kode_pos" id="kode_pos" placeholder="Kode Pos" class="w-full p-2 border rounded">
        </div>

        {{-- Map --}}
        <div class="mt-4">
            <label class="block font-semibold mb-1 text-[#4b2e12]">Tentukan Lokasi di Peta</label>
            <div id="map" style="height: 300px;" class="rounded border"></div>
            <small class="text-gray-500">Geser marker untuk menyesuaikan lokasi</small>
        </div>

        <div class="mt-4 flex items-end gap-2">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan Alamat</button>
        </div>
    </form>
</div>

        

      


        {{-- Container daftar alamat --}}
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
    </div>
</section>


<!-- SweetAlert2 harus sebelum initMap dipanggil -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8YrHpeOgD9P4QKMWa5i4NSM9Ju7TXJRw"
    async
    defer>
</script>



{{-- JavaScript AJAX --}}
<script>
const daftarAlamat = document.getElementById('daftarAlamat');
const formTambahAlamat = document.getElementById('formTambahAlamat');

// Tambah alamat
formTambahAlamat.addEventListener('submit', async function(e){
    e.preventDefault();
    const formData = new FormData(this);

    const res = await fetch("{{ route('profil') }}", {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    });

    const data = await res.json();

    if(data.success){
        alert(data.success);

        // Tambahkan ke DOM
        const alamat = data.alamat;
        const div = document.createElement('div');
        div.className = 'p-4 border rounded mb-3 bg-[#fffdfb] shadow-sm hover:shadow-md transition';
        div.dataset.id = alamat.id;
        div.innerHTML = `
            <strong class="text-[#4b2e12]">${alamat.label}</strong> — ${alamat.penerima} (${alamat.telepon})
            <p>${alamat.alamat}</p>
            <p class="text-gray-600">${alamat.kota}, ${alamat.provinsi} (${alamat.kode_pos})</p>
            <button class="setUtama text-yellow-600 hover:underline mt-1" data-id="${alamat.id}">Jadikan Alamat Utama</button>
            <button class="hapusAlamat text-red-600 hover:underline mt-1" data-id="${alamat.id}">Hapus</button>
        `;
        daftarAlamat.appendChild(div);

        formTambahAlamat.reset();
    } else {
        alert('Terjadi kesalahan!');
    }
});

// Hapus alamat & set utama
daftarAlamat.addEventListener('click', async function(e){
    const id = e.target.dataset.id;

    // Hapus alamat
    if(e.target.classList.contains('hapusAlamat')){
        if(confirm('Yakin ingin hapus alamat ini?')){
            const res = await fetch(`/profil/alamat/${id}`, {
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
            const data = await res.json();
            if(data.success) e.target.closest('div[data-id]').remove();
        }
    }

    // Set alamat utama
    if(e.target.classList.contains('setUtama')){
        const res = await fetch(`/profil/alamat-utama/${id}`, {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        });
        const data = await res.json();
        if(data.success) location.reload(); // reload untuk update tampilan alamat utama
    }
});
</script>


<script>
let map, marker, geocoder;

function initMap() {
    geocoder = new google.maps.Geocoder();

    // Default ke Jakarta
    const defaultLatLng = {lat: -6.200000, lng: 106.816666};
    map = new google.maps.Map(document.getElementById("map"), {
        center: defaultLatLng,
        zoom: 15
    });

    marker = new google.maps.Marker({
        position: defaultLatLng,
        map: map,
        draggable: true
    });

    // Cek geolocation otomatis
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position){
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
                marker.setPosition(pos);
                updateAddress(pos);
                Swal.fire('Sukses', 'Lokasi Anda berhasil dideteksi.', 'success');
            },
            function(error){
                console.warn('Geolocation error:', error.message);
                Swal.fire('Info', 'Tidak dapat mendeteksi lokasi. Gunakan marker manual.', 'info');
            }
        );
    } else {
        Swal.fire('Info', 'Browser Anda tidak mendukung Geolocation.', 'warning');
    }

    // Update alamat saat marker digeser
    marker.addListener('dragend', function(){
        updateAddress(marker.getPosition());
    });
}

function updateAddress(latlng){
    geocoder.geocode({'location': latlng}, function(results, status){
        if(status === 'OK' && results[0]){
            const address = results[0];
            document.getElementById('alamatLengkap').value = address.formatted_address;

            let kota='', provinsi='', kode_pos='';
            if(address.address_components){
                address.address_components.forEach(c=>{
                    if(c.types.includes('administrative_area_level_2')) kota = c.long_name;
                    if(c.types.includes('administrative_area_level_1')) provinsi = c.long_name;
                    if(c.types.includes('postal_code')) kode_pos = c.long_name;
                });
            }
            document.getElementById('kota').value = kota;
            document.getElementById('provinsi').value = provinsi;
            document.getElementById('kode_pos').value = kode_pos;
        }
    });
}
</script>





@endsection
