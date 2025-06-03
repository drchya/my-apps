@php
    $isMountainActive = request()->routeIs([
        'mountain.*',
        'gear.*',
        'preparation.*'
    ]);
@endphp

<ul class="mb-2" x-data="{ openMountain: {{ $isMountainActive ? 'true' : 'false' }} }" x-init="$nextTick(() => { openMountain = {{ $isMountainActive ? 'true' : 'false' }} })">
    <li>
        <a href="#" @click.prevent="openMountain = !openMountain" class="relative flex items-center justify-between px-4 md:py-2 md:px-8 font-bold transition duration-300 ease-in-out {{ $isMountainActive ? 'text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
            <div class="flex items-center">
                @if($isMountainActive)
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-7 bg-emerald-600 rounded-r-full"></span>
                @endif
                <div class="w-6 h-6 md:mr-4 flex items-center justify-center">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                Expedition
            </div>

            <svg :class="{ 'rotate-180': openMountain }"
                 class="w-4 h-4 ml-2 transform transition-transform duration-300"
                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 9l-7 7-7-7" />
            </svg>
        </a>

        <!-- Transisi Slide Vertical -->
        <div x-ref="submenuContainer"
             x-show="openMountain"
             x-collapse.duration.500ms
             class="overflow-hidden transition-[max-height] duration-500 ease-in-out"
        >
            <ul class="font-semibold md:px-8 mt-1 space-y-1">
                @php
                    $submenus = [
                        ['route' => 'preparation.index', 'label' => 'Preparation'],
                        ['route' => 'mountain.index', 'label' => 'Mountain'],
                        ['route' => 'gear.index', 'label' => 'Gear'],
                    ];
                @endphp

                @foreach ($submenus as $item)
                    @php
                        $isActive = request()->routeIs(Str::before($item['route'], '.') . '.*');
                    @endphp
                    <li>
                        <a href="{{ route($item['route']) }}" class="flex items-center ml-2 px-8 transition duration-300 ease-in-out {{ $isActive ? 'text-white' : 'text-gray-600 hover:text-white' }}">
                            <div class="w-4 h-4 mr-1 md:mr-2 flex items-center justify-center {{ $isActive ? 'text-emerald-600' : 'text-gray-600 hover:text-white' }}">
                                <i class="fa-regular fa-circle-dot text-xs"></i>
                            </div>
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </li>
</ul>

@php
    $userSubmenus = [
        ['route' => 'users.index', 'label' => 'Users', 'adminOnly' => true],
        ['route' => 'users.profile', 'label' => 'Profile', 'adminOnly' => false],
        ['route' => 'users.recycle', 'label' => 'Trash Bin', 'adminOnly' => true],
    ];

    $isUserManajemenActive = false;
@endphp

@foreach ($userSubmenus as $submenu)
    @if (! $submenu['adminOnly'] || Auth::user()->id === 1)
        @php
            $isActive = request()->routeIs($submenu['route']);
            if ($isActive) {
                $isUserManajemenActive = true;
            }
        @endphp
    @endif
@endforeach

<ul class="mb-2" x-data="{ openUserManajemen: {{ $isUserManajemenActive ? 'true' : 'false' }} }">
    <li>
        <a href="#"
           @click.prevent="openUserManajemen = !openUserManajemen"
           class="relative flex items-center justify-between px-4 md:py-2 md:px-8 font-bold transition duration-300 ease-in-out {{ $isUserManajemenActive ? 'text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
            <div class="flex items-center">
                @if($isUserManajemenActive)
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-7 bg-emerald-600 rounded-r-full"></span>
                @endif
                <span class="flex items-center justify-center w-6 h-6 md:mr-4">
                    <i class="fas fa-users-cog"></i>
                </span>
                User Manajemen
            </div>

            <svg :class="{ 'rotate-180': openUserManajemen }"
                 class="w-4 h-4 ml-2 transform transition-transform duration-300"
                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 9l-7 7-7-7" />
            </svg>
        </a>

        <div x-show="openUserManajemen"
             x-collapse.duration.500ms
             class="overflow-hidden transition-[max-height] duration-500 ease-in-out"
        >
            <ul class="font-semibold md:px-8 mt-1 space-y-1">
                @foreach ($userSubmenus as $submenu)
                    @if (! $submenu['adminOnly'] || Auth::user()->id === 1)
                        @php
                            $isActive = request()->routeIs($submenu['route']);
                        @endphp
                        <li>
                            <a href="{{ route($submenu['route'], $submenu['route'] === 'users.profile' ? Auth::user()->slug : null) }}" class="flex items-center ml-2 px-8 transition duration-300 ease-in-out {{ $isActive ? 'text-white' : 'text-gray-600 hover:text-white' }}">
                                <div class="w-4 h-4 mr-2 flex items-center justify-center {{ $isActive ? 'text-emerald-600' : 'text-gray-500 hover:text-white' }}">
                                    <i class="fa-regular fa-circle-dot text-xs"></i>
                                </div>
                                {{ $submenu['label'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </li>
</ul>

@php
    $settingSubMenus = [
        ['route' => 'setting.type.index', 'label' => 'Type', 'adminOnly' => true],
        ['route' => 'setting.category.index', 'label' => 'Category', 'adminOnly' => true],
        ['route' => 'setting.status.index', 'label' => 'Status', 'adminOnly' => true],
    ];

    $isSettingActive = false;

    foreach ($settingSubMenus as $submenu) {
        if (! $submenu['adminOnly'] || Auth::user()->id === 1) {
            $pattern = str_replace('.index', '.*', $submenu['route']);
            if (request()->routeIs($pattern)) {
                $isSettingActive = true;
                break;
            }
        }
    }
@endphp

@if (Auth::user()->id === 1)
    <ul class="mb-2" x-data="{ openSetting: {{ $isSettingActive ? 'true' : 'false' }} }">
        <li>
            <a href="#"
               @click.prevent="openSetting = !openSetting"
               class="relative flex items-center justify-between px-4 md:py-2 md:px-8 font-bold transition duration-300 ease-in-out {{ $isSettingActive ? 'text-emerald-600' : 'text-gray-600 hover:text-emerald-600' }}">
                <div class="flex items-center">
                    @if ($isSettingActive)
                        <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-7 bg-emerald-600 rounded-r-full"></span>
                    @endif
                    <div class="flex items-center justify-center w-6 h-6 md:mr-4">
                        <i class="fas fa-cog"></i>
                    </div>
                    Setting
                </div>
                <svg :class="{ 'rotate-180': openSetting }"
                     class="w-4 h-4 ml-2 transform transition-transform duration-300"
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </a>

            <div x-show="openSetting"
                 x-collapse.duration.500ms
                 class="overflow-hidden transition-[max-height] duration-500 ease-in-out">
                <ul class="font-semibold md:px-8 mt-1 space-y-1">
                    @foreach ($settingSubMenus as $submenu)
                        @if (! $submenu['adminOnly'] || Auth::user()->id === 1)
                            @php
                                $pattern = str_replace('.index', '.*', $submenu['route']);
                                $isActive = request()->routeIs($pattern);
                            @endphp

                            <li>
                                <a
                                    href="{{ route($submenu['route']) }}"
                                    class="flex items-center ml-2 px-8 transition duration-300 ease-in-out {{ $isActive ? 'text-white' : 'text-gray-600 hover:text-white' }}"
                                >
                                    <div class="w-4 h-4 mr-2 flex items-center justify-center {{ $isActive ? 'text-emerald-600' : 'text-gray-500 hover:text-white' }}">
                                        <i class="fa-regular fa-circle-dot text-xs"></i>
                                    </div>
                                    {{ $submenu['label'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </li>
    </ul>
@endif
