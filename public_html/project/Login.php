<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="SQLStyle.css">
</head>
<body>
    <h1>Login</h1>
    <form action="process_login.php" method="post">
        <input type="text" name="name" placeholder="Plumber Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="id" placeholder="Plumber ID" required>
        <label>
            <input type="checkbox" name="include_email"> Include Email
        </label>
        <input type="email" name="email" placeholder="Email (if selected)">
        <button type="submit">Login</button>
    </form>
</body>
</html>
