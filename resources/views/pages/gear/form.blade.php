@extends('layouts.main')

@section('content')
    <div class="p-6 border border-gray-700 shadow-xl rounded-lg space-y-2">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">{{ $title }}</h1>
            <a href="{{ route('gear.index') }}" class="text-gray-500 hover:text-emerald-600 transition duration-300 ease-in-out">Back to table</a>
        </div>
        <hr class="text-gray-700" />
        <div>
            <form action="{{ isset($gear) ? route('gear.update', $gear->slug) : route('gear.store') }}" method="POST">
                @csrf
                @if(isset($gear))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <input
                        type="hidden"
                        id="user-id"
                        name="user_id"
                        class="
                            w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                        "
                        required
                        value="{{ Auth::user()->id }}"
                    >

                    <div>
                        <label for="brand" class="block text-gray-300 mb-1">Name of Brand <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            id="brand"
                            name="brand"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                                @error('name') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror
                            "
                            placeholder="Type of brand..."
                            required
                            value="{{ old('brand', $gear->brand ?? '') }}"
                        >
                        @error('brand')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-gray-300 mb-1">Type of Gear <span class="text-red-500">*</span></label>
                        <select
                            id="type"
                            name="type_id"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 bg-gray-800
                                focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                                transition duration-400 ease-in-out
                            "
                        >
                            <option
                                value=""
                                class="text-gray-400 bg-gray-900 hover:bg-emerald-900 transition duration-200 ease-in-out"
                                disabled selected
                            >
                                Default Selected
                            </option>
                            @foreach($types as $type)
                                <option
                                    class="text-gray-300 outline-gray-700 bg-gray-900 hover:bg-emerald-600 transition duration-200 ease-in-out"
                                    value="{{ $type->id }}"
                                    {{ old('type_id', $gear->type_id ?? '') == $type->id ? 'selected' : '' }}
                                >
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('type_id')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-gray-300 mb-1">Category <span class="text-red-500">*</span></label>
                        <select
                            id="category"
                            name="category_id"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 bg-gray-800
                                focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                                transition duration-400 ease-in-out
                            "
                        >
                            <option
                                value=""
                                class="text-gray-400 bg-gray-900 hover:bg-emerald-900 transition duration-200 ease-in-out"
                                disabled selected
                            >
                                Default Selected
                            </option>
                            @foreach($categories as $category)
                                <option
                                    class="text-gray-300 outline-gray-700 bg-gray-900 hover:bg-emerald-600 transition duration-200 ease-in-out"
                                    value="{{ $category->id }}"
                                    {{ old('type_id', $gear->category_id ?? '') == $category->id ? 'selected' : '' }}
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-gray-300 mb-1">Price</label>
                        <input
                            type="number"
                            id="price"
                            name="price"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                                @error('price') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror
                            "
                            placeholder="Rp. "
                            value="{{ old('price', $gear->price ?? '') }}"
                        >
                        @error('price')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="link-product" class="block text-gray-300 mb-1">Link Product</label>
                        <input
                            type="text"
                            id="link-product"
                            name="link_product"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                                @error('longitude') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror
                            "
                            placeholder="https://"
                            value="{{ old('link_product', $gear->link_product ?? '') }}"
                        >
                        @error('link_product')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="statuses" class="block text-gray-300 mb-1">Status</label>
                        <select
                            id="statuses"
                            name="status_id"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 bg-gray-800
                                focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                                transition duration-400 ease-in-out
                            "
                        >
                            @foreach ($statuses as $status)
                                <option
                                    value="{{ $status->id }}"
                                    class="text-gray-300 bg-gray-800 hover:bg-emerald-900 transition duration-200 ease-in-out"
                                    {{ old('status_id', $gear->status_id ?? $statuses->firstWhere('slug', 'in_wishlist')->id) == $status->id ? 'selected' : '' }}
                                >
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_id')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-2">
                    <button type="submit" class="px-2 py-1 text-gray-300 {{ isset($gear) ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-emerald-600 hover:bg-emerald-700' }} focus:outline-none transition duration-300 ease-in-out cursor-pointer rounded-sm">{{ isset($gear) ? 'Update Gear' : 'Create Gear' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
