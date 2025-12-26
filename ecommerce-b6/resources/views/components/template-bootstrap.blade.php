<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    {{-- Bootstrap css cdn --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    @stack('styles')
</head>
<body>
    @include('template.navbar')
    <main class="container" style="min-height: 100vh;">
        {{ $slot }}
    </main>
    @include('template.footer')
    {{-- Bootstrap js cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoA6V6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>