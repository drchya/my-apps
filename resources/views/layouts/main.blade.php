<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false }" class="h-full bg-gray-900 text-white">
<head>
    <meta charset="UTF-8">
    <title>Laravel - {{ $title ?? 'Not Found'}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome 5 CDN -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    @livewireStyles
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="h-full text-xs md:text-sm text-white" x-data="{ sidebarOpen: false, sidebarCollapsed: false }">
    <div class="flex">
        <div class="flex min-h-screen overflow-hidden">
            @include('component.sidebar')
        </div>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            @include('component.header')

            <!-- Page Content -->
            <main class="m-6 overflow-y-auto bg-gray-900 flex-1">
                @include('component.breadcrumb')

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    @livewireScripts
</body>
</html>
