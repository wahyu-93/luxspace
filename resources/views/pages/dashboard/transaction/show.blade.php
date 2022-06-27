<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction &raquo; #{{ $transaction->id }} {{ $transaction->name }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            // aajax datatable
            var datatable = $('#crudTable').dataTable({
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columnDefs:[
                    { className: 'text-center', targets: [0] }
                ],
                columns:[
                    {data: 'id', name: 'id', width: '5%'},
                    {data: 'product.name', name: 'product.name'},
                    {data: 'product.price', name: 'product.price'},
                ]
            })
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-gray-500 mb-5 leading-tight">Transaksi Details</h2>
            <div class="shadow overflow-hidden sm:rounded-mg mb-10">
                <div class="bg-white px-4 py-5 sm:p-6 border-b">
                    <table class="table-auto w-full">
                        <tr>
                            <th class="border px-6 py-2 text-right">Name</th>
                            <td class="border px-6 py-2">{{ $transaction->name }}</td>
                        </tr>

                        <tr>
                            <th class="border px-6 py-2 text-right">Email</th>
                            <td class="border px-6 py-2">{{ $transaction->email }}</td>
                        </tr>

                        <tr>
                            <th class="border px-6 py-2 text-right">Alamat</th>
                            <td class="border px-6 py-2">{{ $transaction->address }}</td>
                        </tr>

                        <tr>
                            <th class="border px-6 py-2 text-right">Telpon</th>
                            <td class="border px-6 py-2">{{ $transaction->phone }}</td>
                        </tr>

                        <tr>
                            <th class="border px-6 py-2 text-right">Kurir</th>
                            <td class="border px-6 py-2">{{ $transaction->courier }}</td>
                        </tr>

                        <tr>
                            <th class="border px-6 py-2 text-right">payment</th>
                            <td class="border px-6 py-2">{{ $transaction->payment }}</td>
                        </tr>

                        <tr>
                            <th class="border px-6 py-2 text-right">Payment URL</th>
                            <td class="border px-6 py-2">{{ $transaction->payment_url }}</td>
                        </tr>

                        <tr>
                            <th class="border px-6 py-2 text-right">Total Harga</th>
                            <td class="border px-6 py-2">{{ number_format($transaction->total_price) }}</td>
                        </tr>

                        <tr>
                            <th class="border px-6 py-2 text-right">Status</th>
                            <td class="border px-6 py-2">{{ $transaction->status }}</td>
                        </tr>
                    </table>
                </div>
            </div>


            <h2 class="font-semibold text-gray-500 mb-5 leading-tight">Transaksi Items</h2>
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Product</th>
                                <th>Harga</th>
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
