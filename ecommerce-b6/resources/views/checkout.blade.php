<x-template-bootstrap title="Checkout Page with Component">
    <div class="container my-5">
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
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{!! $error !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-12">
                <h2>Checkout</h2>
                <p>This is the checkout page. Implement your checkout process here.</p>
            </div>
            @guest
            <div class="col-12 mt-4">
                <div class="alert alert-warning" role="alert">
                    Please <a href="{{ route('login') }}" class="alert-link">log in</a> to proceed with the checkout.
                </div>
            </div>
            @endguest
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
                                        <div class="text-muted small">Quantity: {{ $item['quantity'] }}</div>
                                    </div>
                                    <div class="text-end ms-3">
                                        <div class="fw-bold fs-5">Rp{{ number_format($item['price'], 0, ',', '.') }}</div>
                                        @if($item['quantity'] > 1)
                                            <div class="text-muted small">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} total</div>
                                        @endif
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

            {{-- Proceed to Payment --}}
            <div class="col-12 mt-4">
                @if(auth()->check() && !empty($cart_items))
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="address" class="form-label">Shipping Address</label>
                        <input type="text" class="form-control" id="address" name="address" required value="{{ auth()->user()->address ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required value="{{ auth()->user()->phone ?? '' }}">
                    </div>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-credit-card me-2"></i> Proceed to Payment
                    </button>
                </form>
                @else
                <button type="button" class="btn btn-success btn-lg" disabled>
                    <i class="bi bi-credit-card me-2"></i> Proceed to Payment
                </button>
                @endif
            </div>
        </div>
    </div>
</x-template-bootstrap>