<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Panel</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            display: flex;
        }
        aside {
            width: 220px;
            background: #333;
            color: #fff;
            height: 100vh;
            padding: 20px;
        }
        aside h2 {
            color: #f0f0f0;
            margin-bottom: 20px;
        }
        aside ul {
            list-style: none;
            padding: 0;
        }
        aside ul li {
            margin: 10px 0;
        }
        aside ul li a {
            color: #ccc;
            text-decoration: none;
        }
        aside ul li a:hover {
            color: #fff;
        }
        main {
            flex-grow: 1;
            padding: 20px;
        }
        .logout {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <aside>
        <h2>Vendor</h2>
        <ul>
            <li><a href="{{ route('vendor.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('vendor.pekerjaan.index') }}">Kelola Pekerjaan</a></li>
        </ul>

        <form method="POST" action="{{ route('logout') }}" class="logout">
            @csrf
            <button type="submit" style="background:none;border:none;color:#ccc;cursor:pointer;">
                Logout
            </button>
        </form>
    </aside>

    <main>
        @yield('content')
    </main>
</body>
</html>
