@extends('layouts.main')

@section('content')
    <div x-data="formHandler()" x-ref="formWrapper">
        <div class="flex items-center gap-2">
            <button @click="showForm = !showForm" class="bg-emerald-600 hover:bg-emerald-700 px-2 py-1 rounded text-gray-100 transition duration-300 ease-in-out cursor-pointer">Create User</button>

            <a href="{{ route('users.recycle') }}" class="bg-red-600 hover:bg-red-700 px-2 py-1 rounded text-gray-100 transition duration-300 ease-in-out cursor-pointer">Recycle Bin</a>
        </div>

        <div x-show="message" x-text="message"
            class="mt-4 text-sm text-green-400"
            x-transition
        ></div>

        <div x-show="showForm" class="mt-4 space-y-4">
            <form @submit.prevent="submitForm" id="user-form" x-ref="formElement" class="bg-gray-700 p-4 rounded">
                <div>
                    <label for="email" class="block text-gray-300 mb-1">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="w-full px-3 py-2 rounded bg-gray-800 text-white text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition duration-300 ease-in-out"
                        required
                        placeholder="Enter Your Email"
                        autocomplete="true"
                        value="{{ old('email') }}"
                    >
                </div>

                <div class="pt-2">
                    <button
                        x-ref="loadingBtn"
                        type="submit"
                        class="
                            bg-emerald-600 hover:bg-emerald-700 px-2 py-1 rounded text-white font-medium transition duration-300 ease-in-out cursor-pointer
                        "
                    >
                        <span x-show="!loading">Save</span>
                        <span x-show="loading">
                            <svg class="inline w-4 h-4 animate-spin mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Saving...
                        </span>
                    </button>
                </div>

                <div x-show="message" x-text="message" class="mt-2 text-sm text-green-400" x-ref="messageBox"></div>
            </form>
        </div>
    </div>

    <hr class="text-gray-800 my-4">

    <div class="overflow-x-auto">
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
                    class="bg-gray-800 border border-gray-600 text-gray-300 rounded px-2 py-1 focus:border-emerald-600 focus:outline-none transition duration-300 ease-in-out"
                    autocomplete="true"
                >
            </div>
        </div>

        <table id="users-table" class="border border-gray-800 shadow-lg rounded overflow-hidden mb-4">
            <thead class="bg-gray-800">
                <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="users-table-body">
                @forelse ($users as $user)
                    <tr data-id="{{ $user->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="hidden lg:inline">
                                {{ $user->created_at->translatedFormat('l, d F Y - H:i:s') }}
                            </span>

                            <span class="inline lg:hidden">
                                {{ $user->created_at->translatedFormat('l, d F Y') }}
                            </span>
                        </td>
                        <td>
                            @if($user->id !== auth()->id())
                                <button class="delete-user text-red-500 hover:text-red-700 transition duration-300 ease-in-out cursor-pointer" data-id="{{ $user->id }}">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            @else
                                <span class="text-emerald-500 italic text-xs">You</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-2">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    {{-- DataTables & jQuery --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        let usersTable;

        document.addEventListener("DOMContentLoaded", function () {
            usersTable = $('#users-table').DataTable({
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
                usersTable.search(this.value).draw();
            });

            // 📄 Custom Length
            $('#customLength').on('change', function () {
                usersTable.page.len(this.value).draw();
            });

            document.addEventListener('click', async function (e) {
                if (e.target.closest('.delete-user')) {
                    const button = e.target.closest('.delete-user');
                    const id = button.dataset.id;

                    if (!confirm('Are you sure want to delete this user?')) return;

                    try {
                        const response = await fetch(`/users/${id}`, {
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

        function formHandler() {
            return {
                showForm: false,
                loading: false,
                message: '',
                async submitForm(event) {
                    const formEl = event.target;
                    const email = formEl.querySelector('#email').value;

                    this.loading = true;
                    this.message = '';

                    try {
                        const response = await fetch("{{ route('users.store') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: new URLSearchParams({ email })
                        });

                        if (!response.ok) throw new Error("Request failed");

                        const data = await response.json();
                        formEl.reset();
                        this.message = data.message || "User has been created! Password has been sending to email.";
                        setTimeout(() => this.message = '', 5000);

                        this.showForm = false;
                        const newRow = usersTable.row.add([
                            '',
                            data.user.email,
                            data.user.created_at,
                            '<button><i class="fa-regular fa-trash-can"></i></button>'
                        ]).draw(false).node();

                        usersTable.order([2, 'desc']).draw();
                        $(newRow).hide().fadeIn(600);
                    } catch (error) {
                        console.error("Form submission error:", error);
                        this.message = "Something went wrong!";
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
@endpush
