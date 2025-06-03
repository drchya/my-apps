@extends('layouts.main')

@section('content')
    <div class="flex items-center">
        <a href="{{ route('setting.type.create') }}" class="bg-emerald-600 hover:bg-emerald-700 px-2 py-1 rounded text-gray-100 transition duration-300 ease-in-out cursor-pointer">Add Type Item</a>
    </div>

    <div
        x-data="
            {
                message: '{{ session('message') }}'
                deleted: '{{ session('delete') }}'
            }
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

    <hr class="text-gray-800 my-2" />

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
                    placeholder="Search Type..."
                    class="border border-gray-600 text-gray-300 rounded px-2 py-1 focus:border-emerald-600 focus:outline-none transition duration-300 ease-in-out"
                >
            </div>
        </div>

        <table id="type-table" class="border border-gray-800 shadow-lg rounded overflow-hidden mb-4 w-full">
            <thead class="bg-gray-800">
                <tr>
                    <th>#</th>
                    <th>Name Type</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="type-table-body">
                @foreach ($types as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a
                                    href="{{ route('setting.type.edit', $item->slug) }}"
                                    class="
                                        flex items-center justify-center w-8 h-8 border border-gray-800 rounded-md
                                        focus:outline-none
                                        bg-yellow-600 md:bg-transparent md:hover:border-yellow-600 md:hover:text-yellow-600
                                        transition duration-300 ease-in-out
                                        cursor-pointer
                                    "
                                >
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <button
                                    class="
                                        w-8 h-8 border border-gray-800 rounded-md
                                        focus:outline-none
                                        bg-red-600 md:bg-transparent md:hover:border-red-600 md:hover:text-red-600
                                        transition duration-300 ease-in-out
                                        cursor-pointer
                                    "
                                >
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        let typesTable;

        document.addEventListener("DOMContentLoaded", function () {
            typesTable = $('#type-table').DataTable({
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
                typesTable.search(this.value).draw();
            });

            // 📄 Custom Length
            $('#customLength').on('change', function () {
                typesTable.page.len(this.value).draw();
            });
        });
    </script>
@endpush
