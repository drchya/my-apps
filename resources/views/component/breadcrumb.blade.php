@php
    use Illuminate\Support\Facades\Route;

    $currentRoute = Route::currentRouteName();
    $currentParams = Route::current()->parameters();

    $breadcrumbs = \App\Models\Breadcrumb::orderBy('order')->get();
    $filtered = $breadcrumbs->filter(fn($bc) => str_contains($currentRoute, $bc->route_name));
@endphp

<nav class="flex flex-col md:flex-row md:items-center md:justify-between mb-4" aria-label="Breadcrumb">
    <!-- Title -->
    <div>
        <h1 class="text-xl font-semibold text-white tracking-wide">
            {{ $title }}
        </h1>
    </div>

    <!-- Breadcrumb -->
    <ul class="flex flex-wrap items-center text-sm gap-1"
        x-data="{ isMobile: window.innerWidth < 768 }"
        x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 768)"
    >
        <li>
            <a href="{{ url('/') }}" class="text-gray-300 hover:text-emerald-600 transition duration-150 ease-in-out">Home</a>
        </li>

        @foreach($filtered as $bc)
            <li class="text-gray-300">/</li>
            <li>
                @if ($loop->last)
                    <span class="text-emerald-600">{{ $bc->label }}</span>
                @else
                    <a href="{{ $bc->url ?? route($bc->route_name, $currentParams) }}" class="text-gray-300 hover:text-emerald-600 transition duration-150 ease-in-out">{{ $bc->label }}</a>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
