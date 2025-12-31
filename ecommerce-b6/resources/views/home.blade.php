<x-template-bootstrap title="Home Page with Component">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center my-4">
                <h1>Welcome to Our Store</h1>
                <p class="lead">Discover our exclusive products below</p>
            </div>
            @foreach($products as $item)
            <div class="col-md-4 mb-1">
                <x-product-card
                    :image="$item->image_url"
                    :title="$item->name"
                    :description="$item->description"
                    link="{{ route('product-detail', ['id' => $item->id]) }}"
                    :category="$item->product_category->name"
                ></x-product-card>
            </div>
            @endforeach
            <div class="col-12 my-4">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</x-template-bootstrap>