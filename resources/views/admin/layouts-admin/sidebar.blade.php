<aside class="fixed top-0 left-0 flex flex-col w-64 h-screen bg-[#11121a] text-gray-400 font-sans border-r border-gray-800 z-50">
    
    <div class="flex items-center gap-3 p-6">
        <div class="flex items-center justify-center min-w-[40px] h-10 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-500/20">
            <span class="text-white font-bold text-lg leading-none">SE</span>
        </div>
        <div class="flex flex-col overflow-hidden leading-tight">
            <span class="text-white font-bold text-base truncate">SARONGGE</span>
            <span class="text-xs text-gray-500 truncate">ADMIN COFFE</span>
        </div>
    </div>

    <nav class="flex-1 px-4 py-2 space-y-1 overflow-y-auto">
     

        <a href="{{ route('admin.dashboard') }}" 
            class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200 hover:bg-[#1d1f2b] group {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white hover:bg-indigo-600' : '' }}">
            <span class="text-xl group-hover:scale-110 transition-transform">📊</span>
            <span class="font-medium text-[15px]">Dashboard</span>
        </a>

        <a href="{{ route('admin.menu') }}" 
            class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200 hover:bg-[#1d1f2b] group {{ request()->routeIs('admin.menu') ? 'bg-indigo-600 text-white hover:bg-indigo-600' : '' }}">
            <span class="text-xl group-hover:scale-110 transition-transform">☕</span>
            <span class="font-medium text-[15px]">Menu Coffee</span>
        </a>

        {{-- Menu Lokasi Resto --}}
<a href="{{ route('admin.resto.index') }}" 
    class="flex items-center gap-4 px-3 py-3 rounded-xl transition-all duration-200 hover:bg-[#1d1f2b] group {{ request()->routeIs('admin.resto.*') ? 'bg-indigo-600 text-white hover:bg-indigo-600' : '' }}">
    <span class="text-xl group-hover:scale-110 transition-transform">📍</span>
    <span class="font-medium text-[15px]">Lokasi Resto</span>
</a>
        
        
    </nav>

    <div class="p-4 mt-auto border-t border-gray-800 space-y-3">
  {{-- Form Logout --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center gap-4 px-3 py-3 rounded-xl hover:bg-red-500/10 hover:text-red-500 transition-all group outline-none">
            {{-- Icon Pintu --}}
            <span class="text-xl group-hover:translate-x-1 transition-transform">🚪</span>
            {{-- Teks --}}
            <span class="font-medium text-[15px]">Logout</span>
        </button>
    </form>
    </div>
</aside>