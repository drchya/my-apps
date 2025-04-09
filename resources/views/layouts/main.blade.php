<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false }" class="h-full bg-gray-900 text-white">
<head>
    <meta charset="UTF-8">
    <title>Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs" defer></script>
    <!-- Font Awesome 5 CDN -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="h-full text-sm text-white">

<div class="flex h-screen overflow-hidden">

    @include('component.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        @include('component.header')

        <!-- Page Content -->
        <main class="p-6 overflow-y-auto bg-gray-900 flex-1">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
