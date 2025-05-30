@extends('layouts.main')

@section('content')
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

    <h1 class="text-gray-50 text-xl md:text-2xl uppercase font-extrabold">Mt. {{ $preparation->mountain->name }}</h1>

    <p class="flex items-center gap-2 text-gray-400 font-medium mb-1">
        <span class="flex w-4 items-center justify-center">
            <i class="fa-solid fa-mountain text-yellow-900"></i>
        </span>
        {{ number_format($preparation->mountain->elevation, 0, ',', '.') }} Mdpl
    </p>

    <p class="flex items-center gap-2 text-gray-400 font-medium mb-1">
        <span class="flex w-4 items-center justify-center">
            <i class="fa-solid fa-map-pin text-red-600"></i>
        </span>
        {{ $preparation->mountain->location }}
    </p>
    @php
        use Carbon\Carbon;

        $departure = Carbon::parse($preparation->departure_date)->translatedFormat('d F');
        $return = Carbon::parse($preparation->return_date)->translatedFormat('d F Y');
    @endphp
    <p class="flex items-center gap-2 text-gray-400 font-medium mb-1">
        <span class="flex w-4 items-center justify-center">
            <i class="fa-regular fa-calendar text-red-400"></i>
        </span>
        {{ $departure }} - {{ $return }} ({{ $preparation->total_days }} Days)
    </p>

    <p class="flex items-center gap-2 text-gray-400 font-medium">
        <span class="flex w-4 items-center justify-center">
            <i class="fa-solid fa-dollar-sign text-green-600"></i>
        </span>
        Total Budget: Rp{{ number_format($preparation->budget_estimate, 0, ',', '.') }}
    </p>

    <div class="flex items-center my-2 gap-2">
        <a href="{{ route('preparation.show', $preparation->slug) }}" class="flex items-center gap-1 text-yellow-600 font-medium hover:text-yellow-800 transition duration-300 ease-in-out">
            <span class="flex w-4 items-center justify-center">
                <i class="fa-solid fa-person-hiking"></i>
            </span>
            Equipment
        </a>
        <a href="{{ route('preparation.transportation.index', $preparation->slug) }}" class="flex items-center gap-1 text-blue-600 font-medium hover:text-blue-800 transition duration-300 ease-in-out">
            <span class="flex w-4 items-center justify-center">
                <i class="fa-solid fa-car-side"></i>
            </span>
            Transportation
        </a>
    </div>

    <hr class="text-gray-800 my-4" />

    <form action="{{ route('preparation.logistics.store', $preparation->slug) }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <div>
                <label for="name-logistics" class="block text-gray-300 mb-1">Name Logistic <span class="text-red-500">*</span></label>
                <input
                    type="text"
                    id="name-logistics"
                    name="name"
                    class="
                        w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                        focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                        transition duration-300 ease-in-out
                    "
                    placeholder="Your logistic..."
                    autocomplete="off"
                    required
                >
            </div>

            @if ($logistics->isEmpty())
                <div>
                    <label for="description" class="block text-gray-300 mb-1">Description</label>
                    <textarea
                        type="text"
                        id="description"
                        name="description"
                        class="
                            w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                            focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                            transition duration-300 ease-in-out
                        "
                        rows="1"
                        placeholder="Description logistic..."
                        autocomplete="off"
                    ></textarea>
                </div>
            @endif

            <div>
                <label for="quantity" class="block text-gray-300 mb-1">Quantity <span class="text-red-500">*</span></label>
                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    class="
                        w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                        focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                        transition duration-300 ease-in-out
                    "
                    value="0"
                    min="0"
                    required
                >
            </div>

            @php
                $units = ['pcs', 'pack', 'box', 'liter', 'ml', 'gram', 'kg'];
            @endphp

            <div>
                <label for="unit" class="block text-gray-300 mb-1">Unit <span class="text-red-500">*</span></label>
                <select
                    id="unit"
                    name="unit"
                    class="
                        w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                        focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                        transition duration-300 ease-in-out
                    "
                    required
                >
                    @foreach($units as $unit)
                        <option value="{{ $unit }}">{{ ucfirst($unit) }}</option>
                    @endforeach
                </select>
            </div>

            @if ($logistics->isEmpty())
                <div>
                    <label for="price" class="block text-gray-300 mb-1">Price <span class="text-red-500">*</span></label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        class="
                            w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                            focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                            transition duration-300 ease-in-out
                        "
                        value="0"
                        min="0"
                        required
                    >
                </div>
            @endif()
        </div>

        <button
            type="submit"
            class="
                mt-2 px-2 py-1 rounded bg-emerald-600 text-gray-300
                focus:outline-none focus:ring focus:ring-emerald-600
                hover:bg-emerald-800
                transition duration-300 ease-in-out
                cursor-pointer
            "
        >
            Sending
        </button>
    </form>

    <hr class="text-gray-800 my-4" />

    <div>
        <div class="mb-2">
            <div>
                <input
                    type="text"
                    id="customSearch"
                    placeholder="Search Logistics..."
                    class="border border-gray-600 text-gray-300 rounded px-2 py-1 focus:border-emerald-600 focus:outline-none transition duration-300 ease-in-out"
                    autocomplete="on"
                >
            </div>
        </div>

        <div>
            <form action="{{ route('preparation.logistics.update', ['preparation' => $preparation->slug, 'logistic' => $preparation->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <table id="logistic-table" class="border border-gray-800 shadow-lg rounded overflow-auto mb-4 w-full">
                    <thead class="bg-gray-800 text-gray-300">
                        <tr>
                            <th>#</th>
                            <th>
                                <span class="hidden md:block">
                                    Checked
                                </span>
                                <div class="md:hidden">
                                    <i class="fa-regular fa-square-check"></i>
                                </div>
                            </th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price / Unit</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-300">
                        @php $index = 0; @endphp
                        @foreach($logistics as $logistic)
                            @php $index++ @endphp
                            <tr>
                                <td>
                                    <label class="inline-flex items-center space-x-2">
                                        <input type="checkbox" class="hidden peer" name="logistic[{{ $logistic->id }}][selected]" value="1">
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
                                    </label>
                                </td>
                                <td>
                                    <label class="inline-flex items-center space-x-2" title="Tandai sebagai sudah disiapkan">
                                        <input type="hidden" name="logistic[{{ $logistic->id }}][checked]" value="0">

                                        <input
                                            type="checkbox"
                                            class="hidden peer"
                                            name="logistic[{{ $logistic->id }}][checked]"
                                            value="1"
                                            {{ $logistic->checked ? 'checked' : '' }}
                                        >
                                        <span
                                            class="
                                                w-4 h-4 border border-gray-600 rounded-sm flex items-center justify-center
                                                peer-checked:bg-blue-600 peer-checked:border-blue-600
                                                transition duration-200 ease-in-out
                                                cursor-pointer
                                            "
                                        >
                                            <svg class="hidden w-3 h-3 text-white peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    </label>
                                </td>
                                <td>{{ $logistic->name }}</td>
                                <td>{{ $logistic->quantity }}</td>
                                <td>
                                    Rp
                                    <span class="text-gray-400 uppercase font-medium">
                                        {{ number_format($logistic->price, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <span
                                        onclick="document.getElementById('modal-{{ $index }}').classList.remove('hidden')"
                                        class="
                                            flex items-center justify-center w-8 h-8 border border-gray-800 rounded-md
                                            focus:outline-none
                                            bg-blue-600 md:bg-transparent md:hover:border-blue-600 md:hover:text-blue-600
                                            transition duration-300 ease-in-out
                                            cursor-pointer
                                        "
                                    >
                                        <i class="fa-solid fa-info"></i>
                                    </span>
                                </td>
                            </tr>

                            {{-- SHOW MODAL FOR DETAIL --}}
                            <div id="modal-{{ $index }}" class="fixed inset-0 bg-black/10 backdrop-blur-lg z-50 hidden flex items-center justify-center">
                                <div class="bg-gray-900 text-gray-300 p-6 rounded-xl w-11/12 max-w-md space-y-4 relative">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold">{{ $logistic->name }}</h3>
                                        <button type="button" class="text-red-500 cursor-pointer" onclick="document.getElementById('modal-{{ $index }}').classList.add('hidden')">✕</button>
                                    </div>

                                    <div>
                                        <label for="quantity" class="block mb-1">Quantity <span class="text-red-500">*</span></label>
                                        <input
                                            type="number"
                                            id="quantity"
                                            name="logistic[{{ $logistic->id }}][quantity]"
                                            class="
                                                border border-gray-700 rounded px-2 py-1 text-gray-300
                                                w-full
                                                focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                transition duration-300 ease-in-out
                                            "
                                            value="{{ old('quantity') ?? $logistic->quantity }}"
                                            min="0"
                                        >
                                    </div>

                                    @php
                                        $units = ['pcs', 'pack', 'box', 'liter', 'ml', 'gram', 'kg'];
                                    @endphp

                                    <div>
                                        <label for="unit" class="block text-gray-300 mb-1">Unit <span class="text-red-500">*</span></label>
                                        <select
                                            id="unit"
                                            name="logistic[{{ $logistic->id }}][unit]"
                                            class="
                                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                                                focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                                                transition duration-300 ease-in-out
                                            "
                                            required
                                        >
                                            @foreach($units as $unit)
                                                <option
                                                    value="{{ $unit }}"
                                                    {{ $logistic->unit == $unit ? 'selected' : '' }}
                                                >
                                                    {{ ucfirst($unit) }}
                                                    {{ $logistic->unit == $unit ? '(Default)' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="price" class="block mb-1">Price <span class="text-red-500">*</span></label>
                                        <input
                                            type="number"
                                            id="price"
                                            name="logistic[{{ $logistic->id }}][price]"
                                            class="
                                                border border-gray-700 rounded px-2 py-1 text-gray-300
                                                w-full
                                                focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                transition duration-300 ease-in-out
                                            "
                                            value="{{ old('price') ?? $logistic->price }}"
                                            min="0"
                                        >
                                    </div>

                                    <div>
                                        <label for="description" class="block mb-1">Description Product</label>
                                        <textarea
                                            id="description"
                                            name="logistic[{{ $logistic->id }}][description]"
                                            class="
                                                border border-gray-700 rounded px-2 py-1 text-gray-300
                                                w-full
                                                focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                transition duration-300 ease-in-out
                                            "
                                            value="{{ old('description') ?? $logistic->description }}"
                                            placeholder="Description of Product..."
                                        >{{ $logistic->description }}</textarea>
                                    </div>

                                    <div>
                                        <label for="notes" class="block mb-1">Notes</label>
                                        <textarea
                                            id="notes"
                                            name="logistic[{{ $logistic->id }}][notes]"
                                            class="
                                                border border-gray-700 rounded px-2 py-1 text-gray-300
                                                w-full
                                                focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                transition duration-300 ease-in-out
                                            "
                                            value="{{ old('notes') ?? $logistic->notes }}"
                                            placeholder="Notes..."
                                        >{{ $logistic->notes }}</textarea>
                                    </div>

                                    <div>
                                        <label class="block mb-1">Group Item?</label>
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="hidden" name="logistic[{{ $logistic->id }}][is_group]" value="0">
                                            <input type="checkbox" class="hidden peer" name="logistic[{{ $logistic->id }}][is_group]"
                                                @if($logistic->is_group == 1) checked @endif>
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
                    </tbody>
                    <tfoot>
                        <tr class="w-full py-1">
                            <td colspan="6">
                                <button
                                    type="submit"
                                    name="action"
                                    value="update"
                                    class="
                                        mb-1 px-2 py-1 text-xs font-medium border-yellow-600 bg-yellow-600 rounded
                                        hover:bg-yellow-800 hover:border-yellow-800 hover:ring hover:ring-yellow-800
                                        transition duration-300 ease-in-out
                                        cursor-pointer
                                    "
                                >
                                    Update Data Logistic
                                </button>
                                <button
                                    type="submit"
                                    name="action"
                                    value="delete"
                                    class="
                                        mb-1 px-2 py-1 text-xs font-medium border-red-600 bg-red-600 rounded
                                        hover:bg-red-800 hover:border-red-800 hover:ring hover:ring-red-800
                                        transition duration-300 ease-in-out
                                        cursor-pointer
                                    "
                                >
                                    <i class="fa-regular fa-trash-can"></i>
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
        let logisticsTables;

        document.addEventListener("DOMContentLoaded", function () {
            logisticsTables = $('#logistic-table').DataTable({
                paging: false,
                order: [],
                columnDefs: [
                    { orderable: false, targets: 0 } // kolom nomor urut (#) tidak bisa di-sort
                ],
            });

            $('#customSearch').on('keyup', function () {
                logisticsTables.search(this.value).draw();
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
    </script>
@endpush
