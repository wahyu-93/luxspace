<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Prodcut &raquo; {{ $product->name }} &raquo; Galery 
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
                    {data: 'url', name: 'url'},
                    {data: 'is_featured', name: 'is_featured', width: '15%'},
                    {
                        data: 'aksi',
                        name: 'aksi',
                        searchable: false,
                        orderable: false,
                        width: '5%'
                    }
                ]
            })
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-5">
                <a href="{{ route('dashboard.product.galery.create', $product->id) }}" 
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">
                    + Upload Photos
                </a>    
            </div>

            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>URL</th>
                                <th>isFeatured</th>
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
