<?php
include("db_connection.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobieranie danych z formularza
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Haszowanie hasła

    // Wstawienie danych do bazy danych
    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        $message = "Rejestracja zakończona pomyślnie!";
    } else {
        $message = "Błąd podczas rejestracji: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz Rejestracji</title>
    <link rel="stylesheet" type="text/css" href="css/styleregister.css">
</head>
<body>

<form method="post">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" id="username" name="username" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Hasło:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Zarejestruj się</button>
    <p>Masz już konto? <a href="login.php">Zaloguj się</a></p>
</form>



</body>
</html>
