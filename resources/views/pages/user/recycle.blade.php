@extends('layouts.main')

@section('content')
    <div class="flex px-2">
        <a href="{{ route('users.index') }}" class="bg-emerald-600 text-gray-300 px-2 py-1 rounded hover:bg-emerald-700 transition duration-300 ease-in-out">Back to table</a>
    </div>

    {{-- <div id="message-container" x-data="{ message: '', show: false }">
        <span x-show="show" x-text="message"></span>
    </div> --}}

    <div class="overflow-x-auto px-2 my-2">
        <div class="flex items-center justify-between mb-2">
            <div>
                <select id="customLength" class="bg-gray-800 border border-gray-600 text-white rounded px-2 py-1 focus:outline-none">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>

            <div>
                <input
                    type="text"
                    id="customSearch"
                    placeholder="Search users..."
                    class="bg-gray-800 border border-gray-600 text-gray-300 rounded px-3 py-1 ring ring-transparent focus:ring-emerald-500 focus:outline-none"
                    autocomplete="true"
                >
            </div>
        </div>

        <table id="recycle-table" class="border border-gray-800 shadow-lg rounded overflow-hidden mb-4 w-full">
            <thead class="bg-gray-800 text-gray-300 text-left">
                <tr>
                    <th class="p-2">#</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Deleted At</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr data-id="{{ $user->id }}">
                        <td class="p-2">{{ $loop->iteration }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2">
                            <span class="hidden lg:inline">
                                {{ $user->deleted_at->translatedFormat('l, d F Y - H:i:s') }}
                            </span>

                            <span class="inline lg:hidden">
                                {{ $user->deleted_at->translatedFormat('l, d F Y') }}
                            </span>
                        </td>
                        <td class="p-2">
                            <div class="flex items-center gap-2">
                                <button class="remove-user text-red-500 hover:text-red-700 transition duration-300 ease-in-out cursor-pointer" data-id="{{ $user->id }}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                                <button class="restore-user text-amber-300 hover:text-amber-600 transition duration-300 ease-in-out cursor-pointer" data-id="{{ $user->id }}">
                                    <i class="fa-solid fa-rotate"></i>
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
        document.addEventListener("DOMContentLoaded", function () {
            const table = $('#recycle-table').DataTable({
                order: [[2, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [0, 3] }
                ],
                drawCallback: function (settings) {
                    const api = this.api();
                    api.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }
            });

            $('#customSearch').on('keyup', function () {
                table.search(this.value).draw();
            });

            $('#customLength').on('change', function () {
                table.page.len(this.value).draw();
            });

            document.addEventListener('click', async function (e) {
                if (e.target.closest('.remove-user')) {
                    const button = e.target.closest('.remove-user');
                    const id = button.dataset.id;
                    const forceDeleteRoute = "{{ route('users.force.delete', ['id' => '__id__']) }}";

                    if (!confirm('Are you sure want to remove this data from Database?')) return;

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
                                table.row(row).remove().draw();
                            });
                        }
                    } catch(error) {
                        console.error("Force delete error: ", error);
                        alert("Failed to remove users from database!");
                    }
                }

                if (e.target.closest('.restore-user')) {
                    const button = e.target.closest('.restore-user');
                    const id = button.dataset.id;
                    const restoreRoute = "{{ route('users.restore', ['id' => '__id__']) }}";

                    if (!confirm('Are you sure want to restore this user?')) return;

                    try {
                        const url = restoreRoute.replace('__id__', id);
                        const response = await fetch(url, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) throw new Error("Restore failed!");

                        const row = $(`tr[data-id="${id}"]`);
                        if (row.length) {
                            row.fadeOut(300, function () {
                                table.row(row).remove().draw();
                            });
                        }

                        // const messageBox = document.querySelector('#message-container');
                        // if (messageBox) {
                        //     messageBox.__x.$data.message = "User successfully restored!";
                        //     messageBox.__x.$data.show = true;

                        //     setTimeout(() => {
                        //         messageBox.__x.$data.show = false;
                        //     }, 3000);
                        // }
                    } catch (error) {
                        console.error('Restore error: ', error);
                        // alert("Failed to restore users!");
                    }
                }
            });
        });
    </script>
@endpush
