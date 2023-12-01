<?php
session_start();

// Sprawdź, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Użytkownika</title>
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
</head>
<body>

<h1>Witaj, <?php echo $_SESSION['username']; ?>! (Rola: Użytkownik)</h1>

<!-- Dodatkowa zawartość dla panelu użytkownika -->

<p><a href="logout.php">Wyloguj się</a></p>

</body>
</html>
