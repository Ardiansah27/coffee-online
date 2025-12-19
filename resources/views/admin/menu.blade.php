@extends('admin.layouts-admin.app')

@section('content')
<div class="container mx-auto pb-10">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold text-gray-800 tracking-tight">Manajemen Menu Coffee</h3>
        <span class="text-sm text-gray-500">{{ now()->format('d F Y') }}</span>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-900 font-bold">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- FORM TAMBAH (Kiri) --}}
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
           
                <form action="{{ route('admin.menu.add') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Nama Menu</label>
                        <input type="text" name="name" placeholder="Contoh: Caramel Latte" required 
                               class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#695cfe] focus:border-transparent outline-none transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Kategori</label>
                        <select name="category" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#695cfe] outline-none">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Espresso Based">Espresso Based</option>
                            <option value="Manual Brew">Manual Brew</option>
                            <option value="Signature">Signature</option>
                            <option value="Non-Coffee">Non-Coffee</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Harga (Rp)</label>
                        <input type="number" name="price" placeholder="25000" required 
                               class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#695cfe] outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi</label>
                        <textarea name="description" rows="3" placeholder="Jelaskan menu singkat saja..." 
                                  class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#695cfe] outline-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Foto Menu</label>
                        <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>

                    <button class="w-full bg-[#695cfe] hover:bg-[#574cbd] text-white font-bold py-3 rounded-xl transition shadow-lg shadow-indigo-200">
                        Simpan Menu
                    </button>
                </form>
            </div>
        </div>

        {{-- TABLE (Kanan) --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50">
                    <h4 class="text-lg font-semibold text-gray-700">Daftar Menu Tersedia</h4>
                </div>
              <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Menu</th>
                <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Harga</th>
                <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase">Kategori</th>
                <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($menus as $menu)
            <tr class="hover:bg-gray-50 transition">
                {{-- Kolom 1: Menu (Gambar & Nama) --}}
                <td class="px-6 py-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                            @if($menu->image)
                                <img src="{{ asset('images/menu/'.$menu->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-[10px]">No Pic</div>
                            @endif
                        </div>
                        <span class="font-bold text-gray-800">{{ $menu->name }}</span>
                    </div>
                </td>

                {{-- Kolom 2: Harga --}}
                <td class="px-6 py-4 font-semibold text-gray-700">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </td>

                {{-- Kolom 3: Kategori --}}
                <td class="px-6 py-4">
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-indigo-50 text-indigo-600">
                        {{ $menu->category }}
                    </span>
                </td>

                {{-- Kolom 4: Aksi --}}
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-3">
                        {{-- Tombol Edit --}}
                        <button onclick="openEditModal({{ $menu }})" 
                                class="flex items-center gap-1 text-indigo-600 hover:bg-indigo-50 px-3 py-1 rounded-lg transition border border-transparent hover:border-indigo-100">
                            ✏️ <span class="text-sm font-medium">Edit</span>
                        </button>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.menu.delete', $menu->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="flex items-center gap-1 text-red-500 hover:bg-red-50 px-3 py-1 rounded-lg transition border border-transparent hover:border-red-100">
                                🗑️ <span class="text-sm font-medium">Hapus</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
                @if($menus->isEmpty())
                    <div class="p-10 text-center text-gray-400">
                        Belum ada menu yang ditambahkan.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl transform transition-all scale-95 opacity-0" id="modalContent">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">Ubah Menu Coffee</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-3xl">&times;</button>
        </div>

        <form id="editForm" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            {{-- Karena route Anda menggunakan POST untuk update, tidak perlu @method('PUT') kecuali route Anda tipe PUT --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Menu</label>
                <input type="text" name="name" id="edit_name" required 
                       class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Kategori</label>
                <select name="category" id="edit_category" required class="w-full px-4 py-2 border rounded-xl outline-none">
                    <option value="Espresso Based">Espresso Based</option>
                    <option value="Manual Brew">Manual Brew</option>
                    <option value="Signature">Signature</option>
                    <option value="Non-Coffee">Non-Coffee</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Harga (Rp)</label>
                <input type="number" name="price" id="edit_price" required 
                       class="w-full px-4 py-2 border rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Update Foto (Kosongkan jika tidak diubah)</label>
                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-indigo-50 file:text-indigo-700">
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold">Batal</button>
                <button type="submit" class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-200">Update Data</button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPTS --}}
<script>
    function openEditModal(menu) {
        const form = document.getElementById('editForm');
        // Set action URL secara dinamis sesuai ID menu
        form.action = `/admin/menu/update/${menu.id}`;
        
        // Isi data menu ke dalam input form modal
        document.getElementById('edit_name').value = menu.name;
        document.getElementById('edit_category').value = menu.category;
        document.getElementById('edit_price').value = menu.price;

        const modal = document.getElementById('editModal');
        const content = document.getElementById('modalContent');
        
        // Tampilkan modal dengan animasi
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const content = document.getElementById('modalContent');
        
        // Sembunyikan modal dengan animasi
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
</script>
@endsection