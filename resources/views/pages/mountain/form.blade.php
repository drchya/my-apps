@extends('layouts.main')

@section('content')
    <div class="p-6 border border-gray-700 shadow-xl rounded-lg space-y-2">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">{{ $title }}</h1>
            <a href="{{ route('mountain.index') }}" class="text-gray-500 hover:text-emerald-600 transition duration-300 ease-in-out">Back to table</a>
        </div>
        <hr class="text-gray-700" />
        <div>
            <form action="{{ isset($mountain) ? route('mountain.update', $mountain->slug) : route('mountain.store') }}" method="POST">
                @csrf
                @if(isset($mountain))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label for="mountain" class="block text-gray-300 mb-1">Name of Mountain</label>
                        <input
                            type="text"
                            id="mountain"
                            name="name"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                                @error('name') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror
                            "
                            placeholder="Type of Mountain..."
                            required
                            value="{{ old('name', $mountain->name ?? '') }}"
                        >
                        @error('name')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-300 mb-1">Location</label>
                        <input
                            type="text"
                            id="location"
                            name="location"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                                @error('location') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror
                            "
                            placeholder="City, Province, Country."
                            value="{{ old('location', $mountain->location ?? '') }}"
                        >
                        @error('location')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-300 mb-1">Latitude</label>
                        <input
                            type="text"
                            id="latitude"
                            name="latitude"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                                @error('latitude') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror
                            "
                            placeholder="0.0"
                            value="{{ old('latitude', $mountain->latitude ?? '') }}"
                        >
                        @error('latitude')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-300 mb-1">Longitude</label>
                        <input
                            type="text"
                            id="longitude"
                            name="longitude"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                                @error('longitude') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror
                            "
                            placeholder="0.0"
                            value="{{ old('longitude', $mountain->longitude ?? '') }}"
                        >
                        @error('longitude')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-300 mb-1">Height (Mdpl)</label>
                        <input
                            type="number"
                            id="elevation"
                            name="elevation"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                                @error('elevation') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror
                            "
                            placeholder="0"
                            value="{{ old('elevation', $mountain->elevation ?? '') }}"
                        >
                        @error('elevation')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-2">
                    <button type="submit" class="px-2 py-1 text-gray-300 bg-emerald-600 hover:bg-emerald-700 focus:outline-none transition duration-300 ease-in-out cursor-pointer rounded-sm">Send</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            var location = document.getElementById('location').value;
            var regex = /^[a-zA-Z\s]+,\s[a-zA-Z\s]+,\s[a-zA-Z\s]+$/;  // Format: City, Province, Country
            var errorMessage = document.getElementById('location-error');

            // Reset error message
            errorMessage.classList.add('hidden');

            // Check if the location matches the format "City, Province, Country"
            if (!regex.test(location)) {
                e.preventDefault();  // Prevent form submission
                errorMessage.classList.remove('hidden');  // Show error message
            }
        });
    </script>
@endpush
