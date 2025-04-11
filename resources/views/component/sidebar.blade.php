<!-- Mobile Modal Sidebar -->
<div x-show="sidebarOpen" class="md:hidden fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-60" x-transition>
    <div class="bg-gray-800 w-[90%] max-w-md rounded-lg shadow-xl p-6 relative" @click.outside="sidebarOpen = false">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-white">Menu Pendakian</h2>
            <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <ul class="space-y-2" x-data="{ openMountain: false }">
            <li>
                <a href="#" class="block px-2 py-1 rounded-sm font-medium bg-emerald-400 text-white hover:bg-emerald-600 transition duration-300">Dashboard</a>
            </li>

            <li>
                <a href="#"
                   @click.prevent="openMountain = !openMountain"
                   class="flex justify-between items-center px-2 py-1 rounded-sm text-gray-300 hover:bg-emerald-600 transition duration-300">
                    Mountain
                    <svg :class="{ 'rotate-180': openMountain }" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>
                <ul x-show="openMountain"
                    x-transition
                    class="mt-1 ml-3 space-y-1 border-l border-emerald-600 pl-2 text-sm">
                    <li><a href="#" class="block px-2 py-1 rounded-sm text-gray-300 hover:bg-emerald-700">Pendakian</a></li>
                    <li><a href="#" class="block px-2 py-1 rounded-sm text-gray-300 hover:bg-emerald-700">Gunung</a></li>
                    <li><a href="#" class="block px-2 py-1 rounded-sm text-gray-300 hover:bg-emerald-700">Barang</a></li>
                </ul>
            </li>

            <!-- Menu lainnya -->
            <li><a href="#" class="block px-2 py-1 rounded-sm text-gray-300 hover:bg-emerald-600 transition duration-300">Transportasi</a></li>
        </ul>
    </div>
</div>

<!-- Desktop Sidebar -->
<aside class="hidden md:block md:w-64 bg-gray-800 border-r border-gray-700">
    <div class="px-4 py-3">
        <h2 class="text-lg font-bold mb-2 text-white uppercase">my apps</h2>
        <hr class="text-gray-700 mb-2" />
        <ul class="mb-2 space-y-2">
            <li>
                <a
                    href="{{ route('dashboard') }}"
                    class="
                        {{ request()->routeIs('dashboard')
                            ? 'px-2 py-1 block font-medium border-l-2 border-emerald-600 bg-emerald-600 hover:bg-emerald-600 transition duration-300 ease-in-out'
                            : 'px-2 py-1 block font-medium text-gray-300 border-l-2 border-l-transparent hover:border-emerald-600 hover:bg-emerald-900/25 transition duration-300 ease-in-out'
                        }}
                    "
                >
                    Dashboard
                </a>
            </li>
            <hr class="text-gray-700" />
        </ul>

        <ul class="mb-2 space-y-2" x-data="{ openMountain: false }">
            <li>
                <a href="#" @click.prevent="openMountain = !openMountain" class="px-2 py-1 font-medium text-gray-300 border-l-2 border-l-transparent hover:border-emerald-600 hover:bg-emerald-900/25 transition duration-300 ease-in-out flex justify-between items-center">
                    Mountain
                    <svg x-show="!openMountain" class="w-4 h-4 ml-2 transform transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg x-show="openMountain" class="w-4 h-4 ml-2 transform rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </a>

                <ul
                    x-show="openMountain"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-y-75"
                    x-transition:enter-end="opacity-100 scale-y-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-y-100"
                    x-transition:leave-end="opacity-0 scale-y-75"
                    class="bg-emerald-900/25 origin-top transform border-l-2 border-emerald-600"
                >
                    <li>
                        <a href="#" class="flex items-center gap-2 text-xs px-3 py-2 border-y border-gray-800 text-gray-300 hover:bg-emerald-600 transition duration-300 ease-in-out">
                            <i class="text-xs fa-regular fa-circle"></i> Pendakian
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-2 text-xs px-3 py-2 border-y border-gray-800 text-gray-300 hover:bg-emerald-600 transition duration-300 ease-in-out">
                            <i class="text-xs fa-regular fa-circle"></i> Gunung
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-2 text-xs px-3 py-2 border-y border-gray-800 text-gray-300 hover:bg-emerald-600 transition duration-300 ease-in-out">
                            <i class="text-xs fa-regular fa-circle"></i> Barang
                        </a>
                    </li>
                </ul>
            </li>
        </ul>


        @php
            $isUserManajemenActive = request()->routeIs('users.*');
        @endphp

        <ul class="mb-2 space-y-2" x-data="{ openUserManajemen: {{ $isUserManajemenActive ? 'true' : 'false' }} }" x-init="$nextTick(() => { openUserManajemen = {{ $isUserManajemenActive ? 'true' : 'false' }} })">
            <li>
                <a href="#"
                    @click.prevent="openUserManajemen = !openUserManajemen"
                    class="
                        px-2 py-1 font-medium border-l-2 {{ $isUserManajemenActive ? 'border-emerald-600 text-white' : 'border-transparent text-gray-300 hover:border-emerald-600 hover:bg-emerald-900/25' }} transition duration-300 ease-in-out flex justify-between items-center
                    "
                >
                    User Manajemen
                    <svg x-show="!openUserManajemen" class="w-4 h-4 ml-2 transform transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                    <svg x-show="openUserManajemen" class="w-4 h-4 ml-2 transform rotate-180 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </a>

                <ul
                    x-show="openUserManajemen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-y-75"
                    x-transition:enter-end="opacity-100 scale-y-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-y-100"
                    x-transition:leave-end="opacity-0 scale-y-75"
                    class="bg-emerald-900/25 origin-top transform border-l-2 border-emerald-600"
                >
                    <li>
                        <a
                            href="{{ route('users.index') }}"
                            class="
                                flex items-center gap-2 text-xs px-3 py-2 border-y {{ request()->routeIs('users.index') ? 'border-emerald-900 text-white bg-emerald-600' : 'border-gray-800 text-gray-300 hover:bg-emerald-600' }} transition duration-300 ease-in-out
                            "
                        >
                            <i class="text-xs fa-regular fa-circle"></i> Users
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-2 text-xs px-3 py-2 border-y border-gray-800 text-gray-300 hover:bg-emerald-600 transition duration-300 ease-in-out">
                            <i class="text-xs fa-regular fa-circle"></i> Profile
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
