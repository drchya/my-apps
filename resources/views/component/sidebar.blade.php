<!-- Mobile Modal Sidebar -->
<div x-show="sidebarOpen" class="xl:hidden fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-60" x-transition>
    <div class="bg-gray-800 w-[90%] max-w-lg rounded-lg shadow-xl p-6 relative" @click.outside="sidebarOpen = false">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-white">MY APPS</h2>
            <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <hr class="mb-4 text-gray-700">

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
        </ul>

        @include('component.sidebar_menu')
    </div>
</div>

<!-- Desktop Sidebar -->
<aside class="hidden xl:block md:w-64 bg-gray-800 border-r border-gray-700">
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

        @include('component.sidebar_menu')
    </div>
</aside>
