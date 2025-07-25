<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NusantaraConnect</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Noto+Sans&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f1f1f1;
        }
        .hero-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body class="d-flex flex-column align-items-center justify-content-center min-vh-100">

    <div class="d-flex justify-content-center">
        <div style="width: 100%; max-width: 1200px;">
            <div class="container text-center mb-5">
                <h1 class="display-5 fw-bold">NusantaraConnect</h1>
                <p class="lead text-muted mb-5 italic">
                    Peluang untuk Budaya
                </p>
                @if (Route::has('login'))
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-3 px-4">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-dark rounded-3 px-4">Register</a>
                        @endif
                    </div>
                @endif
            </div>

            
        </div>
    </div>

    

</body>
</html>
