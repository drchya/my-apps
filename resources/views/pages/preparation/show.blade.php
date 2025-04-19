@extends('layouts.main')

@section('content')
    <div class="px-2">
        <div
            x-data="
                { message: '{{ session('message') }}',
                 deleted: '{{ session('delete') }}' }
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
        <div>
            <span onclick="document.getElementById('addGearModal').classList.remove('hidden')" class="text-emerald-500 hover:text-white">Add Gear</span>

            <!-- Modal -->
            <div id="addGearModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
                <div class="bg-gray-900 p-6 rounded-xl w-full max-w-lg shadow-xl">
                    <h2 class="text-xl font-bold text-white mb-4">Add Gear</h2>
                    <form action="#" method="POST">
                        @csrf
                        <input type="hidden" name="preparation_id" value="{{ $preparation->id }}">

                        <div class="mb-3">
                            <label class="text-white">Type</label>
                            <select name="type_id" class="w-full mt-1 rounded">
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="text-white block">Gear Use Category (Checklist)</label>
                            @foreach (['tracking', 'summit_attack', 'sleeping', 'on_the_way', 'backup'] as $option)
                                <label class="inline-flex items-center text-white space-x-2">
                                    <input type="checkbox" name="category_gear[]" value="{{ $option }}" class="mr-2">
                                    <span class="capitalize">{{ str_replace('_', ' ', $option) }}</span>
                                </label><br>
                            @endforeach
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-white">Quantity</label>
                                <input type="number" name="quantity" class="w-full rounded" min="1" value="1">
                            </div>
                            <div>
                                <label class="text-white">Price</label>
                                <input type="number" name="price" class="w-full rounded" placeholder="Optional">
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="text-white">Status Gear</label>
                            <select name="status_gear" class="w-full rounded">
                                <option value="owned">Owned</option>
                                <option value="rented">Rented</option>
                                <option value="not_available">Not Available</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label class="text-white">Urgency</label>
                            <select name="urgency" class="w-full rounded">
                                <option value="urgent">Urgent</option>
                                <option value="important">Important</option>
                                <option value="not_urgent">Not Urgent</option>
                            </select>
                        </div>

                        <div class="flex items-center mt-3 text-white">
                            <input type="checkbox" name="is_group" id="is_group" class="mr-2">
                            <label for="is_group">Group Gear</label>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" onclick="document.getElementById('addGearModal').classList.add('hidden')" class="text-white">Cancel</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded text-white">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <span>Show Data</span>
                <select id="customLength" class="bg-gray-800 border border-gray-600 text-gray-600 rounded px-2 py-1 focus:outline-none focus:border-emerald-600 focus:text-gray-300 transition duration-300 ease-in-out">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            <div>
                <input
                    type="text"
                    id="customSearch"
                    placeholder="Search Destination..."
                    class="bg-gray-800 border border-gray-600 text-gray-300 rounded px-2 py-1 focus:border-emerald-600 focus:outline-none transition duration-300 ease-in-out"
                    autocomplete="true"
                >
            </div>
        </div>

        <div>
            <table id="preparation-item" class="border border-gray-800 shadow-lg rounded overflow-hidden mb-4 w-full">
                <thead class="bg-gray-800">
                    <tr>
                        <th>Checklist</th>
                        <th>Gear</th>
                        <th>Quantity</th>
                        <th>Status Gear</th>
                        <th>Urgency</th>
                    </tr>
                </thead>
                <tbody id="preparation-item-body">

                </tbody>
            </table>
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
                order: [],
                columnDefs: [
                    { orderable: false, targets: 0 } // kolom nomor urut (#) tidak bisa di-sort
                ],
                drawCallback: function(settings) {
                    const api = this.api();
                    api.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }
            });

            $('#customSearch').on('keyup', function () {
                preparationsTables.search(this.value).draw();
            });

            // 📄 Custom Length
            $('#customLength').on('change', function () {
                preparationsTables.page.len(this.value).draw();
            });
        });
    </script>
@endpush
