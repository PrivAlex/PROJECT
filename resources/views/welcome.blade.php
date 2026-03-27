<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>

@guest
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="email" name="email">
        <input type="password" name="password">

        <button type="submit">Login</button>
    </form>
@endguest


@auth
    <p>Вы вошли как {{ auth()->user()->email }}</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endauth

</body>
</html>
