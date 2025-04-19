@extends('layouts.main')

@section('content')
    <div class="px-2">
        <div class="flex items-center gap-2">
            <a href="{{ route('gear.create') }}" class="bg-emerald-600 hover:bg-emerald-700 px-2 py-1 rounded text-gray-100 transition duration-300 ease-in-out cursor-pointer">Add Your Gear</a>
        </div>

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
            <table id="gear-table" class="border border-gray-800 shadow-lg rounded overflow-hidden mb-4 w-full">
                <thead class="bg-gray-800">
                    <tr>
                        <th>#</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="gear-table-body">
                    @foreach($gears as $gear)
                        <tr data-id="{{ $gear->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $gear->brand }}</td>
                            <td>Rp{{ number_format($gear->price, 0, ',', '.') }}</td>
                            <td>{{ $gear->category->name }}</td>
                            <td>
                                @php
                                    $badgeClasses = [
                                        'not_purchased'    => 'bg-gray-600 text-gray-100',
                                        'in_wishlist'      => 'bg-gray-700 text-gray-200',
                                        'purchased'        => 'bg-emerald-600 text-white',
                                        'ready_to_use'     => 'bg-blue-500 text-white',
                                        'in_use'           => 'bg-indigo-500 text-white',
                                        'damaged'          => 'bg-red-600 text-white',
                                        'lost'             => 'bg-orange-600 text-white',
                                        'need_replacement' => 'bg-yellow-400 text-black',
                                    ];
                                @endphp

                                <span class="px-2 py-1 rounded text-sm font-medium {{ $badgeClasses[$gear->status->slug] ?? 'bg-gray-500 text-white' }}">
                                    {{ $gear->status->name }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    @php
                                        $encodedGears = json_encode($gear);
                                    @endphp

                                    <button
                                        @click='showModal = true; selected = {!! $encodedGears !!}'
                                        class="w-8 h-8 border border-gray-800 rounded-md focus:outline-none cursor-pointer hover:border-cyan-600 hover:text-cyan-600 transition duration-300 ease-in-out"
                                    >
                                        <i class="fa-solid fa-info"></i>
                                    </button>


                                    @if(Auth::user()->id === 1)
                                        <a href="{{ route('gear.edit', $gear->slug) }}" class="flex items-center justify-center w-8 h-8 border border-gray-800 rounded-md focus:outline-none cursor-pointer hover:border-yellow-600 hover:text-yellow-600 transition duration-300 ease-in-out">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <button class="delete-gear w-8 h-8 border border-gray-800 rounded-md focus:outline-none cursor-pointer hover:border-red-600 hover:text-red-600 transition duration-300 ease-in-out" data-id="{{ $gear->id }}">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- START MODAL SHOW DETAIL GEAR --}}
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

                        <h2 class="text-xl font-semibold mb-4">Gears Details</h2>

                        <template x-if="selected">
                            <div class="space-y-3">
                                <p><strong>Brand:</strong> <span x-text="selected.brand"></span></p>
                                <p><strong>Price:</strong> <span x-text="Number(selected.price).toLocaleString('id-ID') + ' IDR'"></span></p>
                                <p><strong>Type:</strong> <span x-text="selected.type.name"></span></p>
                                <p><strong>Category:</strong> <span x-text="selected.category.name"></span></p>
                                <p><strong>Status:</strong>
                                    <span
                                        x-text="selected.status.name"
                                        :class="{
                                            'bg-gray-600 text-gray-100 px-2 py-1 rounded text-sm font-medium': selected.status.slug === 'not_purchased',
                                            'bg-gray-700 text-gray-200 px-2 py-1 rounded text-sm font-medium': selected.status.slug === 'in_wishlist',
                                            'bg-emerald-600 text-white px-2 py-1 rounded text-sm font-medium': selected.status.slug === 'purchased',
                                            'bg-blue-500 text-white px-2 py-1 rounded text-sm font-medium': selected.status.slug === 'ready_to_use',
                                            'bg-indigo-500 text-white px-2 py-1 rounded text-sm font-medium': selected.status.slug === 'in_use',
                                            'bg-red-600 text-white px-2 py-1 rounded text-sm font-medium': selected.status.slug === 'damaged',
                                            'bg-orange-600 text-white px-2 py-1 rounded text-sm font-medium': selected.status.slug === 'lost',
                                            'bg-yellow-400 text-black px-2 py-1 rounded text-sm font-medium': selected.status.slug === 'need_replacement',
                                        }"
                                    ></span>
                                </p>
                                <!-- Link Product -->
                                <template x-if="selected.link_product">
                                    <a
                                        :href="selected.link_product"
                                        class="text-emerald-400 hover:text-emerald-300 transition duration-300 ease-in-out"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        Link Product
                                    </a>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            {{-- END MODAL SHOW DETAIL GEAR --}}
        </div>
    </div>
@endsection

@push('scripts')
    {{-- DataTables & jQuery --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        let gearsTables;

        document.addEventListener("DOMContentLoaded", function () {
            gearsTables = $('#gear-table').DataTable({
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
                gearsTables.search(this.value).draw();
            });

            // 📄 Custom Length
            $('#customLength').on('change', function () {
                gearsTables.page.len(this.value).draw();
            });

            document.addEventListener('click', async function (e) {
                if (e.target.closest('.delete-gear')) {
                    const button = e.target.closest('.delete-gear');
                    const id = button.dataset.id;
                    const forceDeleteRoute = "{{ route('gear.force.delete', ['id' => '__id__']) }}";

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
                                gearsTables.row(row).remove().draw();
                            });
                        }
                    } catch(error) {
                        console.error("Force delete error: ", error);
                        alert("Failed to remove data from database!");
                    }
                }
            })
        });
    </script>
@endpush
