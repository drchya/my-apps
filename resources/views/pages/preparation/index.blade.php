@extends('layouts.main')

@section('content')
    <div class="flex items-center">
        <div class="flex items-center">
            <a href="{{ route('preparation.create') }}" class="text-xs bg-emerald-600 hover:bg-emerald-700 px-2 py-1 rounded text-gray-100 transition duration-300 ease-in-out cursor-pointer">Add Your Prepared</a>
        </div>
    </div>

    <div
        x-data="{ message: '{{ session('message') }}', deleted: '{{ session('delete') }}' }"
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
            class="my-2 text-gray-300 text-center md:text-start font-medium bg-emerald-500/70 py-2 md:px-4 rounded-lg"
        ></div>
    </div>

    <hr class="text-gray-800 my-2">

    <div class="overflow-x-auto">
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <select id="customLength" class="border border-gray-600 text-gray-300 rounded px-2 py-1 focus:outline-none focus:border-emerald-600 focus:text-gray-300 transition duration-300 ease-in-out">
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
                    class="border border-gray-600 text-gray-300 rounded px-2 py-1 focus:border-emerald-600 focus:outline-none transition duration-300 ease-in-out"
                    autocomplete="true"
                >
            </div>
        </div>

        <div x-data="{ showModal: false, selected: null }">
            <table id="preparation-table" class="border border-gray-800 shadow-lg rounded overflow-hidden mb-4 w-full">
                <thead class="bg-gray-800">
                    <tr>
                        <th>#</th>
                        <th>Mountain</th>
                        @if (auth()->id() == 1)
                            <th>User</th>
                        @else
                            <th>Summit Status</th>
                        @endif
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="preparation-table-body">
                    @if (auth()->id() == 1)
                        @php
                            $grouped = $preparations->groupBy('mountain_id');
                        @endphp
                        @foreach($grouped as $mountainId => $group)
                            @php
                                $mountain = $group->first()->mountain;
<<<<<<< Updated upstream
                                $slug = $group->first()->slug;
=======
>>>>>>> Stashed changes
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $mountain->name }}</td>
                                <td>
                                    <div class="flex items-center gap-1">
                                        <span class="px-1 bg-emerald-600 rounded">{{ $group->count() }}</span>
                                        <p>Users</p>
                                    </div>
                                </td>
                                <td>
<<<<<<< Updated upstream
                                    <div class="flex items-center gap-2">
                                        <a
                                            href="{{ route('preparation.mountain.show', $mountain->slug) }}"
                                            class="
                                                flex items-center justify-center w-8 h-8 border border-gray-800 rounded-md
                                                focus:outline-none
                                                bg-blue-600 md:bg-transparent md:hover:border-blue-600 md:hover:text-blue-600
                                                transition duration-300 ease-in-out
                                                cursor-pointer
                                            "
                                        >
                                            <i class="fa-solid fa-info"></i>
                                        </a>
                                        <a
                                            href="{{ route('export.preparation.download', $slug) }}"
                                            class="
                                                flex items-center justify-center w-8 h-8 border border-gray-800 rounded-md
                                                focus:outline-none
                                                bg-green-600 md:bg-transparent md:hover:border-green-600 md:hover:text-green-600
                                                transition duration-300 ease-in-out
                                                cursor-pointer
                                            "
                                        >
                                            <i class="fa-regular fa-file-excel"></i>
                                        </a>
                                    </div>
=======
                                    <a href="{{ route('preparation.mountain.show', $mountain->slug) }}" class="
                                        flex items-center justify-center w-8 h-8 border border-gray-800 rounded-md
                                        focus:outline-none
                                        bg-blue-600 md:bg-transparent md:hover:border-blue-600 md:hover:text-blue-600
                                        transition duration-300 ease-in-out
                                        cursor-pointer
                                    ">
                                        <i class="fa-solid fa-info"></i>
                                    </a>
>>>>>>> Stashed changes
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach($preparations as $preparation)
                            <tr data-id="{{ $preparation->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $preparation->mountain->name }}</td>
                                <td>
                                    @php
                                        $badgeClasses = [
                                            'planning'    => 'bg-gray-600 text-gray-100',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 rounded text-sm font-medium {{ $badgeClasses[$preparation->status] ?? 'bg-gray-500 text-white' }} capitalize">
                                        {{ $preparation->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <a
                                            href="{{ route('preparation.show', $preparation->slug) }}"
                                            class="
                                                flex items-center justify-center w-8 h-8 border border-gray-800 rounded-md
                                                focus:outline-none
                                                bg-blue-600 md:bg-transparent md:hover:border-blue-600 md:hover:text-blue-600
                                                transition duration-300 ease-in-out
                                                cursor-pointer
                                            "
                                        >
                                            <i class="fa-solid fa-info"></i>
                                        </a>

                                        <button
                                            class="
                                                delete-preparation
                                                w-8 h-8 border border-gray-800 rounded-md
                                                focus:outline-none
                                                bg-red-600 md:bg-transparent md:hover:border-red-600 md:hover:text-red-600
                                                transition duration-300 ease-in-out
                                                cursor-pointer
                                            "
                                            data-id="{{ $preparation->id }}"
                                        >
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
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
            preparationsTables = $('#preparation-table').DataTable({
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

            document.addEventListener('click', async function (e) {
                if (e.target.closest('.delete-preparation')) {
                    const button = e.target.closest('.delete-preparation');
                    const id = button.dataset.id;

                    if (!confirm('Are you sure want to delete this user?')) return;

                    try {
                        const response = await fetch(`/preparation/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) throw new Error("Delete failed!");
                        const row = $(`tr[data-id="${id}"]`);
                        if (row.length) {
                            row.fadeOut(300, function () {
                                usersTable.row(row).remove.draw();
                            });
                        }
                    } catch(error) {
                        console.error("Delete error: ", error);
                        alert("Failed to delete users!");
                    }
                }
            })
        });
    </script>
@endpush
