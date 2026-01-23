<div class="card">
  <img src="{{ asset('assets/' . $image) }}" class="card-img-top img-fluid" alt="...">
  <div class="card-body">
    <span class="badge rounded-pill text-bg-primary mb-1">{{ $category }}</span>
    <h5 class="card-title">{{ $title }}</h5>
    <p class="card-text">{{ $description }}</p>
    <p class="card-text fw-bold">Rp{{ number_format($price, 0, ',', '.') }}</p>
    <a href="{{ $link }}" class="btn btn-primary">Lihat Detail</a>
  </div>
</div>