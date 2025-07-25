<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800;900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Panel</title>
    <style>
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            background-color: #f5f5f5;
        }

        aside {
            width: 220px;
            background: #fff;
            color: #8B4513;
            height: 100vh;
            padding: 20px;
            font-size: 14px; /* Font lebih kecil */
        }

        aside h2 {
            color: #8B4513;
            font-size: 16px; /* Judul kecil */
            margin-bottom: 10px;
        }

        aside h3 {
            color: #8B4513;
            font-size: 14px; /* Subjudul kecil */
            margin-bottom: 20px;
            font-weight: 600;
        }

        aside ul {
            list-style: none;
            padding: 0;
        }

        aside ul li {
            margin: 8px 0;
        }

        aside ul li a {
            color: #8B4513;
            text-decoration: none;
            font-weight: 500;
            font-size: 13px; /* Link lebih kecil */
        }

        aside ul li a:hover {
            color: #5c3d25;
        }

        main {
            flex-grow: 1;
            padding: 20px 40px;
        }

        .logout {
            margin-top: 30px;
        }

        .logout button {
            background: none;
            border: none;
            color: #8B4513;
            cursor: pointer;
            font-weight: 500;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <aside>
        <h2>NusantaraConnect</h2>
        <h3>Vendor Side</h3>
        <ul>
            <li><a href="{{ route('vendor.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('vendor.pekerjaan.index') }}">Kelola Pekerjaan</a></li>
            <li><a href="{{ route('chat.index') }}">Chat</a></li>
        </ul>

        <form method="POST" action="{{ route('logout') }}" class="logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </aside>

    <main>
        @yield('content')
    </main>
</body>
</html>
