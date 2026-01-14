<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-bold">Daftar Produk</h3>
                        <a href="{{ route('products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            + Tambah Produk
                        </a>
                    </div>
                    <table class="w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Nama</th>
                                <th class="py-2 px-4 border-b">Deskripsi</th>
                                <th class="py-2 px-4 border-b">Harga</th>
                                <th class="py-2 px-4 border-b">Stok</th>
                                <th class="py-2 px-4 border-b">Gambar</th>
                                <th class="py-2 px-4 border-b">Kategori</th>
                                <th class="py-2 px-4 border-b">Total trx</th>
                                <th class="py-2 px-4 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $product->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $product->description }}</td>
                                    <td class="py-2 px-4 border-b">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4 border-b">{{ $product->stock }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @if($product->image_url)
                                            <img src="{{ asset('images/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b">{{ $product->product_category->name ?? 'Uncategorized' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $product->transaction_items_count }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('products.edit', $product->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded mr-2">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin ingin menghapus kategori ini?')" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-2 px-4 text-center">Tidak ada produk ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">
    @endpush
    @push('scripts')
        {{-- --}}
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="//cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>
        <script>
            let table = new DataTable('#myTable');
        </script>
    @endpush
</x-app-layout>
