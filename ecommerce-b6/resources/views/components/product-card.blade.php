<div class="card">
  <img src="{{ asset('images/' . $image) }}" class="card-img-top img-fluid" alt="...">
  <div class="card-body">
    <span class="badge rounded-pill text-bg-primary mb-1">{{ $category }}</span>
    <h5 class="card-title">{{ $title }}</h5>
    <p class="card-text">{{ $description }}</p>
    <a href="{{ $link }}" class="btn btn-primary">Lihat Detail</a>
  </div>
</div>