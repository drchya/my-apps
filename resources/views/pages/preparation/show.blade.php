@extends('layouts.main')

@section('content')
    <div class="px-2">
        <div
            x-data="{
                        message: '{{ session('message') }}',
                        error: '{{ session('error') }}'
                    }
            "
            x-init="
                setTimeout(() => message = '', 3000);
                setTimeout(() => deleted = '', 3000);
                setTimeout(() => error = '', 3000);
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
            <div
                x-show="error"
                x-text="error"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
                class="my-2 text-gray-300 text-center md:text-start font-medium bg-red-500/70 py-2 md:px-2 rounded-lg"
            ></div>
        </div>
    </div>

    <div class="px-2">
        <h1 class="text-gray-50 text-xl md:text-2xl uppercase font-bold">Mt. {{ $preparation->mountain->name }}</h1>
        <p>{{ number_format($preparation->mountain->elevation, 0, ',', '.') }} Mdpl</p>
        <p>{{ $preparation->mountain->location }}</p>
        @php
            use Carbon\Carbon;

            $departure = Carbon::parse($preparation->departure_date)->translatedFormat('l, d F Y');
            $return = Carbon::parse($preparation->return_date)->translatedFormat('l, d F Y');
        @endphp
        <p>{{ $departure }} - {{ $return }}</p>
        <p>{{ $preparation->total_days }} Days</p>
        <p>Total Budget: Rp{{ number_format($preparation->budget_estimate, 0, ',', '.') }}</p>
        <div class="flex items-center gap-2">
            <a href="{{ route('preparation.index') }}" class="text-gray-500 hover:text-emerald-600 transition duration-300 ease-in-out">Back to Table</a>
        </div>
    </div>

    <hr class="text-gray-800 my-4">

    <div class="overflow-x-auto px-2">
        <div class="flex items-center justify-between mb-2">
            @if (!$preparation_items->isEmpty())
                <span
                    onclick="document.getElementById('addGearModal').classList.remove('hidden')"
                    class="
                        px-2 py-1 bg-emerald-600 rounded border border-transparent text-gray-300 font-medium
                        focus:outline-none focus:ring focus:ring-emerald-600
                        hover:bg-emerald-800 hover:border-emerald-800
                        transition duration-300 ease-in-out
                        cursor-pointer
                    "
                >
                    Add Gear
                </span>
            @endif

            <!-- Modal -->
            <div id="addGearModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
                <div class="bg-gray-900 p-6 rounded-xl w-full max-w-lg mx-16 shadow-xl">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-white">Add Gear</h2>
                        <button
                            type="button"
                            onclick="document.getElementById('addGearModal').classList.add('hidden')"
                            class="
                                text-gray-400 text-lg font-bold
                                hover:text-white
                                transition duration-200 ease-in-out
                                cursor-pointer
                            "
                        >
                            ✕
                        </button>
                    </div>

                    <hr class="mt-2 mb-3 text-gray-700">

                    <form action="{{ route('preparation.items.update', $preparation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="preparation_id" value="{{ $preparation->id }}">

                        <div class="grid grid-cols-2 md:grid-cols-3 space-y-2">
                            @foreach($preparation_items->where('is_selected', 0) as $item_unselect)
                                <div class="flex items-center">
                                    <label class="inline-flex items-center space-x-2">
                                        <input type="hidden" name="gear[{{ $item_unselect->id }}][type_id]" value="{{ $item_unselect->type_id }}">
                                        <input type="hidden" name="gear[{{ $item_unselect->id }}][selected]" value="0">
                                        <input type="checkbox" class="hidden peer" name="gear[{{ $item_unselect->id }}][selected]" value="1">
                                        <span
                                            class="
                                                w-4 h-4 border border-gray-600 rounded-sm flex items-center justify-center
                                                peer-checked:bg-emerald-600 peer-checked:border-emerald-600
                                                transition duration-200 ease-in-out
                                                cursor-pointer
                                            "
                                        >
                                            <svg class="hidden w-3 h-3 text-white peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>

                                        <span>{{ $item_unselect->type->name }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <hr class="mt-2 mb-3 text-gray-700">

                        <div>
                            <button
                                type="submit"
                                class="
                                    px-2 py-1 bg-yellow-600 text-gray-300 rounded
                                    hover:bg-yellow-800
                                    transition duration-300 ease-in-out
                                    cursor-pointer
                                "
                            >
                                Add Gear
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <input
                    type="text"
                    id="customSearch"
                    placeholder="Search Gear..."
                    class="border border-gray-600 text-gray-300 rounded px-2 py-1 focus:border-emerald-600 focus:outline-none transition duration-300 ease-in-out"
                    autocomplete="on"
                >
            </div>
        </div>

        @php
            $isUpdate = !$preparation_items->isEmpty();
            $formRoute = $isUpdate ? route('preparation.items.update', $preparation->id) : route('preparation.items.store');
            $formMethod = $isUpdate ? 'PUT' : 'POST';
        @endphp

        <div>
            <form action="{{ $formRoute }}" method="POST">
                @csrf
                @if ($isUpdate)
                    @method('PUT')
                @endif
                <input type="hidden" name="preparation_id" value="{{ $preparation->id }}">
                @php $index = 0; @endphp
                <table id="preparation-item" class="border border-gray-800 shadow-lg rounded overflow-auto mb-4 w-full text-sm">
                    <thead class="bg-gray-800 text-gray-300">
                        <tr>
                            <th>#</th>
                            @if (!$preparation_items->isEmpty())
                                <th>Checked</th>
                            @endif
                            <th>Gear</th>
                            <th>Quantity</th>
                            <th class="hidden lg:table-cell">Status Gear</th>
                            <th class="hidden lg:table-cell">Urgency</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$preparation_items->isEmpty())
                            @foreach($preparation_items->where('is_selected', 1) as $item)
                                @php $index++ @endphp
                                <tr class="text-gray-300">
                                    <td>
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" class="hidden peer" name="gear[{{ $item->id }}][selected]" value="1">
                                            <span
                                                class="
                                                    w-4 h-4 border border-gray-600 rounded-sm flex items-center justify-center
                                                    peer-checked:bg-emerald-600 peer-checked:border-emerald-600
                                                    transition duration-200 ease-in-out
                                                "
                                            >
                                                <svg class="hidden w-3 h-3 text-white peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                        </label>
                                    </td>

                                    <td>
                                        <label class="inline-flex items-center space-x-2" title="Tandai sebagai sudah disiapkan">
                                            <input type="hidden" name="gear[{{ $item->id }}][checked]" value="0">

                                            <input
                                                type="checkbox"
                                                class="hidden peer"
                                                name="gear[{{ $item->id }}][checked]"
                                                value="1"
                                                {{ $item->is_checked ? 'checked' : '' }}
                                            >
                                            <span
                                                class="
                                                    w-4 h-4 border border-gray-600 rounded-sm flex items-center justify-center
                                                    peer-checked:bg-blue-600 peer-checked:border-blue-600
                                                    transition duration-200 ease-in-out
                                                "
                                            >
                                                <svg class="hidden w-3 h-3 text-white peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                        </label>
                                    </td>

                                    <td>
                                        <input type="hidden" name="gear[{{ $item->id }}][type_id]" value="{{ $item->id }}">
                                        {{ $item->type->name }}
                                    </td>
                                    <td>
                                        <input
                                            type="number"
                                            name="gear[{{ $item->id }}][quantity]"
                                            value="{{ $item->quantity }}"
                                            min="1"
                                            class="
                                                border border-gray-700 rounded px-2 py-1 text-gray-300
                                                w-18 md:w-full
                                                focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                transition duration-300 ease-in-out
                                            "
                                        >
                                    </td>

                                    <td class="hidden lg:table-cell">
                                        <select
                                            id="status_gear_desktop_{{ $item->id }}"
                                            name="gear[{{ $item->id }}][status_gear]"
                                            class="
                                                border border-gray-700 rounded px-2 py-1 text-gray-300
                                                focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                transition duration-300 ease-in-out
                                            "
                                            onchange="syncStatusGear('{{ $item->id }}', 'desktop')"
                                        >
                                            <option value="not_available" {{ $item->status_gear == 'not_available' ? 'selected' : '' }}>
                                                Not Available
                                                {{ $item->status_gear == 'not_available' ? '(Default)' : '' }}
                                            </option>
                                            <option value="owned" {{ $item->status_gear == 'owned' ? 'selected' : '' }}>
                                                Owned
                                                {{ $item->status_gear == 'owned' ? '(Default)' : '' }}
                                            </option>
                                            <option value="rented" {{ $item->status_gear == 'rented' ? 'selected' : '' }}>
                                                Rented
                                                {{ $item->status_gear == 'rented' ? '(Default)' : '' }}
                                            </option>
                                        </select>
                                    </td>

                                    <td class="hidden lg:table-cell">
                                        <select
                                            id="urgency_gear_desktop_{{ $item->id }}"
                                            name="gear[{{ $item->id }}][urgency]"
                                            class="
                                                border border-gray-700 rounded px-2 py-1 text-gray-300
                                                focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                hidden lg:block
                                                transition duration-300 ease-in-out
                                            "
                                            onchange="syncUrgencyGear('{{ $item->id }}', 'desktop')"
                                        >
                                            <option value="not_urgent" {{ $item->urgency == 'not_urgent' ? 'selected' : '' }}>
                                                Not Urgent
                                                {{ $item->urgency == 'not_urgent' ? '(Default)' : '' }}
                                            </option>
                                            <option value="urgent" {{ $item->urgency == 'urgent' ? 'selected' : '' }}>
                                                Urgent
                                                {{ $item->urgency == 'urgent' ? '(Default)' : '' }}
                                            </option>
                                            <option value="important" {{ $item->urgency == 'important' ? 'selected' : '' }}>
                                                Important
                                                {{ $item->urgency == 'important' ? '(Default)' : '' }}
                                            </option>
                                        </select>
                                    </td>

                                    <td class="text-center">
                                        <button
                                            type="button"
                                            onclick="document.getElementById('modal-{{ $index }}').classList.remove('hidden')"
                                            class="
                                                h-6 w-6 border border-blue-600 text-blue-600 text-xs
                                                cursor-pointer rounded
                                                md:border-gray-700 md:text-gray-700 md:hover:border-blue-600 md:hover:bg-blue-600 md:hover:text-gray-300
                                                focus:outline-none focus:ring focus:ring-blue-600
                                                transition duration-300 ease-in-out
                                            "
                                        >
                                            <i class="fa-solid fa-info"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- MODAL --}}
                                <div id="modal-{{ $index }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
                                    <div class="bg-gray-900 text-gray-300 p-6 rounded-xl w-11/12 max-w-md space-y-4 relative">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-semibold">{{ $item->type->name }} Details</h3>
                                            <button type="button" class="text-red-500 cursor-pointer" onclick="document.getElementById('modal-{{ $index }}').classList.add('hidden')">✕</button>
                                        </div>

                                        <div>
                                            <label class="block mb-1">Category Gear <span class="text-red-500">*</span></label>
                                            @php
                                                $categories = ['tracking', 'sleeping', 'summit_attack', 'in_transit', 'backup'];
                                                $selected_categories = json_decode($item->category_gear);
                                            @endphp

                                            <div class="grid grid-cols-2 gap-2">
                                                @foreach ($categories as $cat)
                                                    <label class="inline-flex items-center space-x-2 text-sm text-gray-300 capitalize">
                                                        <input
                                                            type="checkbox"
                                                            class="hidden peer"
                                                            name="gear[{{ $item->id }}][category_gear][]"
                                                            value="{{ $cat }}"
                                                            {{ in_array($cat, $selected_categories) ? 'checked' : '' }}
                                                        >
                                                        <span
                                                            class="w-4 h-4 border border-gray-600 rounded-sm flex items-center mr-2 justify-center
                                                            peer-checked:bg-emerald-600 peer-checked:border-emerald-600
                                                            transition duration-200 ease-in-out"
                                                        >
                                                            <svg class="hidden w-3 h-3 text-white peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </span>
                                                        {{ str_replace('_', ' ', $cat) }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="md:hidden">
                                            <label class="block mb-1">Status Gear <span class="text-red-500">*</span></label>
                                            <select
                                                id="status_gear_mobile_{{ $item->id }}"
                                                name="gear[{{ $item->id }}][status_gear]"
                                                class="
                                                    border border-gray-700 rounded px-2 py-1 text-gray-300
                                                    w-full
                                                    focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                    transition duration-300 ease-in-out
                                                "
                                                onchange="syncStatusGear('{{ $item->id }}', 'mobile')"
                                            >
                                                <option value="not_available" {{ $item->status_gear == 'not_available' ? 'selected' : '' }}>
                                                    Not Available
                                                    {{ $item->status_gear == 'not_available' ? '(Default)' : '' }}
                                                </option>
                                                <option value="owned" {{ $item->status_gear == 'owned' ? 'selected' : '' }}>
                                                    Owned
                                                    {{ $item->status_gear == 'owned' ? '(Default)' : '' }}
                                                </option>
                                                <option value="rented" {{ $item->status_gear == 'rented' ? 'selected' : '' }}>
                                                    Rented
                                                    {{ $item->status_gear == 'rented' ? '(Default)' : '' }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="md:hidden">
                                            <label class="block mb-1">Urgency <span class="text-red-500">*</span></label>
                                            <select
                                                id="urgency_gear_mobile_{{ $item->id }}"
                                                name="gear[{{ $item->id }}][urgency]"
                                                class="
                                                    border border-gray-700 rounded px-2 py-1 text-gray-300
                                                    w-full
                                                    focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                    transition duration-300 ease-in-out
                                                "
                                                onchange="syncUrgencyGear('{{ $item->id }}', 'mobile')"
                                            >
                                                <option value="not_urgent" {{ $item->urgency == 'not_urgent' ? 'selected' : '' }}>
                                                    Not Urgent
                                                    {{ $item->urgency == 'not_urgent' ? '(Default)' : '' }}
                                                </option>
                                                <option value="urgent" {{ $item->urgency == 'urgent' ? 'selected' : '' }}>
                                                    Urgent
                                                    {{ $item->urgency == 'urgent' ? '(Default)' : '' }}
                                                </option>
                                                <option value="important" {{ $item->urgency == 'important' ? 'selected' : '' }}>
                                                    Important
                                                    {{ $item->urgency == 'important' ? '(Default)' : '' }}
                                                </option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="price" class="block mb-1">Price</label>
                                            <input
                                                id="price"
                                                name="gear[{{ $item->id }}][price]"
                                                value="{{ $item->price }}"
                                                class="
                                                    border border-gray-700 rounded px-2 py-1 text-gray-300
                                                    w-full
                                                    focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                    transition duration-300 ease-in-out
                                                "
                                            >
                                        </div>

                                        <div>
                                            <label class="block mb-1">Group Item?</label>
                                            <label class="inline-flex items-center space-x-2">
                                                <input type="hidden" name="gear[{{ $item->id }}][is_group]" value="0">
                                                <input type="checkbox" class="hidden peer" name="gear[{{ $item->id }}][is_group]"
                                                    @if($item->is_group == 1) checked @endif>
                                                <span
                                                    class="w-4 h-4 border border-gray-600 rounded-sm flex items-center justify-center
                                                    peer-checked:bg-emerald-600 peer-checked:border-emerald-600
                                                    transition duration-200 ease-in-out"
                                                >
                                                    <svg class="hidden w-3 h-3 text-white peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </span>
                                            </label>
                                        </div>

                                        <div>
                                            <p class="text-xs text-red-700 font-medium">Please checklist if you want to remove!</p>
                                            <label class="block mb-1">Do you want to remove this items?</label>
                                            <label class="inline-flex items-center space-x-2">
                                                <input type="checkbox" class="hidden peer" name="gear[{{ $item->id }}][remove]" value="1">
                                                <span
                                                    class="w-4 h-4 border border-gray-600 rounded-sm flex items-center justify-center
                                                    peer-checked:bg-emerald-600 peer-checked:border-emerald-600
                                                    transition duration-200 ease-in-out"
                                                >
                                                    <svg class="hidden w-3 h-3 text-white peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach ($types as $type)
                                @php $index++ @endphp
                                <tr class="text-gray-300">
                                    <td>
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="hidden" name="gear[{{ $type->id }}][selected]" value="0">
                                            <input type="checkbox" class="hidden peer" name="gear[{{ $type->id }}][selected]" value="1">
                                            <span
                                                class="
                                                    w-4 h-4 border border-gray-600 rounded-sm flex items-center justify-center
                                                    peer-checked:bg-emerald-600 peer-checked:border-emerald-600
                                                    transition duration-200 ease-in-out
                                                "
                                            >
                                                <svg class="hidden w-3 h-3 text-white peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </span>
                                        </label>
                                    </td>
                                    <td>
                                        <input type="hidden" name="gear[{{ $type->id }}][type_id]" value="{{ $type->id }}">
                                        {{ $type->name }}
                                    </td>
                                    <td>
                                        <input
                                            type="number"
                                            name="gear[{{ $type->id }}][quantity]"
                                            value="1"
                                            min="1"
                                            class="
                                                border border-gray-700 rounded px-2 py-1 text-gray-300
                                                w-18 md:w-full
                                                focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                transition duration-300 ease-in-out
                                            "
                                        >
                                    </td>

                                    <td class="hidden lg:table-cell">
                                        <select
                                            name="gear[{{ $type->id }}][status_gear]"
                                            class="
                                                border border-gray-700 rounded px-2 py-1 text-gray-300
                                                focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                transition duration-300 ease-in-out
                                            "
                                        >
                                            <option>Not Available</option>
                                            <option>Owned</option>
                                            <option>Rented</option>
                                        </select>
                                    </td>
                                    <td class="hidden lg:table-cell">
                                        <select
                                            name="gear[{{ $type->id }}][urgency]"
                                            class="
                                                border border-gray-700 rounded px-2 py-1 text-gray-300
                                                focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                transition duration-300 ease-in-out
                                            "
                                        >
                                            <option>Not Urgent</option>
                                            <option>Urgent</option>
                                            <option>Important</option>
                                        </select>
                                    </td>

                                    {{-- Modal trigger on mobile --}}
                                    <td class="text-center">
                                        <button type="button" onclick="document.getElementById('modal-{{ $index }}').classList.remove('hidden')" class="text-emerald-500 underline">Detail</button>
                                    </td>
                                </tr>

                                {{-- MODAL --}}
                                <div id="modal-{{ $index }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
                                    <div class="bg-gray-900 text-gray-300 p-6 rounded-xl w-11/12 max-w-md space-y-4 relative">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-semibold">{{ $type->name }} Details</h3>
                                            <button type="button" class="text-red-500 cursor-pointer" onclick="document.getElementById('modal-{{ $index }}').classList.add('hidden')">✕</button>
                                        </div>

                                        <div>
                                            <label class="block mb-1">Category Gear <span class="text-red-500">*</span></label>
                                            @php
                                                $categories = ['tracking', 'sleeping', 'summit_attack', 'in_transit', 'backup'];
                                            @endphp

                                            <div class="grid grid-cols-2 gap-2">
                                                @foreach ($categories as $cat)
                                                    <label class="inline-flex items-center space-x-2 text-sm text-gray-300 capitalize">
                                                        <input
                                                            type="checkbox"
                                                            class="hidden peer"
                                                            name="gear[{{ $type->id }}][category_gear][]"
                                                            value="{{ $cat }}"
                                                        >
                                                        <span
                                                            class="
                                                                w-4 h-4 border border-gray-600 rounded-sm flex items-center mr-2 justify-center
                                                                peer-checked:bg-emerald-600 peer-checked:border-emerald-600
                                                                transition duration-200 ease-in-out
                                                            "
                                                        >
                                                            <svg class="hidden w-3 h-3 text-white peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </span>
                                                        {{ str_replace('_', ' ', $cat) }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="lg:hidden">
                                            <label class="block mb-1">Status Gear <span class="text-red-500">*</span></label>
                                            <select
                                                name="gear[{{ $type->id }}][status_gear]"
                                                class="
                                                    border border-gray-700 rounded px-2 py-1 text-gray-300
                                                    focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                    lg:hidden
                                                    transition duration-300 ease-in-out
                                                "
                                            >
                                                <option>Not Available</option>
                                                <option>Owned</option>
                                                <option>Rented</option>
                                            </select>
                                        </div>
                                        <div class="md:hidden">
                                            <label class="block mb-1">Urgency <span class="text-red-500">*</span></label>
                                            <select
                                                name="gear[{{ $type->id }}][urgency]"
                                                class="
                                                    border border-gray-700 rounded px-2 py-1 text-gray-300
                                                    focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                    transition duration-300 ease-in-out
                                                "
                                            >
                                                <option>Not Urgent</option>
                                                <option>Urgent</option>
                                                <option>Important</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="price" class="block mb-1">Price</label>
                                            <input
                                                id="price"
                                                name="gear[{{ $type->id }}][price]"
                                                value="0"
                                                class="
                                                    border border-gray-700 rounded px-2 py-1 text-gray-300
                                                    w-18 md:w-full
                                                    focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                    transition duration-300 ease-in-out
                                                "
                                            >
                                        </div>
                                        <div>
                                            <label class="block mb-1">Group Item?</label>
                                            <label class="inline-flex items-center space-x-2">
                                                <input type="checkbox" class="hidden peer" name="gear[{{ $type->id }}][is_group]">
                                                <span
                                                    class="
                                                        w-4 h-4 border border-gray-600 rounded-sm flex items-center justify-center
                                                        peer-checked:bg-emerald-600 peer-checked:border-emerald-600
                                                        transition duration-200 ease-in-out
                                                    "
                                                >
                                                    <svg class="hidden w-3 h-3 text-white peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="w-full py-1">
                            <td colspan="6">
                                <button
                                    type="submit"
                                    class="
                                        mb-1 px-2 py-1 text-xs font-medium border rounded text-gray-300
                                        {{ $isUpdate ? 'border-yellow-600 bg-yellow-600 hover:bg-yellow-800 hover:border-yellow-800 hover:ring hover:ring-yellow-800' : 'border-emerald-600 bg-emerald-600 hover:bg-emerald-800 hover:border-emerald-800 hover:ring hover:ring-emerald-800' }}
                                        transition duration-300 ease-in-out
                                        cursor-pointer
                                    "
                                >
                                    {{ $isUpdate ? 'Update Gear List' : 'Add Gear to Preparation' }}
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- DataTables & jQuery --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        let preparationsTables;

        document.addEventListener("DOMContentLoaded", function () {
            preparationsTables = $('#preparation-item').DataTable({
                paging: false,
                order: [],
                columnDefs: [
                    { orderable: false, targets: 0 } // kolom nomor urut (#) tidak bisa di-sort
                ],
            });

            $('#customSearch').on('keyup', function () {
                preparationsTables.search(this.value).draw();
            });
        });

        // Fungsi untuk menyinkronkan nilai antara form mobile dan desktop
        function syncStatusGear(itemId, formType) {
            const mobileSelect = document.getElementById(`status_gear_mobile_${itemId}`);
            const desktopSelect = document.getElementById(`status_gear_desktop_${itemId}`);

            // Jika yang berubah adalah form mobile, perbarui form desktop
            if (formType === 'mobile') {
                desktopSelect.value = mobileSelect.value;
            }
            // Jika yang berubah adalah form desktop, perbarui form mobile
            else if (formType === 'desktop') {
                mobileSelect.value = desktopSelect.value;
            }
        }

        function syncUrgencyGear(itemId, formType) {
            const mobileSelect = document.getElementById(`urgency_gear_mobile_${itemId}`);
            const desktopSelect = document.getElementById(`urgency_gear_desktop_${itemId}`);

            // Jika yang berubah adalah form mobile, perbarui form desktop
            if (formType === 'mobile') {
                desktopSelect.value = mobileSelect.value;
            }
            // Jika yang berubah adalah form desktop, perbarui form mobile
            else if (formType === 'desktop') {
                mobileSelect.value = desktopSelect.value;
            }
        }
    </script>
@endpush
