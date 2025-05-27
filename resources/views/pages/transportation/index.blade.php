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
            <a href="{{ route('preparation.logistics.index', $preparation->slug) }}" class="flex items-center gap-1 text-blue-600 font-medium hover:text-blue-800 transition duration-300 ease-in-out">
                <span class="flex w-4 items-center justify-center">
                    <i class="fa-solid fa-box"></i>
                </span>
                Logistic
            </a>
        </div>

        <hr class="text-gray-800 my-4" />

        <form action="{{ route('preparation.transportation.store', $preparation->slug) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <div>
                    <label for="type-transport" class="block text-gray-300 mb-1">Type Transportation <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="type-transport"
                        name="type"
                        class="
                            w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                            focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                            transition duration-300 ease-in-out
                        "
                        placeholder="Your transport..."
                        autocomplete="off"
                        required
                    >
                </div>

                <div>
                    <label for="departure-location" class="block text-gray-300 mb-1">Departure Location <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="departure-location"
                        name="departure_location"
                        class="
                            w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                            focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                            transition duration-300 ease-in-out
                        "
                        autocomplete="off"
                        placeholder="Arrival location..."
                        required
                    >
                </div>

                <div>
                    <label for="arrival-location" class="block text-gray-300 mb-1">Arrival Location <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="arrival-location"
                        name="arrival_location"
                        class="
                            w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                            focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                            transition duration-300 ease-in-out
                        "
                        autocomplete="off"
                        placeholder="Arrival location..."
                        required
                    >
                </div>

                <div>
                    <div x-data="datepicker('departure')" x-init="init()" class="relative">
                        <label for="departure-date" class="block text-gray-300 mb-1">Departure Date <span class="text-red-500">*</span></label>

                        <input
                            type="text"
                            x-model="selectedDateFormatted"
                            id="departure-date"
                            @click="open = !open"
                            readonly
                            class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out cursor-pointer"
                            placeholder="Select Departure Date"
                        >

                        <input type="hidden" name="departure_time" :value="selectedDateValue">

                        @include('component.datepicker-popup')
                    </div>
                </div>

                <div>
                    <div x-data="datepicker('departure')" x-init="init()" class="relative">
                        <label for="arrival-date" class="block text-gray-300 mb-1">Arrival Date <span class="text-red-500">*</span></label>

                        <input
                            type="text"
                            x-model="selectedDateFormatted"
                            id="arrival-date"
                            @click="open = !open"
                            readonly
                            class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out cursor-pointer"
                            placeholder="Select Arrival Date"
                        >

                        <input type="hidden" name="arrival_time" :value="selectedDateValue">

                        @include('component.datepicker-popup')
                    </div>
                </div>

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

                @php
                    $categories = ['personal', 'with_friends', 'open_trip'];
                @endphp

                <div>
                    <label for="type-trip" class="block text-gray-300 mb-1">Category Transport <span class="text-red-500">*</span></label>
                    <select
                        id="type-trip"
                        name="type_trip"
                        class="
                            w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                            focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                            transition duration-300 ease-in-out
                        "
                        required
                    >
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ str_replace('_', ' ', ucfirst($category)) }}</option>
                        @endforeach
                    </select>
                </div>

                @php
                    $status = ['available', 'not_available', 'cancelled', 'booked'];
                @endphp
                <div>
                    <label for="status" class="block text-gray-300 mb-1">Status</label>
                    <select
                        id="status"
                        name="status"
                        class="
                            w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                            focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                            transition duration-300 ease-in-out
                        "
                    >
                        @foreach($status as $stat)
                            <option value="{{ $stat }}">{{ str_replace('_', ' ', ucfirst($stat)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="notes" class="block text-gray-300 mb-1">Notes</label>
                    <textarea
                        type="text"
                        id="notes"
                        name="notes"
                        class="
                            w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                            focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                            transition duration-300 ease-in-out
                        "
                        rows="1"
                        placeholder="Notes transportation..."
                        autocomplete="off"
                    ></textarea>
                </div>
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
                        placeholder="Search Transportation..."
                        class="border border-gray-600 text-gray-300 rounded px-2 py-1 focus:border-emerald-600 focus:outline-none transition duration-300 ease-in-out"
                        autocomplete="on"
                    >
                </div>
            </div>

            <?php
                foreach ($preparation->transportations as $transport) :
                    if ($transport['status'] === 'not_available') :
            ?>
                <div class="my-2">
                    <p class="mb-0 text-gray-300">
                        <span class="text-red-500">*</span> The transportation option "<strong><?= $transport['type'] ?></strong> Deparutre <strong><?= $transport['departure_location'] ?></strong>" is currenty unavailable. Please update or choose another option to proceed with your trip prepration.
                    </p>
                </div>
            <?php elseif ($transport['status'] === 'cancelled') : ?>
                <div class="my-2">
                    <p class="mb-0 text-gray-300">
                        <span class="text-red-500">*</span>The transportation option "<strong><?= $transport['type'] ?></strong> Deparutre <strong><?= $transport['departure_location'] ?></strong>" has been <strong>cancelled</strong>. Please select an alternative to ensure your trip is not disrupted.
                    </p>
                </div>
            <?php
                    endif;
                endforeach;
            ?>

            <div>
                <form action="{{ route('preparation.transportation.update', ['preparation' => $preparation->slug, 'transportation' => $preparation->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <table id="transportation-table" class="border border-gray-800 shadow-lg rounded overflow-auto mb-4 w-full">
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
                                <th>Type</th>
                                <th>Where</th>
                                <th>More</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-300">
                            @if ($preparation->transportations->isNotEmpty())
                                @php $index = 0; @endphp
                                @foreach ($preparation->transportations as $transport)
                                    @php $index++ @endphp
                                    <tr>
                                        <td>
                                            <label class="inline-flex items-center space-x-2">
                                                <input type="checkbox" class="hidden peer" name="transport[{{ $transport->id }}][selected]" value="1">
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
                                                <input type="hidden" name="transport[{{ $transport->id }}][checked]" value="0">

                                                <input
                                                    type="checkbox"
                                                    class="hidden peer"
                                                    name="transport[{{ $transport->id }}][checked]"
                                                    value="1"
                                                    {{ $transport->checked ? 'checked' : '' }}
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

                                        <td>{{ $transport->type }}</td>
                                        <td>
                                            <div class="flex flex-col md:flex-row items-center">
                                                <span class="text-gray-400 font-medium">{{ $transport->departure_location }}</span>
                                                <span class="flex items-center justify-center w-6 h-6 text-xs text-gray-700">
                                                    <i class="fa-solid fa-right-left"></i>
                                                </span>
                                                <span class="text-gray-400 font-medium">{{ $transport->arrival_location }}</span>
                                            </div>
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
                                    <div id="modal-{{ $index }}" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
                                        <div class="bg-gray-900 text-gray-300 p-6 rounded-xl w-11/12 max-w-md space-y-4 relative">
                                            <div>
                                                <div class="flex flex-row items-center justify-between">
                                                    <h3 class="text-lg font-semibold">{{ $transport->type }}</h3>
                                                    <button type="button" class="text-red-500 cursor-pointer" onclick="document.getElementById('modal-{{ $index }}').classList.add('hidden')">✕</button>
                                                </div>
                                                <div class="flex items-center">
                                                    <span>{{ $transport->departure_location }}</span>
                                                    <span class="flex items-center justify-center w-6 h-6 text-xs text-gray-700">
                                                        <i class="fa-solid fa-right-left"></i>
                                                    </span>{{ $transport->arrival_location }}</span>
                                                </div>
                                            </div>

                                            <hr class="text-gray-800" />

                                            <div>
                                                <div x-data="datepicker('departure', '{{ old('departure_time', $transport->departure_time ?? '') }}')" x-init="init()" class="relative">
                                                    <label for="departure_time" class="block text-gray-300 mb-1">Departure Date <span class="text-red-500">*</span></label>

                                                    <input
                                                        type="text"
                                                        x-model="selectedDateFormatted"
                                                        id="departure_time"
                                                        @click="open = !open"
                                                        readonly
                                                        class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out cursor-pointer"
                                                        placeholder="Select Arrival Date"
                                                    >

                                                    <input type="hidden" name="transport[{{ $transport->id }}][departure_time]" :value="selectedDateValue">

                                                    @include('component.datepicker-popup')
                                                </div>
                                            </div>

                                            <div>
                                                <div x-data="datepicker('departure', '{{ old('arrival_time', $transport->arrival_time ?? '') }}')" x-init="init()" class="relative">
                                                    <label for="arrival_time" class="block text-gray-300 mb-1">Arrival Date <span class="text-red-500">*</span></label>

                                                    <input
                                                        type="text"
                                                        x-model="selectedDateFormatted"
                                                        id="arrival_time"
                                                        @click="open = !open"
                                                        readonly
                                                        class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out cursor-pointer"
                                                        placeholder="Select Arrival Date"
                                                    >

                                                    <input type="hidden" name="transport[{{ $transport->id }}][arrival_time]" :value="selectedDateValue">

                                                    @include('component.datepicker-popup')
                                                </div>
                                            </div>

                                            <div>
                                                <label for="price" class="block mb-1">Price <span class="text-red-500">*</span></label>
                                                <input
                                                    type="number"
                                                    id="price"
                                                    name="transport[{{ $transport->id }}][price]"
                                                    class="
                                                        border border-gray-700 rounded px-2 py-1 text-gray-300
                                                        w-full
                                                        focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                        transition duration-300 ease-in-out
                                                    "
                                                    min="0"
                                                    value="{{ rtrim(rtrim(number_format($transport->price, 2, '.', ''), '0'), '.') }}"
                                                    required
                                                >
                                            </div>

                                            @php
                                                $categories = ['personal', 'with_friends', 'open_trip'];
                                            @endphp
                                            <div>
                                                <label for="type-trip" class="block text-gray-300 mb-1">Category Transport <span class="text-red-500">*</span></label>
                                                <select
                                                    id="type-trip"
                                                    name="transport[{{ $transport->id }}][type_trip]"
                                                    class="
                                                        w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                                                        focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                                                        transition duration-300 ease-in-out
                                                    "
                                                    required
                                                >
                                                    @foreach($categories as $category)
                                                        <option
                                                            value="{{ $category }}"
                                                            {{ $transport->trip_type == $category ? 'selected' : '' }}
                                                        >
                                                            {{ str_replace('_', ' ', ucfirst($category)) }}
                                                            {{ $transport->trip_type == $category ? '(Default)' : '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            @php
                                                $status = ['available', 'not_available', 'cancelled', 'booked'];
                                            @endphp
                                            <div>
                                                <label for="status" class="block text-gray-300 mb-1">Status</label>
                                                <select
                                                    id="status"
                                                    name="transport[{{ $transport->id }}][status]"
                                                    class="
                                                        w-full px-3 py-2 border border-gray-700 rounded text-gray-300
                                                        focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                                                        transition duration-300 ease-in-out
                                                    "
                                                >
                                                    @foreach($status as $stat)
                                                        <option
                                                            value="{{ $stat }}"
                                                            {{ $transport->status == $stat ? 'selected' : '' }}
                                                        >
                                                            {{ str_replace('_', ' ', ucfirst($stat)) }}
                                                            {{ $transport->status == $stat ? '(Default)' : '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <label for="notes" class="block mb-1">Notes</label>
                                                <textarea
                                                    id="notes"
                                                    name="transport[{{ $transport->id }}][notes]"
                                                    class="
                                                        border border-gray-700 rounded px-2 py-1 text-gray-300
                                                        w-full
                                                        focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-600
                                                        transition duration-300 ease-in-out
                                                    "
                                                    value="{{ old('notes') ?? $transport->notes }}"
                                                    placeholder="Notes..."
                                                >{{ $transport->notes }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="w-full py-1">
                                <td colspan="5">
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
                                        Update Data Transport
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
    </div>
@endsection

@push('scripts')
    {{-- DataTables & jQuery --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        let transportationsTables;

        document.addEventListener("DOMContentLoaded", function () {
            transportationsTables = $('#transportation-table').DataTable({
                paging: false,
                order: [],
                columnDefs: [
                    { orderable: false, targets: 0 } // kolom nomor urut (#) tidak bisa di-sort
                ],
            });

            $('#customSearch').on('keyup', function () {
                transportationsTables.search(this.value).draw();
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

        function datepicker(prefix, initialDate = '') {
            return {
                open: false,
                month: new Date().getMonth(),
                year: new Date().getFullYear(),
                selectedDate: null,
                selectedDateFormatted: '',
                selectedDateValue: '',
                daysInMonth: [],
                blanks: [],
                monthNames: [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ],

                init() {
                    if (initialDate) {
                        const initDate = new Date(initialDate);

                        if (!isNaN(initDate)) { // pastikan valid
                            this.selectedDate = initDate;
                            this.selectedDateFormatted = this.selectedDate.toLocaleDateString('id-ID', {
                                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                            });

                            const year = this.selectedDate.getFullYear();
                            const month = String(this.selectedDate.getMonth() + 1).padStart(2, '0');
                            const day = String(this.selectedDate.getDate()).padStart(2, '0');
                            this.selectedDateValue = `${year}-${month}-${day}`;

                            this.month = this.selectedDate.getMonth();
                            this.year = this.selectedDate.getFullYear();
                        }
                    }

                    this.generateCalendar();
                },

                generateCalendar() {
                    const firstDay = new Date(this.year, this.month, 1).getDay();
                    const totalDays = new Date(this.year, this.month + 1, 0).getDate();
                    this.blanks = Array(firstDay).fill(null);
                    this.daysInMonth = Array.from({ length: totalDays }, (_, i) => i + 1);
                },

                prevMonth() {
                    this.month = this.month === 0 ? 11 : this.month - 1;
                    if (this.month === 11) this.year--;
                    this.generateCalendar();
                },

                nextMonth() {
                    this.month = this.month === 11 ? 0 : this.month + 1;
                    if (this.month === 0) this.year++;
                    this.generateCalendar();
                },

                selectDate(date) {
                    this.selectedDate = new Date(this.year, this.month, date);

                    this.selectedDateFormatted = this.selectedDate.toLocaleDateString('id-ID', {
                        weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                    });

                    const year = this.selectedDate.getFullYear();
                    const month = String(this.selectedDate.getMonth() + 1).padStart(2, '0');
                    const day = String(this.selectedDate.getDate()).padStart(2, '0');
                    this.selectedDateValue = `${year}-${month}-${day}`;

                    this.open = false;
                },

                isToday(date) {
                    const today = new Date();
                    const current = new Date(this.year, this.month, date);
                    return today.toDateString() === current.toDateString();
                },

                isSelectedDate(date) {
                    if (!this.selectedDate) return false;
                    const selected = new Date(this.year, this.month, date);
                    return selected.toDateString() === this.selectedDate.toDateString();
                }
            };
        }
    </script>
@endpush
