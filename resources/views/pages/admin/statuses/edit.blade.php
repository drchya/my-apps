@extends('layouts.main')

@section('content')
    <div
        x-data="
            {
                message: '{{ session('message') }}'
                deleted: '{{ session('delete') }}'
            }
        "
        x-init="
            setTimeout(() => message = '', 3000);
            setTimeout(() => deleted = '', 3000);
        "
    >
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

    <div class="p-6 border border-gray-700 shadow-xl rounded space-y-2">
        <div class="flex items-center justify-between">
            <h6 class="text-xl">Edit Statuses from {{ $status->name }}</h6>
            <a href="{{ route('setting.status.index') }}" class="text-red-600 md:text-gray-300 hover:text-red-800 md:hover:text-red-600 transition duration-300 ease-in-out">Back to Statuses</a>
        </div>

        <hr class="text-gray-700" />

        <form action="#" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-2">
                <div>
                    <label for="name-category" class="block text-gray-300 mb-1">Name of Category<span class="text-red-600">*</span></label>
                    <input
                        id="name-category"
                        name="name"
                        type="text"
                        class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out"
                        required
                        placeholder="Name of type"
                        value="{{ old('name', $status->name) }}"
                    >
                </div>
            </div>

            <div class="my-2">
                <button
                    type="submit"
                    class="px-2 py-1 text-gray-300 bg-yellow-600 hover:bg-yellow-700 focus:outline-none transition duration-300 ease-in-out cursor-pointer rounded-sm"
                >Edit</button>
            </div>
        </form>
    </div>
@endsection
