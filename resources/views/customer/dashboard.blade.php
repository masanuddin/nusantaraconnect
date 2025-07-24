<!-- resources/views/vendor/dashboard.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
</head>
<body>
    <h1>Welcome to Customer Dashboard</h1>
        <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-dropdown-link :href="route('logout')"
                onclick="event.preventDefault();
                            this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-dropdown-link>
    </form>
</body>
</html>
