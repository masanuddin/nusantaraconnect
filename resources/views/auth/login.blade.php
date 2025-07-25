<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - NusantaraConnect</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f1f1f1;
        }
        .card-login {
            background-color: #fff;
            border-radius: 1rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            padding: 2.5rem;
        }
        .form-control:focus {
            border-color: #000;
            box-shadow: none;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center min-vh-100">

    <div class="container" style="max-width: 420px;">
        <div class="card-login">

            <h2 style="color: #8B4513" class="text-center fw-bold mb-2">Login</h2>
            <p class="text-center text-muted mb-4">Masuk ke akun NusantaraConnect Anda</p>

            @if (session('status'))
                <div class="alert alert-success text-center py-2">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" required class="form-control @error('password') is-invalid @enderror">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label text-muted" for="remember">
                        Remember Me
                    </label>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none text-sm text-muted" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif

                    <button type="submit" style="background-color: #8B4513; color: #fff !important;" class="btn px-4">
                        Login
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
