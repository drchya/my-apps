@php
    $isMountainActive = request()->routeIs('mountain.*');
@endphp

<ul class="mb-2 space-y-2" x-data="{ openMountain: {{ $isMountainActive ? 'true' : 'false' }} }" x-init="$nextTick(() => { openMountain = {{ $isMountainActive ? 'true' : 'false' }} })">
    <li>
        <a href="#" @click.prevent="openMountain = !openMountain" class="px-2 py-1 font-medium border-l-2 {{ $isMountainActive ? 'border-emerald-600 text-white' : 'border-transparent text-gray-300 hover:border-emerald-600 hover:bg-emerald-900/25' }} transition duration-300 ease-in-out flex justify-between items-center">
            Expedition
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
                    <i class="text-xs fa-regular fa-circle"></i> Preparation
                </a>
            </li>
            <li>
                <a href="{{ route('mountain.index') }}" class="flex items-center gap-2 text-xs px-3 py-2 border-y {{ request()->routeIs('mountain.*') ? 'border-emerald-900 text-white bg-emerald-600' : 'border-gray-800 text-gray-300 hover:bg-emerald-600' }} transition duration-300 ease-in-out">
                    <i class="text-xs fa-regular fa-circle"></i> Mountain
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center gap-2 text-xs px-3 py-2 border-y border-gray-800 text-gray-300 hover:bg-emerald-600 transition duration-300 ease-in-out">
                    <i class="text-xs fa-regular fa-circle"></i> Gear
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
            @if (Auth::user()->id === 1)
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
            @endif

            <li>
                <a
                    href="{{ route('users.profile', Auth::user()->slug) }}"
                    class="
                        flex items-center gap-2 text-xs px-3 py-2 border-y {{ request()->routeIs('users.profile') ? 'border-emerald-900 text-white bg-emerald-600' : 'border-gray-800 text-gray-300 hover:bg-emerald-600' }} transition duration-300 ease-in-out
                    "
                >
                    <i class="text-xs fa-regular fa-circle"></i> Profile
                </a>
            </li>

            @if (Auth::user()->id === 1)
                <li>
                    <a
                        href="{{ route('users.recycle') }}"
                        class="
                            flex items-center gap-2 text-xs px-3 py-2 border-y {{ request()->routeIs('users.recycle') ? 'border-emerald-900 text-white bg-emerald-600' : 'border-gray-800 text-gray-300 hover:bg-emerald-600' }} transition duration-300 ease-in-out
                        "
                    >
                        <i class="text-xs fa-regular fa-circle"></i> Trash Bin
                    </a>
                </li>
            @endif
        </ul>
    </li>
</ul>
