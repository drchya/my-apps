<!-- Mobile Modal Sidebar -->
<div x-show="sidebarOpen" class="xl:hidden fixed inset-0 z-40 flex items-center justify-center bg-black/10 backdrop-blur-md" x-transition>
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
                        relative flex items-center px-4 md:py-2 md:px-8 font-bold
                        {{ request()->routeIs('dashboard')
                            ? 'text-emerald-600'
                            : 'text-gray-600 hover:text-emerald-600'
                        }}
                        transition duration-300 ease-in-out
                    "
                >
                    @if(request()->routeIs('dashboard'))
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-7 bg-emerald-600 rounded-r-full"></span>
                    @endif
                    <div class="flex items-center justify-center w-6 h-6 md:mr-4">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                </a>
            </li>
        </ul>

        @include('component.sidebar_menu')
    </div>
</div>

<!-- Desktop Sidebar -->
<aside class="hidden xl:block md:w-64 bg-gray-800 border-r border-gray-700 shadow-lg">
    <div class="py-4">
        <h2 class="text-lg font-bold mb-4 text-white uppercase px-8">my apps</h2>
        <hr class="text-gray-700 mb-6" />
        <ul class="mb-2">
            <li>
                <a
                    href="{{ route('dashboard') }}"
                    class="relative flex items-center py-2 px-8 font-bold
                        {{ request()->routeIs('dashboard')
                            ? 'text-emerald-600 font-bold'
                            : 'text-gray-600 hover:text-emerald-600'
                        }}
                        transition duration-300 ease-in-out
                    "
                >
                    @if(request()->routeIs('dashboard'))
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-7 bg-emerald-600 rounded-r-full"></span>
                    @endif
                    <div class="flex items-center justify-center w-6 h-6 mr-4">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    Dashboard
                </a>
            </li>
        </ul>

        @include('component.sidebar_menu')
    </div>
</aside>
