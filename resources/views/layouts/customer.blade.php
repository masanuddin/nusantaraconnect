<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Area</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }

        nav {
            background-color: #333;
            padding: 10px 20px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: #fff;
            margin-right: 15px;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logout-form {
            display: inline;
        }

        main {
            padding: 20px;
        }
    </style>
</head>
<body>

    <nav>
        <div>
            <a href="{{ route('customer.dashboard') }}">Dashboard</a>
            <a href="{{ route('customer.pekerjaan') }}">Lihat Pekerjaan</a>
            <a href="{{ route('customer.chatbot') }}">Chat dengan Asisten</a>
            <a href="{{ route('customer.lamaran.index') }}">Lihat Lamaran</a>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" style="background: none; border: none; color: #fff; cursor: pointer;">
                Logout
            </button>
        </form>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
