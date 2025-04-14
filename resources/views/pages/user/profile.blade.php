@extends('layouts.main')

@section('content')
<div class="mx-auto mt-4 px-4">
    <div x-data="{ message: '{{ session('message') }}' }" x-init="setTimeout(() => message = '', 3000)">
        <div
            x-show="message"
            x-text="message"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            class="my-2 text-gray-300 text-center md:text-start font-medium bg-emerald-500/70 py-2 md:px-2 rounded-lg"
        ></div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow p-6">
        <div class="flex flex-col md:flex-row items-center text-center md:text-start gap-4 mb-6">
            <div class="bg-emerald-600 text-white rounded-full w-12 h-12 flex items-center justify-center text-xl font-bold uppercase">
                {{ strtoupper(substr($user->email, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-50">{{ $user->email }}</h2>
                <p class="text-sm text-gray-500">{{ $user->username ?? "You Don't Have Username" }}</p>
            </div>
        </div>

        <hr class="my-4 text-gray-800">

        <form action="{{ route('users.update', $user->slug) }}" method="POST">
            @csrf
            @method('PATCH')

            @if($user->username === null)
                <div class="mb-2">
                    <label class="block font-medium text-gray-700 mb-1">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="
                            w-full px-3 py-2 rounded-lg bg-transparent text-white border border-gray-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition duration-300 ease-in-out
                        "
                        placeholder="Enter Your Username"
                        autocomplete="true"
                    >
                </div>
            @else

            @endif

            <div class="mb-2">
                <label for="password" class="block font-medium text-gray-700 mb-1">New Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="
                        w-full px-3 py-2 rounded-lg bg-transparent text-white border border-gray-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition duration-300 ease-in-out
                        @error('password') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror
                    "
                    placeholder="Enter New Password"
                >
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block font-medium text-gray-700 mb-1">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    placeholder="Confirm new password"
                    class="
                        w-full px-3 py-2 rounded-lg bg-transparent text-white border border-gray-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 transition duration-300 ease-in-out
                    "
                >
            </div>

            <div class="flex justify-start">
                <button
                    type="submit"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-3 py-2 rounded-lg shadow transition duration-300 ease-in-out cursor-pointer"
                >
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
