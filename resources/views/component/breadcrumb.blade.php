@php
<<<<<<< Updated upstream
    use Illuminate\Support\Facades\Route;

    $currentRoute = Route::currentRouteName();
    $currentParams = Route::current()->parameters();

    $breadcrumbs = \App\Models\Breadcrumb::orderBy('order')->get();
    $filtered = $breadcrumbs->filter(fn($bc) => str_contains($currentRoute, $bc->route_name));
=======
use Illuminate\Support\Facades\Route;

$currentRoute = Route::currentRouteName();
$currentParams = Route::current()->parameters();

$breadcrumbMap = [
    'dashboard' => ['Dashboard' => route('dashboard')],
    'gear.index' => ['Gear' => route('gear.index')],
    'gear.user.show' => [
        'Gear' => route('gear.index'),
        'User Gear' => route('gear.user.show', $currentParams['slug'] ?? 0),
    ],
    'users.profile' => [
        'Users' => route('users.index'),
        'Profile' => isset($currentParams['slug'])
                    ? route('users.profile', $currentParams['slug'])
                    : '#',
    ],
    'preparation.show' => [
        'Preparation' => route('preparation.index'),
        'Detail' => isset($currentParams['preparation'])
                    ? route('preparation.show', $currentParams['preparation'])
                    : '#',
    ],
    'preparation.mountain.show' => [
        'Preparation' => route('preparation.index'),
        'Mountain' => isset($currentParams['slug'])
                        ? route('preparation.mountain.show', $currentParams['slug'])
                        : '#',
    ],
    // Tambahkan route lainnya sesuai kebutuhan
];

$breadcrumb = $breadcrumbMap[$currentRoute] ?? [];
>>>>>>> Stashed changes
@endphp

<nav class="flex flex-col md:flex-row md:items-center md:justify-between mb-4" aria-label="Breadcrumb">
    <!-- Title -->
    <div>
        <h1 class="text-xl font-semibold text-white tracking-wide">
            {{ $title }}
        </h1>
    </div>

    <!-- Breadcrumb -->
<<<<<<< Updated upstream
    <ul class="flex flex-wrap items-center text-sm gap-1"
        x-data="{ isMobile: window.innerWidth < 768 }"
        x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 768)"
    >
=======
    <ul class="flex flex-wrap items-center text-sm">
>>>>>>> Stashed changes
        <li>
            <a href="{{ url('/') }}" class="text-gray-300 hover:text-emerald-600 transition duration-150 ease-in-out">Home</a>
        </li>

<<<<<<< Updated upstream
        @foreach($filtered as $bc)
            <li class="text-gray-300">/</li>
            <li>
                @if ($loop->last)
                    <span class="text-emerald-600">{{ $bc->label }}</span>
                @else
                    <a href="{{ $bc->url ?? route($bc->route_name, $currentParams) }}" class="text-gray-300 hover:text-emerald-600 transition duration-150 ease-in-out">{{ $bc->label }}</a>
                @endif
            </li>
=======
        @foreach ($breadcrumb as $label => $link)
            <li><span class="text-gray-600 px-1">/</span></li>
            @if ($loop->last)
                <li class="text-emerald-500">{{ $label }}</li>
            @else
                <li>
                    <a href="{{ $link }}" class="text-gray-300 hover:text-emerald-600 transition duration-150 ease-in-out">
                        {{ $label }}
                    </a>
                </li>
            @endif
>>>>>>> Stashed changes
        @endforeach
    </ul>
</nav>
