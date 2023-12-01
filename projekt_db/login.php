<?php
include("db_connection.php");

// Inicjalizacja zmiennych
$username = $password = "";
$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pobieranie danych z formularza
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Weryfikacja danych logowania
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Poprawne logowanie
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Przekierowanie użytkownika w zależności od roli
            if ($_SESSION['role'] === 'admin') {
                header('Location: index.php');
                exit();
            } else {
                header('Location: index.php');
                exit();
            }
        } else {
            // Nieprawidłowe hasło
            $loginError = "Błędne hasło. Spróbuj ponownie.";
        }
    } else {
        // Brak użytkownika o podanej nazwie
        $loginError = "Brak użytkownika o podanej nazwie. Spróbuj ponownie.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz Logowania</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css">
</head>
<body>

<div class="login-container">
    <div class="login-message">
        <?php
        // Wyświetl komunikat błędu logowania, jeśli istnieje
        if (!empty($loginError)) {
            echo "<p style='color: red;'>$loginError</p>";
        }
        ?>

    </div>

    <form action="login.php" method="post">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" required value="<?php echo $username; ?>">

        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Zaloguj się</button>

        <p>Nie masz konta? <a href="register.php">Zarejestruj się</a></p>
    </form>
</div>

</body>
</html>
