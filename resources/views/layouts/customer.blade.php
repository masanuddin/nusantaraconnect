<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Area</title>
    <link rel="stylesheet" href="{{ asset('css/customer_navbar.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Noto+Sans&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <div style="background-color: white" class="d-flex justify-content-center">
        <div style="width: 100%; max-width: 1200px;">
            <div class="d-flex justify-content-between align-items-center py-3">
                <div>
                    <a style="text-decoration: none" class="coklatColor fs-5 fw-bold" href="">NusantaraConnect</a>
                </div>
                <div>
                    <a style="text-decoration: underline !important" class="coklatColor me-3" href="{{ route('customer.pekerjaan') }}">Bingung mau kerja apa?</a>
                    <a class="coklatColor me-3" href="{{ route('customer.dashboard') }}">Beranda</a>
                    <a class="coklatColor me-3" href="{{ route('customer.chatbot') }}">AI Chatbot</a>
                    <a class="coklatColor me-3" href="{{ route('customer.lamaran.index') }}">Lihat Lamaran</a>
                    <a class="coklatColor" href="{{ route('chat.index') }}">Chat</a>
                    <div class="dropdown d-inline-block ms-3">
                        <a href="#" class="dropdown-toggle coklatColor text-decoration-none" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item coklatColor" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item coklatColor">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    {{-- <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #632e2e; cursor: pointer;">
                            Logout
                        </button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>

    <main>
        @yield('content')
    </main>

</body>
</html>
