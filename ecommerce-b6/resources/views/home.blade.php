<x-template-bootstrap title="Home Page with Component">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center my-4">
                <h1>Welcome to Our Store</h1>
                <p class="lead">Discover our exclusive products below</p>
            </div>
            @foreach($products as $product)
            <div class="col-md-4 mb-1">
                <x-product-card
                    :image="asset($product['image'])"
                    :title="$product['name']"
                    :description="$product['description']"
                    link="{{ route('product-detail', ['id' => $product['id']]) }}"
                ></x-product-card>
            </div>
            @endforeach
        </div>
    </div>
</x-template-bootstrap>