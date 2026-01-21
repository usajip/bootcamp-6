<x-template-bootstrap title="Cart Page with Component">
     <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
                @endif
            </div>
            <div class="col-12 my-4">
                <h2>Cart Items</h2>
                @if(!empty($cart_items))
                    <div class="card p-4">
                        <h5 class="mb-4">
                            <i class="bi bi-bag me-2"></i> Shopping Cart ({{ count($cart_items) }} items)
                        </h5>
                        @foreach($cart_items as $id => $item)
                            <div class="d-flex align-items-start {{ $loop->last ? '' : 'border-bottom mb-4 pb-4' }}" style="gap: 1.5rem;">
                                <img src="{{ $item['image_url'] ?? 'https://via.placeholder.com/100' }}" alt="{{ $item['name'] }}" class="rounded" style="width:100px; height:100px; object-fit:cover;">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h5 class="mb-1">{{ $item['name'] }}</h5>
                                            <div class="text-muted small mb-1">{{ $item['description'] }}</div>
                                                <form method="POST" action="{{ route('cart.update', $item['id']) }}" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group input-group-sm w-auto align-items-center">
                                                        <button class="btn btn-outline-secondary" onclick="event.preventDefault(); updateQuantity({{ $item['id'] }}, 'decrement');" name="action" value="decrement" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                                                        <input type="text" name="quantity" id="quantity-{{ $item['id'] }}" class="form-control text-center" value="{{ $item['quantity'] }}" style="width: 40px;" readonly>
                                                        <button class="btn btn-outline-secondary" onclick="event.preventDefault(); updateQuantity({{ $item['id'] }}, 'increment');" name="action" value="increment">+</button>
                                                        <button class="btn btn-primary ms-2" type="submit" name="action" value="update">Update</button>
                                                    </div>
                                                </form>
                                        </div>
                                        <div class="text-end ms-3">
                                            <div class="fw-bold fs-5">Rp{{ number_format($item['price'], 0, ',', '.') }}</div>
                                            @if($item['quantity'] > 1)
                                                <div class="text-muted small">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} total</div>
                                            @endif
                                            <a href="{{ route('cart.remove', $item['id']) }}" onclick="return confirm('Are you sure you want to remove this item from the cart?')" class="d-block mt-2 text-danger text-decoration-none">
                                                <i class="bi bi-trash me-1"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>Your cart is empty.</p>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Continue Shopping</a>
                @endif
            </div>
            <div class="col-12 mb-5 d-flex justify-content-between align-items-center">
                <h5 class="mb-4">Cart Summary</h5>
                <div>
                    <h6>Items: {{ count($cart_items) }}</h6>
                    <h4>Total: 
                        Rp{{ number_format(collect($cart_items)->reduce(function ($carry, $item) {
                            return $carry + ($item['price'] * $item['quantity']);
                        }, 0), 0, ',', '.') }}
                    </h4>
                </div>
            </div>
            <div class="col-12 mb-5">
                <a href="{{ url('/checkout') }}" class="btn btn-primary">Checkout</a>
            </div>
        </div>
     </div>
<script>
    function updateQuantity(productId, action) {
        const quantityInput = document.getElementById('quantity-' + productId);
        let currentQuantity = parseInt(quantityInput.value);
        if (action === 'increment') {
            currentQuantity += 1;
        } else if (action === 'decrement' && currentQuantity > 1) {
            currentQuantity -= 1;
        }
        quantityInput.value = currentQuantity;
    }
</script>
</x-template-bootstrap>