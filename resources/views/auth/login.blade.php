<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label>Username:</label>
            <input type="text" name="username" maxlength="10" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" maxlength="100" required>
        </div>
        <button type="submit">Login</button>
    </form>
</body>
</html>