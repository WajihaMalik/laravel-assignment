<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New User Registered</title>
</head>
<body>
    <h1>New User Registration</h1>
    <p>A new user has registered with the following details:</p>
    <ul>
        <li>Name: {{ $user->name }}</li>
        <li>Email: {{ $user->email }}</li>
    </ul>
</body>
</html>