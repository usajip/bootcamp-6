<x-template-bootstrap title="Product Detail Page with Component">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('assets/'.$product->image_url) }}" class="img-fluid rounded" alt="Product Image">
            </div>
            <div class="col-md-6">
                <h2 class="mb-3">{{ $product->name }}</h2>
                <p class="text-muted mb-2">Category: <span class="fw-bold">{{ $product->product_category->name }}</span></p>
                <h4 class="text-primary mb-3">Rp{{ number_format($product->price, 0, ',', '.') }}</h4>
                <p>{{ $product->description }}</p>
                <form>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control w-25" id="quantity" value="1" min="1">
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-cart-plus"></i> Add to Cart
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{-- Recommended Products Section --}}
    <div class="container my-5">
        <h3 class="mb-4">Recommended Products</h3>
        <div class="row">
            @foreach($recommendedProducts as $item)
            <div class="col-md-3 mb-4">
                <x-product-card
                    :image="$item->image_url"
                    :title="$item->name"
                    :description="$item->description"
                    link="{{ route('product-detail', ['id' => $item->id]) }}"
                    :category="$item->product_category->name"
                ></x-product-card>
            </div>
            @endforeach
        </div>
    </div>
</x-template-bootstrap>