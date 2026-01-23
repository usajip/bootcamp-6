<x-template-bootstrap title="Transaction Status Page with Component">
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
    <h2>Welcome to the Transaction Status Page</h2>
    <p>This is the content of the transaction status page.</p>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Transaction Details</h5>
            @if(isset($transaction))
                <p><strong>Transaction ID:</strong> {{ $transaction->id }}</p>
                <p><strong>Name</strong> {{ $transaction->name }}</p>
                <p><strong>Address:</strong> {{ $transaction->address }}</p>
                <p><strong>Phone:</strong> {{ $transaction->phone }}</p>
                <p><strong>Total Amount:</strong> Rp{{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <form action="{{ route('transaction.update-status', $transaction->id) }}" method="POST" class="mb-3 d-flex align-items-center" style="gap: 0.5rem;">
                        @csrf
                        <label for="status" class="mb-0"><strong>Status:</strong></label>
                        <select name="status" id="status" class="form-select form-select-sm w-auto mx-2">
                            <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $transaction->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="shipped" {{ $transaction->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </form>
                @else
                    <p><strong>Status:</strong> {{ $transaction->status }}</p>
                @endif
                <div class="card p-4">
                    @foreach($transaction->transaction_items as $item)
                        <div class="d-flex align-items-start {{ $loop->last ? '' : 'border-bottom mb-4 pb-4' }}" style="gap: 1.5rem;">
                            <img src="{{ asset('assets/'.$item->product->image_url) }}" alt="{{ $item->product->name }}" class="rounded" style="width:100px; height:100px; object-fit:cover;">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-1">{{ $item->product->name }}</h5>
                                        <div class="text-muted small mb-1">{{ $item->product->description }}</div>
                                        <div class="text-muted small">Quantity: {{ $item->quantity }}</div>
                                    </div>
                                    <div class="text-end ms-3">
                                        <div class="fw-bold fs-5">Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                        @if($item->quantity > 1)
                                            <div class="text-muted small">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }} total</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- confirmation button --}}
                @php
                    // url confirmation order to whatsapp api
                    $whatsapp_number = '6281234567890'; // replace with your WhatsApp number
                    $message = "Hello, I would like to confirm my order for Transaction ID: " . $transaction->id . ".";
                    $whatsapp_url = "https://wa.me/{$whatsapp_number}?text=" . urlencode($message);
                @endphp
                <a href="{{ $whatsapp_url }}" target="_blank" class="btn btn-primary mt-3">Konfirmasi Pembayaran</a>
            @else
                <p>No transaction details available.</p>
            @endif
        </div>
    </div>
</x-template-bootstrap>