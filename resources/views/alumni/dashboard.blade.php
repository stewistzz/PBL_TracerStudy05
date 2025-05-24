<!DOCTYPE html>
<html>
<head>
    <title>Alumni Dashboard</title>
</head>
<body>
    <h1>Welcome, Alumni!</h1>
    <p>You are logged in as {{ Auth::user()->username }}</p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>