@extends('layouts.auth')

@section('content')
    <div class="border border-gray-700 p-6 rounded-lg w-full max-w-sm shadow-lg">
        <h1 class="text-2xl font-semibold mb-6 text-center text-white uppercase">{{ $title }}</h1>

        <form method="POST" action="{{ route('register.process') }}">
            @csrf
            <div class="mb-4">
                <label for="username" class="flex items-center text-sm text-gray-300 mb-1">Username&nbsp;<p class="text-red-500">*</p></label>
                <input
                    type="text"
                    name="username"
                    id="username"
                    class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition duration-300 ease-in-out"
                    required
                    autofocus
                    placeholder="Enter your username"
                    autocomplete="true"
                    value="{{ old('username') }}"
                >
                @error('username')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="flex items-center text-sm text-gray-300 mb-1">Email&nbsp;<p class="text-red-500">*</p></label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition duration-300 ease-in-out"
                    required
                    placeholder="Enter your email"
                    autocomplete="true"
                    value="{{ old('email') }}"
                >
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="flex items-center text-sm text-gray-300 mb-1">Password&nbsp;<p class="text-red-500">*</p></label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition duration-300 ease-in-out"
                    required
                    placeholder="Enter your password"
                >
                @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="flex items-center text-sm text-gray-300 mb-1">Confirm Password&nbsp;<p class="text-red-500">*</p></label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition duration-300 ease-in-out"
                    required
                    placeholder="Repeat your password"
                >
            </div>

            <div class="flex items-center justify-between text-gray-500 mb-2">
                <p class="">Already have account? <a href="{{ route('login') }}" class="text-gray-300 hover:text-emerald-500 transition duration-300 ease-in-out">Login</a></p>
            </div>

            <div class="block w-full">
                <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 rounded text-white font-semibold transition duration-300 ease-in-out cursor-pointer">{{ $title }}</button>
            </div>
        </form>
    </div>
@endsection
