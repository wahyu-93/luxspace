<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product &raquo; {{ $product->name }} &raquo; Edit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                {{-- alert --}}
                @if($errors->any())
                    <div class="mb-5" role="alert">
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            There's something wrong
                        </div>
                        <div class="border border-t-0 border-red-400 rounded-b px-4 py-3 bg-red-100 text-red-700">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
            {{-- end alert --}}

            {{-- form --}}
            <form action="{{ route('dashboard.product.update', $product->id) }}" method="post" enctype="multipart/form-data" class="w-full">
                @csrf
                @method('PUT')
                
                <div class="flex flex-wrap mb-4 -mx-3">
                    <div class="w-full px-3">
                        <label for="name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name') ?? $product->name  }}" placeholder="Product Name" 
                            class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    </div>
                </div>

                <div class="flex flex-wrap mb-4 -mx-3">
                    <div class="w-full px-3">
                        <label for="description" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Description</label>
                        <textarea type="text" name="description" placeholder="description product" 
                            class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">{{ old('description') ?? $product->description }}</textarea>
                    </div>
                </div>

                <div class="flex flex-wrap mb-4 -mx-3">
                    <div class="w-full px-3">
                        <label for="price" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Price</label>
                        <input type="number" name="price" value="{{ old('price') ?? $product->price}}" placeholder="Product price" 
                            class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    </div>
                </div>

                <div class="flex flex-wrap mb-4 -mx-3">
                    <div class="w-full px-3">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 shadow-lg rounded">Update Product</button>
                    </div>
                </div>

            </form>
            {{-- endform --}}
        </div>   
    </div>
    <script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
</x-app-layout>
