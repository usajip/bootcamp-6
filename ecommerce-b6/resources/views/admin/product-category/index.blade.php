<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-success-error-info />
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-bold">Daftar Kategori Produk</h3>
                        <!-- Button trigger modal -->
                        <button type="button" onclick="openModal()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                            + Tambah Kategori
                        </button>

                        <!-- Modal -->
                        <div id="addCategoryModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                            <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
                                <div class="flex justify-between items-center border-b px-4 py-2">
                                    <h4 class="text-lg font-bold">Tambah Kategori Produk</h4>
                                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                                </div>
                                <form action="{{ route('product-categories.store') }}" method="POST" class="px-6 py-4">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-gray-700 font-bold mb-2" for="name">Nama</label>
                                        <input type="text" name="name" id="name" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" 
                                        value="{{ old('name') }}"
                                        minlength="5"
                                        maxlength="100"
                                        >
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 font-bold mb-2" for="description">Deskripsi</label>
                                        <textarea name="description" id="description" rows="3" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="button" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</button>
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @push('scripts')
                        <script>
                            function openModal() {
                                document.getElementById('addCategoryModal').classList.remove('hidden');
                            }
                            function closeModal() {
                                document.getElementById('addCategoryModal').classList.add('hidden');
                            }
                            // Validasi panjang nama kategori
                            document.getElementById('name').addEventListener('input', function() {
                                if (this.value.replace(/\s/g, '').length < 5) {
                                    this.setCustomValidity('Nama kategori harus memiliki minimal 5 karakter (tidak termasuk spasi).');
                                } else {
                                    this.setCustomValidity('');
                                }
                            });
                        </script>
                        @endpush
                    </div>
                    <table class="w-full bg-white border" id="myTable">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">ID</th>
                                <th class="py-2 px-4 border-b">Nama</th>
                                <th class="py-2 px-4 border-b">Deskripsi</th>
                                <th class="py-2 px-4 border-b">Jumlah Produk</th>
                                <th class="py-2 px-4 border-b">Jumlah Stok</th>
                                <th class="py-2 px-4 border-b">Total Harga Produk</th>
                                <th class="py-2 px-4 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productCategories as $category)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $category->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $category->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $category->description ?? '-' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $category->products_count }}</td>
                                    <td class="py-2 px-4 border-b">{{ $category->total_stock ?? 0 }}</td>
                                    <td class="py-2 px-4 border-b">Rp {{ number_format($category->total_price * $category->total_stock ?? 0, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <button type="button" onclick="openEditModal({{ $category->id }})" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded mr-2">Edit</button>

                                        <!-- Edit Modal -->
                                        <div id="editCategoryModal-{{ $category->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                                            <div class="bg-white rounded-lg shadow-lg w-full max-w-md">
                                                <div class="flex justify-between items-center border-b px-4 py-2">
                                                    <h4 class="text-lg font-bold">Edit Kategori Produk</h4>
                                                    <button type="button" onclick="closeEditModal({{ $category->id }})" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                                                </div>
                                                <form action="{{ route('product-categories.update', $category->id) }}" method="POST" class="px-6 py-4">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 font-bold mb-2" for="edit-name-{{ $category->id }}">Nama</label>
                                                        <input type="text" name="name" id="edit-name-{{ $category->id }}" value="{{ $category->name }}" required class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="block text-gray-700 font-bold mb-2" for="edit-description-{{ $category->id }}">Deskripsi</label>
                                                        <textarea name="description" id="edit-description-{{ $category->id }}" rows="3" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">{{ $category->description }}</textarea>
                                                    </div>
                                                    <div class="flex justify-end">
                                                        <button type="button" onclick="closeEditModal({{ $category->id }})" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</button>
                                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        @push('scripts')
                                        <script>
                                            function openEditModal(id) {
                                                document.getElementById('editCategoryModal-' + id).classList.remove('hidden');
                                            }
                                            function closeEditModal(id) {
                                                document.getElementById('editCategoryModal-' + id).classList.add('hidden');
                                            }
                                        </script>
                                        @endpush
                                        <form action="{{ route('product-categories.destroy', $category->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin ingin menghapus kategori ini?')" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-2 px-4 text-center">Tidak ada kategori ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
