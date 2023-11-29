<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany i ma rolę administratora
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administratora</title>
    <link rel="stylesheet" type="text/css" href="css/admin_style.css">
</head>
<body>

<h1>Witaj, <?php echo $_SESSION['username']; ?>! (Rola: Administrator)</h1>

<!-- Dodatkowa zawartość dla panelu administratora -->

<p><a href="logout.php">Wyloguj się</a></p>

</body>
</html>
