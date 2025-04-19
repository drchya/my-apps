@extends('layouts.main')

@section('content')
    <div class="p-6 border border-gray-700 shadow-xl rounded-lg space-y-2">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">{{ $title }}</h1>
            <a href="{{ route('preparation.index') }}" class="text-gray-500 hover:text-emerald-600 transition duration-300 ease-in-out">Back to table</a>
        </div>
        <hr class="text-gray-700" />
        <div>
            <form action="{{ route('preparation.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <input
                        type="hidden"
                        id="user-id"
                        name="user_id"
                        class="
                            w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                        "
                        required
                        value="{{ auth()->user()->id }}"
                    >
                    <div>
                        <label for="mountain-id" class="block text-gray-300 mb-1">Mountain <span class="text-red-500">*</span></label>
                        <select
                            id="mountain-id"
                            name="mountain_id"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 bg-gray-800
                                focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                                transition duration-400 ease-in-out cursor-pointer
                            "
                        >
                            <option
                                value=""
                                class="text-gray-400 bg-gray-900 hover:bg-emerald-900 transition duration-200 ease-in-out"
                                disabled selected
                            >
                                Default Selected
                            </option>
                            @foreach($mountains as $mountain)
                                <option
                                    class="text-gray-300 outline-gray-700 bg-gray-900 hover:bg-emerald-600 transition duration-200 ease-in-out"
                                    value="{{ $mountain->id }}"
                                    {{ old('mountain_id', $gear->mountain_id ?? '') == $mountain->id ? 'selected' : '' }}
                                >
                                    Mt. {{ $mountain->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('mountain_id')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="via" class="block text-gray-300 mb-1">Via <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            id="via"
                            name="via"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                                @error('via') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror
                            "
                            placeholder="...."
                            required
                        >
                        @error('via')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- START DEPARTURE DATE --}}
                    <div x-data="datepicker('departure')" x-init="init()" class="relative">
                        <label for="departure_date" class="block text-gray-300 mb-1">Departure Date <span class="text-red-500">*</span></label>

                        <input
                            type="text"
                            x-model="selectedDateFormatted"
                            id="departure_date"
                            @click="open = !open"
                            readonly
                            class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out cursor-pointer"
                            placeholder="Select Departure Date"
                        >

                        <input type="hidden" name="departure_date" :value="selectedDateValue">

                        @include('component.datepicker-popup')
                    </div>
                    {{-- END DEPARTURE DATE --}}

                    {{-- START RETURN DATE --}}
                    <div x-data="datepicker('return')" x-init="init()" class="relative">
                        <label for="return_date" class="block text-gray-300 mb-1">Return Date</label>

                        <input
                            type="text"
                            x-model="selectedDateFormatted"
                            @click="open = !open"
                            readonly
                            class="w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out cursor-pointer"
                            placeholder="Select Return Date"
                        >

                        <input type="hidden" name="return_date" :value="selectedDateValue">

                        @include('component.datepicker-popup')
                    </div>
                    {{-- END RETURN DATE --}}

                    <div>
                        <label for="type-trip" class="block text-gray-300 mb-1">Type Trip <span class="text-red-500">*</span></label>
                        <select
                            id="type-trip"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 bg-gray-800
                                focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                                transition duration-400 ease-in-out cursor-pointer
                            "
                            name="type_trip"
                            required
                        >
                            <option
                                value=""
                                class="text-gray-400 bg-gray-900 hover:bg-emerald-900 transition duration-200 ease-in-out"
                                disabled selected
                            >
                                Default Selected
                            </option>
                            @foreach($typeTrips as $type_trip)
                                <option value="{{ $type_trip->value }}">{{ $type_trip->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="style_trip" class="block text-gray-300 mb-1">Style Trip <span class="text-red-500">*</span></label>
                        <select
                            id="style_trip"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 bg-gray-800
                                focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600
                                transition duration-400 ease-in-out cursor-pointer
                            "
                            name="style_trip"
                            required
                        >
                            <option
                                value=""
                                class="text-gray-400 bg-gray-900 hover:bg-emerald-900 transition duration-200 ease-in-out"
                                disabled selected
                            >
                                Default Selected
                            </option>
                            @foreach($styleTrips as $style_trip)
                                <option value="{{ $style_trip->value }}">{{ $style_trip->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="budget-estimate" class="block text-gray-300 mb-1">Budget Estimate</label>
                        <input
                            type="number"
                            id="budget-estimate"
                            name="budget_estimate"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out
                                @error('budget_estimate') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror
                            "
                            placeholder="Rp."
                        >

                        @error('budget_estimate')
                            <p class="text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="note" class="block text-gray-300 mb-1">Note</label>
                        <textarea
                            id="note"
                            name="note"
                            class="
                                w-full px-3 py-2 border border-gray-700 rounded text-gray-300 focus:outline-none focus:ring focus:ring-emerald-600 focus:border-emerald-600 transition duration-300 ease-in-out placeholder-gray-500
                            "
                            placeholder="...."
                            rows="1"
                        ></textarea>
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
        function datepicker(prefix) {
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

                    // Tampilkan ke user (format Indonesia)
                    this.selectedDateFormatted = this.selectedDate.toLocaleDateString('id-ID', {
                        weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                    });

                    // Untuk database (format YYYY-MM-DD)
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
