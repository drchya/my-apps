<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, {{ $user->email }}</h2>
    <p>Your account has been created.</p>
    <p>Password: <strong>{{ $password }}</strong></p>
</body>
</html>
