@extends('layouts.main')

@section('content')
    <div
        x-data="{deleted: '{{ session('delete') }}'}"
        x-init="setTimeout(() => deleted = '', 3000);"
    >
        <div
            x-show="deleted"
            x-text="deleted"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            class="my-2 text-center md:text-start font-medium bg-red-500/70 py-2 md:px-4 rounded-lg"
        ></div>
    </div>

    <div class="p-6 border border-gray-700 shadow-xl rounded space-y-2">
        <div class="flex items-center justify-between">
            <h6 class="text-xl">Create New Breadcrumb</h6>
            <a href="{{ route('setting.breadcrumb.index') }}" class="text-red-600 md:text-gray-300 hover:text-red-800 md:hover:text-red-600 transition duration-300 ease-in-out">Back to Breadcrumbs</a>
        </div>

        <hr class="text-gray-700" />

        <form action="{{ route('setting.breadcrumb.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-2 gap-2">
                <div>
                    <label for="label-breadcrumb" class="block text-gray-300 mb-1">
                        Label Breadcrumb<span class="text-red-600">*</span>
                    </label>
                    <input
                        id="label-breadcrumb"
                        name="label"
                        type="text"
                        class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out"
                        required
                        placeholder="e.g. Users, Dashboard, Products"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-2 gap-2">
                <div>
                    <label for="route-name" class="block text-gray-300 mb-1">
                        Route Name<span class="text-red-600">*</span>
                    </label>
                    <input
                        id="route-name"
                        name="route_name"
                        type="text"
                        class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out"
                        required
                        placeholder="e.g. users.index, dashboard"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-2 gap-2">
                <div>
                    <label for="url" class="block text-gray-300 mb-1">
                        URL<span class="text-red-600">*</span>
                    </label>
                    <input
                        id="url"
                        name="url"
                        type="text"
                        class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out"
                        required
                        placeholder="e.g. /users, /dashboard"
                    >
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 my-2 gap-2">
                <div>
                    <label for="order" class="block text-gray-300 mb-1">
                        Order Label<span class="text-red-600">*</span>
                    </label>
                    <input
                        id="order"
                        name="order"
                        type="number"
                        class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out"
                        required
                        placeholder="Enter display order, e.g. 1, 2, 3"
                    >
                </div>
            </div>

            <div class="my-2">
                <button
                    type="submit"
                    class="px-4 py-1 text-xs text-white bg-emerald-600 hover:bg-emerald-700 rounded focus:outline-none transition duration-300 ease-in-out cursor-pointer"
                >
                    Submit
                </button>
            </div>
        </form>
    </div>
@endsection
