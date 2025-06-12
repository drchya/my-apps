@extends('layouts.main')

@section('content')
    <div class="flex items-center">
        <div class="flex items-center">
            <a href="{{ route('gear.create') }}" class="text-xs bg-emerald-600 hover:bg-emerald-700 px-2 py-1 rounded text-gray-100 transition duration-300 ease-in-out cursor-pointer">Add User Gear</a>
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
            class="my-2 text-gray-300 text-center md:text-start font-medium bg-emerald-500/70 py-2 md:px-2 rounded-lg"
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
                    placeholder="Search Item..."
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
                        <th>User</th>
                        <th>Gear Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="preparation-table-body">
                    @php
                        $grouped = $gears->groupBy('user_id');
                    @endphp
                    @foreach ($grouped as $userId => $group)
                        @php
                            $item = $group->first();
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->email }}</td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <span class="px-1 bg-emerald-600 rounded">{{ $group->count() }}</span>
                                    <p>Gears</p>
                                </div>
                            </td>
                            <td>
                                <a
                                    href="{{ route('gear.user.show', $item->user->slug) }}"
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
                            </td>
                        </tr>
                    @endforeach
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
