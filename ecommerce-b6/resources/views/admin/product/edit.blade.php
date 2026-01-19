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
                    <x-success-error-info />
                    <form action="{{ route('products.update', $product->id) }}" method="POST" id="formUpload">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-bold mb-2">Nama Produk</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" id="name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                            <textarea name="description" id="description" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 font-bold mb-2">Harga</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" id="price" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" min="0" required>
                        </div>
                        <div class="mb-4">
                            <label for="stock" class="block text-gray-700 font-bold mb-2">Stok</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" id="stock" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" min="0" required>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 font-bold mb-2">Gambar Produk</label>
                            <img src="{{ asset('assets/' . $product->image_url) }}" alt="{{ $product->name }}" class="max-w-[200px] object-cover mb-2 rounded">
                            <input type="file" id="uploadImage" accept="image/*">

                            <div id="croppieContainer" style="width: 100%; max-width: 600px;"></div>

                            <input type="hidden" name="image" id="imageResult">
                            <div id="image-error" class="text-red-500 text-sm mb-4" style="display:none;"></div>
                        </div>
                        <div id="image-error" class="text-red-500 text-sm mb-4" style="display:none;"></div>
                        <div class="mb-4">
                            <label for="product_category_id" class="block text-gray-700 font-bold mb-2">Kategori Produk</label>
                            <select name="product_category_id" id="product_category_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}
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
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/croppie/croppie.css" />
<script src="https://unpkg.com/croppie/croppie.js"></script>
@endpush
@push('scripts')
<script>
let croppie = new Croppie(document.getElementById('croppieContainer'), {
    viewport: {
        width: 320,
        height: 180, // 16:9
        type: 'rectangle'
    },
    boundary: {
        width: 350,
        height: 250
    },
    enableExif: true
});

const allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
const maxSize = 1024 * 1024; // 1MB
let imageSelected = false;

document.getElementById('uploadImage').addEventListener('change', function (e) {
    const file = e.target.files[0];

    if (!file) {
        imageSelected = false;
        return;
    }

    // Validasi ukuran
    if (file.size > maxSize) {
        alert('Ukuran gambar maksimal 1MB');
        e.target.value = '';
        imageSelected = false;
        return;
    }

    // Validasi ekstensi
    const extension = file.name.split('.').pop().toLowerCase();
    if (!allowedExtensions.includes(extension)) {
        alert('Format gambar harus JPG, JPEG, PNG, atau WEBP');
        e.target.value = '';
        imageSelected = false;
        return;
    }

    // Load ke croppie
    const reader = new FileReader();
    reader.onload = function (event) {
        croppie.bind({
            url: event.target.result
        });
        imageSelected = true;
    };
    reader.readAsDataURL(file);
});
</script>

<script>
document.getElementById('formUpload').addEventListener('submit', function (e) {
    e.preventDefault();

    // Only process image if a new one was selected
    if (imageSelected) {
        croppie.result({
            type: 'base64',
            size: { width: 1280, height: 720 },
            format: 'webp',
            quality: 90
        }).then(function (base64) {

            // Estimasi ukuran base64
            const sizeInBytes = (base64.length * 3) / 4;
            if (sizeInBytes > maxSize) {
                alert('Hasil gambar melebihi 1MB, kurangi kualitas');
                return;
            }

            document.getElementById('imageResult').value = base64;
            e.target.submit();
        });
    } else {
        // No image selected, submit form without image data
        e.target.submit();
    }
});
</script>


<script>
    // Validasi panjang nama kategori
    document.getElementById('name').addEventListener('input', function() {
        if (this.value.replace(/\s/g, '').length < 5) {
            this.setCustomValidity('Nama produk harus memiliki minimal 5 karakter (tidak termasuk spasi).');
        } else {
            this.setCustomValidity('');
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const errorDiv = document.getElementById('image-error');
        const preview = document.getElementById('image-preview');
        imageInput.addEventListener('change', function(e) {
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';
            if (imageInput.files.length > 0) {
                const file = imageInput.files[0];
                const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                const fileExtension = file.name.split('.').pop().toLowerCase();
                let error = false;

                if (!allowedExtensions.includes(fileExtension)) {
                    e.preventDefault();
                    errorDiv.textContent = 'Ekstensi gambar harus jpg, jpeg, png, gif, atau webp.';
                    errorDiv.style.display = 'block';
                    imageInput.value = '';
                    error = true;
                    return;
                }

                if (file.size > 1024 * 1024) { // 1MB
                    e.preventDefault();
                    errorDiv.textContent = 'Ukuran gambar maksimal 1MB.';
                    errorDiv.style.display = 'block';
                    imageInput.value = '';
                    error = true;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    if (allowedExtensions.includes(fileExtension) && !error) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    } else {
                        preview.src = '#';
                        preview.style.display = 'none';
                    }
                    console.log('File selected:', file.name);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
</x-app-layout>