<header class="bg-white shadow px-6 py-4 flex justify-between items-center">
    <h2 class="text-lg font-semibold text-gray-700">
        Admin Dashboard
    </h2>

    <div class="flex items-center gap-4">
        <span class="text-gray-600">
            {{ auth()->user()->name }}
        </span>

    </div>
</header>
