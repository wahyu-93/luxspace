<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            // aajax datatable
            var datatable = $('#crudTable').dataTable({
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columns:[
                    {data: 'id', name: 'id', width: '5%'},
                    {data: 'name', name: 'name'},
                    {data: 'phone', name: 'phone'},
                    {data: 'courier', name: 'courier'},
                    {data: 'total_price', name: 'total_price'},
                    {data: 'status', name: 'status'},

                    {
                        data: 'aksi',
                        name: 'aksi',
                        searchable: false,
                        orderable: false,
                        width: '25%'
                    }
                ]
            })
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-5">
                <a href="{{ route('dashboard.product.create') }}" 
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                    + Create Product
                </a>    
            </div>

            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama</th>
                                <th>Telpon</th>
                                <th>Kurir</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
