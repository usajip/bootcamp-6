<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'E-Commerce B6')</title>
    {{-- Bootstrap css cdn --}}
    <link href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    @include('template.navbar')
    <main class="container" style="min-height: 100vh;">
        @yield('content')
    </main>
    @include('template.footer')
    {{-- Bootstrap js cdn --}}
    <script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>