<?php
$title = "Create Produk Admin";

ob_start(); // ⬅️ mirip @section('content')
?>
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h1>Form Input Data Produk</h1>
                <form action="process/input_process.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga Produk</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori Produk</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="" selected disabled>Pilih Kategori</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Pakaian">Pakaian</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <!-- Product Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        //form validation
        let form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            let name = document.getElementById('name').value;
            let price = document.getElementById('price').value;
            let description = document.getElementById('description').value;
            let category = document.getElementById('category').value;
            if (!name || !price || !description || !category) {
                event.preventDefault();
                alert('All fields are required.');
            }
        });
    </script>
<?php
$content = ob_get_clean(); // ⬅️ simpan konten
require __DIR__ . '/../../template/main.php';
?>