<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}">MyWebsite</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        @if(Auth::check() && Auth::user()->role === 'admin')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('product-categories.index') }}">Product Categories</a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ route('cart') }}">Keranjang</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('contact') }}">Contact</a>
        </li>
      </ul>
      @if(Auth::check())
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('profile.edit') }}">Profile</a>
            </li>
            <form class="d-flex" method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-success" type="submit" onclick="confirm('Are you sure you want to logout?')">Logout</button>
            </form>
        </ul>
        @else
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
        </ul>
      @endif
    </div>
  </div>
</nav>