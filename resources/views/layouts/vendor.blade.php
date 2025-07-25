<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800;900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/customer_navbar.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Noto+Sans&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            background-color: #fff;
            color: #8B4513;
            height: 100vh;
            padding: 24px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid #e0e0e0;
        }

        .brand {
            margin-bottom: 30px;
        }

        .brand h2 {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 6px 0;
            color: #8B4513;
        }

        .brand h3 {
            font-size: 13px;
            font-weight: 600;
            margin: 0;
            color: #8B4513;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        nav ul li a {
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            color: #8B4513;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background-color 0.2s, color 0.2s;
            display: block;
        }

        nav ul li a:hover {
            background-color: #f4e5dc;
            color: #5c3d25;
        }

        .logout {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .logout button {
            background: none;
            border: none;
            color: #8B4513;
            cursor: pointer;
            font-weight: 500;
            font-size: 13px;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background-color 0.2s, color 0.2s;
            width: 100%;
            text-align: left;
        }

        .logout button:hover {
            background-color: #f4e5dc;
            color: #5c3d25;
        }

        main {
            flex-grow: 1;
            padding: 32px 48px;
        }
    </style>
</head>
<body>
    <aside>
        <div class="d-flex flex-column justify-between h-100" style="height: 100%;">
            <div>
                <div class="brand">
                    <h2>NusantaraConnect</h2>
                    <h3>Vendor Side</h3>
                </div>

                <nav>
                    <ul>
                        <li><a href="{{ route('vendor.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('vendor.pekerjaan.index') }}">Kelola Pekerjaan</a></li>
                        <li><a href="{{ route('chat.index') }}">Chat</a></li>
                    </ul>
                </nav>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="logout">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </aside>


    <main>
        @yield('content')
    </main>
</body>
</html>
