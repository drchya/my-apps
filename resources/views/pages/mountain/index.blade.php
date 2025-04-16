@extends('layouts.main')

@section('content')
    <div class="px-2">
        @if (Auth::user()->id === 1)
            <div class="flex items-center gap-2">
                <a href="{{ route('mountain.create') }}" class="bg-emerald-600 hover:bg-emerald-700 px-2 py-1 rounded text-gray-100 transition duration-300 ease-in-out cursor-pointer">Add Mountain</a>
            </div>
        @endif

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

    <hr class="text-gray-800 my-4">

    <div class="overflow-x-auto px-2">
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
                    placeholder="Search mountain..."
                    class="bg-gray-800 border border-gray-600 text-gray-300 rounded px-2 py-1 focus:border-emerald-600 focus:outline-none transition duration-300 ease-in-out"
                    autocomplete="true"
                >
            </div>
        </div>

        <div x-data="{ showModal: false, selected: null }">
            <table id="mountain-table" class="border border-gray-800 shadow-lg rounded overflow-hidden mb-4 w-full">
                <thead class="bg-gray-800">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Elevation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="mountain-table-body">
                    @foreach($mountains as $mountain)
                        <tr data-id="{{ $mountain->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>Mt. {{ $mountain->name }}</td>
                            <td>{{ $mountain->location }}</td>
                            <td>{{ number_format($mountain->elevation, 0, ',', '.') }} Mdpl</td>
                            <td>
                                <div class="flex items-center gap-2">
                                    @php
                                        $encodedMountain = json_encode($mountain);
                                    @endphp

                                    <button
                                        @click='showModal = true; selected = {!! $encodedMountain !!}'
                                        class="w-8 h-8 border border-gray-800 rounded-md focus:outline-none cursor-pointer hover:border-cyan-600 hover:text-cyan-600 transition duration-300 ease-in-out"
                                    >
                                        <i class="fa-solid fa-info"></i>
                                    </button>


                                    @if(Auth::user()->id === 1)
                                        <a href="{{ route('mountain.edit', $mountain->slug) }}" class="flex items-center justify-center w-8 h-8 border border-gray-800 rounded-md focus:outline-none cursor-pointer hover:border-yellow-600 hover:text-yellow-600 transition duration-300 ease-in-out">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <button class="delete-mountain w-8 h-8 border border-gray-800 rounded-md focus:outline-none cursor-pointer hover:border-red-600 hover:text-red-600 transition duration-300 ease-in-out" data-id="{{ $mountain->id }}">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- START MODAL SHOW DETAIL MOUNTAIN --}}
                <div
                    x-show="showModal"
                    x-cloak
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                >
                    <div
                        @click.outside="showModal = false"
                        class="bg-gray-900 text-white rounded-lg shadow-xl w-full max-w-md p-6"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="scale-90 opacity-0"
                        x-transition:enter-end="scale-100 opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="scale-100 opacity-100"
                        x-transition:leave-end="scale-90 opacity-0"
                    >
                        <button
                            @click="showModal = false"
                            class="absolute top-2 right-2 text-gray-400 hover:text-white text-lg cursor-pointer"
                        >
                            &times;
                        </button>

                        <h2 class="text-xl font-semibold mb-4">Mountain Details</h2>

                        <template x-if="selected">
                            <div class="space-y-2">
                                <p><strong>Name:</strong> <span x-text="selected.name"></span></p>
                                <p><strong>Location:</strong> <span x-text="selected.location"></span></p>
                                <p><strong>Elevation:</strong> <span x-text="Number(selected.elevation).toLocaleString('id-ID') + ' Mdpl'"></span></p>
                                <p><strong>Latitude:</strong> <span x-text="selected.latitude"></span></p>
                                <p><strong>Longitude:</strong> <span x-text="selected.longitude"></span></p>
                            </div>
                        </template>
                    </div>
                </div>
            {{-- END MODAL SHOW DETAIL MOUNTAIN --}}
        </div>
    </div>
@endsection

@push('scripts')
    {{-- DataTables & jQuery --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        let mountainTables;

        document.addEventListener("DOMContentLoaded", function () {
            mountainTables = $('#mountain-table').DataTable({
                order: [[2, 'desc']], // default sort kolom Created At
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
                mountainTables.search(this.value).draw();
            });

            // 📄 Custom Length
            $('#customLength').on('change', function () {
                mountainTables.page.len(this.value).draw();
            });

            document.addEventListener('click', async function (e) {
                if (e.target.closest('.delete-mountain')) {
                    const button = e.target.closest('.delete-mountain');
                    const id = button.dataset.id;
                    const forceDeleteRoute = "{{ route('mountain.force.delete', ['id' => '__id__']) }}";

                    if (!confirm('Are you sure want to delete this data?')) return;

                    try {
                        const url = forceDeleteRoute.replace('__id__', id);

                        const response = await fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) throw new Error("Force delete failed!");

                        const row = $(`tr[data-id="${id}"]`);
                        if (row.length) {
                            row.fadeOut(300, function () {
                                mountainTables.row(row).remove().draw();
                            });
                        }
                    } catch(error) {
                        console.error("Force delete error: ", error);
                        alert("Failed to remove users from database!");
                    }
                }
            })
        });
    </script>
@endpush
