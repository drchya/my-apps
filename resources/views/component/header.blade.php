<!-- Topbar -->
<header class="bg-gray-800 border-b border-gray-700 px-6 py-4 flex items-center justify-between">
    <button @click="sidebarOpen = true" class="xl:hidden text-gray-300 hover:text-white cursor-pointer my-0.5">
        <i class="fa-solid fa-bars"></i>
    </button>
    <h2 class="font-semibold text-white text-base uppercase my-0.5">{{ Auth::user()->username ?? "You don't have username" }}</h2>
    @if (session('success'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-0 mr-4 mt-28 bg-emerald-500/70 text-white px-4 py-2 rounded text-center shadow-md"
        >
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <div x-data="{ open: false }" class="relative my-0.5">
        <button
            @click="open = !open"
            class="flex items-center text-gray-300 hover:text-white focus:outline-none text-sm cursor-pointer"
        >
            <i class="far fa-user-circle"></i>
        </button>

        <div
            x-show="open"
            @click.away="open = false"
            x-transition
            class="absolute right-0 mt-2 w-40 bg-gray-700 rounded-md shadow-lg z-50 py-1"
        >
            <a href="{{ route('users.profile', Auth::user()->slug) }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-600">Profile</a>
            <?php if (Auth::user()->id === 1) : ?>
                <a href="#" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-600">Settings</a>
            <?php endif; ?>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-200 hover:bg-gray-600 cursor-pointer">Logout</button>
            </form>
        </div>
    </div>
</header>
