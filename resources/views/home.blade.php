<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home page</title>

    <!-- Scripts -->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

</head>
<body>
    <div class="container">
        <button type="button" class="btn btn-primary">Primary</button>
        <button type="button" class="btn btn-link">Link</button>

        <button type="button" class="btn-close" aria-label="Close"></button>

    </div>

</body>
</html>
