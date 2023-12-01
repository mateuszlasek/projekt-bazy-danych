<?php
include("db_connection.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobieranie danych z formularza
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Haszowanie hasła

    // Sprawdzenie, czy nazwa użytkownika już istnieje
    $checkUsernameQuery = "SELECT * FROM users WHERE username = '$username'";
    $resultUsername = $conn->query($checkUsernameQuery);

    // Sprawdzenie, czy e-mail już istnieje
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $resultEmail = $conn->query($checkEmailQuery);

    if ($resultUsername->num_rows > 0) {
        $message = "Nazwa użytkownika już istnieje. Wybierz inną nazwę.";
    } elseif ($resultEmail->num_rows > 0) {
        $message = "Adres e-mail już istnieje. Wybierz inny adres e-mail.";
    } else {
        // Dodaj wymaganie dotyczące długości nazwy użytkownika
        if (strlen($username) < 6) {
            $message = "Nazwa użytkownika musi mieć co najmniej 6 znaków.";
        } else {
            // Dodaj wymaganie dotyczące długości hasła
            if (strlen($_POST["password"]) < 8) {
                $message = "Hasło musi mieć co najmniej 8 znaków.";
            } else {
                // Ustawienie domyślnej roli na 'user'
                $role = 'user';

                // Wstawienie danych do bazy danych
                $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";

                if ($conn->query($sql) === TRUE) {
                    $message = "Rejestracja zakończona pomyślnie!";
                } else {
                    $message = "Błąd podczas rejestracji: " . $conn->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz Rejestracji</title>
    <link rel="stylesheet" type="text/css" href="css/styleregister.css">
</head>
<body>
<div class="register-container">
    <div class="register-message">
        <?php
        // Wyświetl komunikat błędu rejestracji, jeśli istnieje
        if (!empty($message)) {
            echo "<p style='color: red;'>$message</p>";
        }
        ?>
    </div>
    <form method="post" onsubmit="return validateForm()">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Zarejestruj się</button>
        <p>Masz już konto? <a href="login.php">Zaloguj się</a></p>
    </form>
</div>

<script>
    function validateForm() {
        // Sprawdzenie długości nazwy użytkownika
        var username = document.getElementById("username").value;
        var message = "";

        if (username.length < 6) {
            message += "Nazwa użytkownika musi mieć co najmniej 6 znaków.<br>";
        }

        // Sprawdzenie długości hasła
        var password = document.getElementById("password").value;
        if (password.length < 8) {
            message += "Hasło musi mieć co najmniej 8 znaków.<br>";
        }

        // Wyświetlanie komunikatu w zmiennej PHP
        <?php
        echo "document.querySelector('.register-message').innerHTML = '<p style=\"color: red;\">' + message + '</p>';";
        ?>

        // Jeśli jest jakikolwiek komunikat błędu, zwróć false, aby uniemożliwić przesłanie formularza
        return message === "";
    }
</script>

</body>
</html>
