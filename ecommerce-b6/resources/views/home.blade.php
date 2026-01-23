<x-template-bootstrap title="Home Page with Component">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center my-4">
                <h1>Welcome to Our Store</h1>
                <p class="lead">Discover our exclusive products below</p>
            </div>
            <duv class="col-12">
                <h3 class="mb-4">Filter</h3>
                <form method="GET" action="{{ route('home') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                    </div>
                </form>
            </duv>
            @foreach($products as $item)
            <div class="col-md-4 mb-1">
                <x-product-card
                    :image="$item->image_url"
                    :title="$item->name"
                    :description="$item->description"
                    link="{{ route('product-detail', ['id' => $item->id]) }}"
                    :category="$item->product_category->name"
                    :price="$item->price"
                ></x-product-card>
            </div>
            @endforeach
            <div class="col-12 my-4">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</x-template-bootstrap>