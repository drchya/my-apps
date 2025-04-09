<!-- Mobile Modal Sidebar -->
<div x-show="sidebarOpen" class="md:hidden fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-60" x-transition>
    <div class="bg-gray-800 w-[90%] max-w-md rounded-lg shadow-xl p-6 relative" @click.outside="sidebarOpen = false">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-white">Menu Pendakian</h2>

            <button @click="sidebarOpen = false" class="top-3 right-3 text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <ul class="space-y-2">
            <li><a href="#" class="px-2 py-1 block rounded-sm font-medium bg-emerald-400 hover:bg-emerald-600 transition duration-300 ease-in-out">Dashboard</a></li>
            <li><a href="#" class="px-2 py-1 block rounded-sm text-gray-300 hover:bg-emerald-600 transition duration-300 ease-in-out">Pendakian</a></li>
            <li><a href="#" class="px-2 py-1 block rounded-sm text-gray-300 hover:bg-emerald-600 transition duration-300 ease-in-out">Gunung</a></li>
            <li><a href="#" class="px-2 py-1 block rounded-sm text-gray-300 hover:bg-emerald-600 transition duration-300 ease-in-out">Barang</a></li>
        </ul>
    </div>
</div>

<!-- Desktop Sidebar -->
<aside class="hidden md:block md:w-64 bg-gray-800 border-r border-gray-700">
    <div class="px-4 py-3">
        <h2 class="text-lg font-bold mb-2 text-white uppercase">my apps</h2>
        <hr class="text-gray-700 mb-2" />
        <ul class="space-y-2">
            <li><a href="#" class="px-2 py-1 block rounded-sm font-medium bg-emerald-500 hover:bg-emerald-600 transition duration-300 ease-in-out">Dashboard</a></li>
            <hr class="text-gray-700" />
            <li><a href="#" class="px-2 py-1 block rounded-sm text-gray-300 hover:bg-emerald-600 transition duration-300 ease-in-out">Pendakian</a></li>
            <li><a href="#" class="px-2 py-1 block rounded-sm text-gray-300 hover:bg-emerald-600 transition duration-300 ease-in-out">Gunung</a></li>
            <li><a href="#" class="px-2 py-1 block rounded-sm text-gray-300 hover:bg-emerald-600 transition duration-300 ease-in-out">Barang</a></li>
        </ul>
    </div>
</aside>
