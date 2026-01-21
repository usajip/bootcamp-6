<x-template-bootstrap title="Transaction Status Page with Component">
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
                <p><strong>Status:</strong> {{ $transaction->status }}</p>
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