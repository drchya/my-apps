@extends('layouts.auth')

@section('content')
    <div class="bg-gray-800 p-6 rounded-lg w-full max-w-sm shadow-md">
        <h1 class="text-2xl font-semibold mb-6 text-center text-white uppercase">{{ $title }}</h1>

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
                class="bg-emerald-500/70 text-white px-4 py-2 rounded mb-4 text-center relative shadow-md"
            >
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm text-gray-300 mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="w-full px-3 py-2 bg-gray-700 rounded text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition duration-300 ease-in-out"
                    required
                    autofocus
                    placeholder="Enter Your Email"
                    autocomplete="true"
                    value="{{ old('email') }}"
                >
            </div>

            <div class="block w-full">
                <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 rounded text-white font-semibold transition duration-300 ease-in-out cursor-pointer">Send Reset Link</button>
            </div>
        </form>
    </div>
@endsection
