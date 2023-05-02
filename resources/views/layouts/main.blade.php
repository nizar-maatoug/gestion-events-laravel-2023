<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ $description ?? '' }}">
    <title>{{$title}}</title>

    <!-- Scripts and CSS-->
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="container-fluid mh-100" style="height: 100vh">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{route('home')}}">{{$heading}}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('home')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Events</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div style="min-height: 50vh">
            <main>
                @yield('content')

            </main>

        </div>

        <footer class="footer mt-auto py-3 bg-light">
            <div class="container">
                <p class="text-center">
                    <span class="text-muted text-center">Copyright &copy; 2023 ISET Bizerte DSI22</span>
                </p>


            </div>
        </footer>
    </div>

</body>
</html>
