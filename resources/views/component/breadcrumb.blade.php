@php
    $segments = request()->segments();

    $url = '';
@endphp

<nav class="flex flex-col md:flex-row md:items-center md:justify-between mb-4" aria-label="Breadcrumb">
    <!-- Title -->
    <div>
        <h1 class="text-xl font-semibold text-white tracking-wide">
            {{ $title }}
        </h1>
    </div>

    <!-- Breadcrumb -->
    <ul class="flex flex-wrap items-center text-sm"
        x-data="{ isMobile: window.innerWidth < 768 }"
        x-init="window.addEventListener('resize', () => isMobile = window.innerWidth < 768)"
    >
        <li>
            <a href="{{ url('/') }}" class="text-gray-300 hover:text-emerald-600 transition duration-150 ease-in-out">Home</a>
        </li>

        @foreach ($segments as $index => $segment)
            @php
                $url .= '/' . $segment;

                // Default label normal
                $fullLabel = ucwords(str_replace(['-', '_'], ' ', $segment));

                // Khusus untuk preparation/slug -> potong agar singkat
                if ($index === 1 && $segments[0] === 'preparation') {
                    $shortLabel = ucwords(Str::of($segment)->before('-via')->__toString());
                } elseif ($index === 0) {
                    $shortLabel = $fullLabel;
                } else {
                    $shortLabel = Str::ucfirst(Str::of($segment)->words(1, ''));
                }
            @endphp

            <li><span class="text-gray-600 px-1">/</span></li>
            <li>
                <span x-show="!isMobile">
                    @if ($loop->last)
                        <span class="text-emerald-500 cursor-default">{{ $title ?? $fullLabel }}</span>
                    @else
                        <a href="{{ url($url) }}" class="text-gray-300 hover:text-emerald-600 transition duration-150 ease-in-out">
                            {{ $fullLabel }}
                        </a>
                    @endif
                </span>
                <span x-show="isMobile">
                    @if ($loop->last)
                        <span class="text-emerald-600 cursor-default">{{ $shortLabel }}</span>
                    @else
                        <a href="{{ url($url) }}" class="text-gray-300 hover:text-emerald-600 transition duration-150 ease-in-out">
                            {{ $shortLabel }}
                        </a>
                    @endif
                </span>
            </li>
        @endforeach
    </ul>
</nav>
