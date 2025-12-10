
// Data Produk
const allProducts = [
    {
        id: 1,
        nama: "Kemeja Flanel Premium",
        harga: 185000,
        deskripsi: "Kemeja flanel lembut dengan motif kotak-kotak klasik. Bahan katun adem, cocok untuk santai atau semi-formal.",
        gambar: "https://placehold.co/400x200/4f46e5/ffffff?text=Kemeja",
        kategori: "Pakaian",
    },
    {
        id: 2,
        nama: "Sneakers Kulit Putih",
        harga: 350000,
        deskripsi: "Sepatu sneakers minimalis dari kulit sintetis berkualitas. Sol karet anti slip, nyaman dipakai seharian.",
        gambar: "https://placehold.co/400x200/22c55e/ffffff?text=Sepatu",
        kategori: "Alas Kaki",
    },
    {
        id: 3,
        nama: "Headset Bluetooth Stereo",
        harga: 420000,
        deskripsi: "Headset nirkabel dengan kualitas suara jernih dan bass mendalam. Baterai tahan lama hingga 20 jam.",
        gambar: "https://placehold.co/400x200/ef4444/ffffff?text=Elektronik",
        kategori: "Elektronik",
    },
    {
        id: 4,
        nama: "Buku Novel Fiksi Fantasi",
        harga: 95000,
        deskripsi: "Novel best-seller dengan kisah fantasi epik dan alur cerita yang tak terduga. Wajib koleksi!",
        gambar: "https://placehold.co/400x200/f97316/ffffff?text=Buku",
        kategori: "Buku",
    },
    {
        id: 5,
        nama: "Jam Tangan Chronograph",
        harga: 780000,
        deskripsi: "Jam tangan analog premium dengan fitur chronograph dan tali kulit asli. Tahan air hingga 50m.",
        gambar: "https://placehold.co/400x200/10b981/ffffff?text=Aksesoris",
        kategori: "Aksesoris",
    },
    {
        id: 6,
        nama: "T-shirt Oversize Motif Grafis",
        harga: 120000,
        deskripsi: "Kaos katun 100% dengan potongan oversize. Desain grafis unik di bagian belakang.",
        gambar: "https://placehold.co/400x200/4f46e5/ffffff?text=Kaos",
        kategori: "Pakaian",
    },
    {
        id: 7,
        nama: "Laptop Ultra Slim 14 Inci",
        harga: 8990000,
        deskripsi: "Laptop tipis dan ringan, performa cepat dengan prosesor terbaru. Layar Full HD.",
        gambar: "https://placehold.co/400x200/ef4444/ffffff?text=Laptop",
        kategori: "Elektronik",
    },
    {
        id: 8,
        nama: "Sandal Jepit Casual",
        harga: 45000,
        deskripsi: "Sandal jepit santai dengan bahan karet yang elastis dan anti licin. Tersedia berbagai warna.",
        gambar: "https://placehold.co/400x200/22c55e/ffffff?text=Sandal",
        kategori: "Alas Kaki",
    },
    {
        id: 9,
        nama: "Kalung Perak Minimalis",
        harga: 210000,
        deskripsi: "Kalung perak 925 dengan liontin kecil berbentuk geometris. Cocok untuk hadiah.",
        gambar: "https://placehold.co/400x200/10b981/ffffff?text=Perhiasan",
        kategori: "Aksesoris",
    },
    {
        id: 10,
        nama: "Buku Resep Masakan Nusantara",
        harga: 110000,
        deskripsi: "Kumpulan resep masakan tradisional dari seluruh Indonesia, dilengkapi foto dan tips.",
        gambar: "https://placehold.co/400x200/f97316/ffffff?text=Resep",
        kategori: "Buku",
    },
];

// Mendapatkan elemen DOM yang dibutuhkan
const productList = document.getElementById('product-list');
const categorySelect = document.getElementById('category-select');
const searchInput = document.getElementById('search-input');
const sortSelect = document.getElementById('sort-select');
const noProductsMessage = document.getElementById('no-products-message');

// Fungsi untuk memformat harga menjadi mata uang Rupiah (IDR)
function formatRupiah(number) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);
}

// Fungsi untuk mengisi opsi kategori pada dropdown filter
function populateCategories() {
    // Ambil kategori unik dari data produk
    const categories = [...new Set(allProducts.map(p => p.kategori))];
    
    // Buat opsi-opsi dropdown
    categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category;
        option.textContent = category;
        categorySelect.appendChild(option);
    });
}

// Fungsi utama untuk menampilkan produk (dengan filter dan urutan)
function renderProduk(productsToRender) {
    productList.innerHTML = ''; // Kosongkan tampilan produk sebelumnya

    if (productsToRender.length === 0) {
        noProductsMessage.classList.remove('d-none');
        return;
    } else {
        noProductsMessage.classList.add('d-none');
    }

    // Loop untuk setiap produk dan buat Card Bootstrap
    productsToRender.forEach(product => {
        const cardCol = document.createElement('div');
        cardCol.classList.add('col');

        cardCol.innerHTML = `
            <div class="card h-100 product-card shadow-sm">
                <img src="${product.gambar}" class="card-img-top product-image" alt="Gambar ${product.nama}" onerror="this.onerror=null; this.src='https://placehold.co/400x200/cccccc/333333?text=Tidak+Tersedia';">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-lg font-semibold text-gray-800">${product.nama}</h5>
                    <p class="text-sm text-indigo-600 font-medium mb-1">${product.kategori}</p>
                    <p class="card-text text-sm text-gray-500 mb-3 flex-grow-1">${product.deskripsi}</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <h4 class="text-xl font-bold text-gray-900">${formatRupiah(product.harga)}</h4>
                        <a href="#" class="btn btn-primary-custom rounded-full px-4 py-2 text-sm font-medium">Beli</a>
                    </div>
                </div>
            </div>
        `;
        productList.appendChild(cardCol);
    });
}

// Fungsi untuk menerapkan semua filter dan pengurutan
function filterProduk() {
    let filteredProducts = [...allProducts]; // Salin array produk asli

    // 1. Filter Kategori
    const selectedCategory = categorySelect.value;
    if (selectedCategory !== 'Semua') {
        filteredProducts = filteredProducts.filter(product => product.kategori === selectedCategory);
    }

    // 2. Filter Pencarian Nama
    const searchTerm = searchInput.value.toLowerCase().trim();
    if (searchTerm) {
        filteredProducts = filteredProducts.filter(product =>
            product.nama.toLowerCase().includes(searchTerm)
        );
    }

    // 3. Urutkan Harga
    const sortOrder = sortSelect.value;
    if (sortOrder === 'low-to-high') {
        filteredProducts.sort((a, b) => a.harga - b.harga); // Termurah ke Termahal
    } else if (sortOrder === 'high-to-low') {
        filteredProducts.sort((a, b) => b.harga - a.harga); // Termahal ke Termurah
    }

    // Tampilkan produk yang sudah difilter/diurutkan
    renderProduk(filteredProducts);
}

// Fungsi untuk mereset semua filter
function resetFilter() {
    categorySelect.value = 'Semua';
    searchInput.value = '';
    sortSelect.value = 'none';
    filterProduk(); // Terapkan filter yang sudah direset
}

// Inisialisasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    populateCategories(); // Isi opsi kategori
    renderProduk(allProducts); // Tampilkan semua produk pertama kali
});
