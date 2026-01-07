<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-bold mb-2">Nama Produk</label>
                            <input type="text" name="name" value="{{ $product->name }}" id="name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                            <textarea name="description" id="description" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>{{ $product->description }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 font-bold mb-2">Harga</label>
                            <input type="number" name="price" value="{{ $product->price }}" id="price" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" min="0" required>
                        </div>
                        <div class="mb-4">
                            <label for="stock" class="block text-gray-700 font-bold mb-2">Stok</label>
                            <input type="number" name="stock" value="{{ $product->stock }}" id="stock" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" min="0" required>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 font-bold mb-2">Gambar Produk</label>
                            <img src="{{ asset('images/' . $product->image_url) }}" alt="{{ $product->name }}" class="max-w-[200px] object-cover mb-2 rounded">
                            <input type="file" name="image" id="image" accept="image/*" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                        </div>
                        <div id="image-error" class="text-red-500 text-sm mb-4" style="display:none;"></div>
                        <div class="mb-4">
                            <label for="product_category_id" class="block text-gray-700 font-bold mb-2">Kategori Produk</label>
                            <select name="product_category_id" id="product_category_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->product_category_id == $category->id ? 'selected' : '' }}
                                        >{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Batal</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const errorDiv = document.getElementById('image-error');
        imageInput.addEventListener('change', function(e) {
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';
            if (imageInput.files.length > 0) {
                const file = imageInput.files[0];
                const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                const fileExtension = file.name.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(fileExtension)) {
                    e.preventDefault();
                    errorDiv.textContent = 'Ekstensi gambar harus jpg, jpeg, png, gif, atau webp.';
                    errorDiv.style.display = 'block';
                    imageInput.value = '';
                    return;
                }

                if (file.size > 1024 * 1024) { // 1MB
                    e.preventDefault();
                    errorDiv.textContent = 'Ukuran gambar maksimal 1MB.';
                    errorDiv.style.display = 'block';
                    imageInput.value = '';
                }
            }
        });
    });
</script>
@endpush
</x-app-layout>