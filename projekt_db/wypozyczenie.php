<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Wypożyczenie Samochodu</title>
    <link rel="stylesheet" href="css/rent.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200&amp;display=swap" rel="stylesheet">
</head>

<body>
    <?php
    include("navbar.php");
    include("db_connection.php");

    // Pobierz dostępne samochody z bazy danych
    $query = "SELECT * FROM cars WHERE availability = 1";
    $result = mysqli_query($conn, $query);

    // Pobierz id zalogowanego klienta
    $client_id = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sprawdź, czy formularz został przesłany
        if (isset($_POST['car'], $_POST['rental_date'], $_POST['return_date'])) {
            // Przygotuj prepared statement
            $stmt = $conn->prepare("INSERT INTO rentals (client_id, car_id, rental_date, return_date) VALUES (?, ?, ?, ?)");

            // Parametry
            $car_id = $_POST['car'];
            $rental_date = $_POST['rental_date'];
            $return_date = $_POST['return_date'];

            // Związanie parametrów
            $stmt->bind_param("iiss", $client_id, $car_id, $rental_date, $return_date);

            // Wykonaj zapytanie
            $stmt->execute();

            // Zamknij statement
            $stmt->close();

            // Zaktualizuj pole 'availability' w tabeli 'cars' na 0
            $update_query = "UPDATE cars SET availability = 0 WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("i", $car_id);
            $update_stmt->execute();
            $update_stmt->close();
        }
    }
    ?>

    <div class="container">
        <h2>Formularz Wypożyczenia Samochodu</h2>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <label for="car">Wybierz Samochód:</label>
            <select name="car" id="car" required>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['id'] . '">' . $row['brand'] . ' ' . $row['model'] . ' (' . $row['year'] . ')</option>';
                }
                ?>
            </select>

            <label for="rental_date">Data Rozpoczęcia Wynajmu:</label>
            <input type="date" name="rental_date" id="rental_date" required>

            <label for="return_date">Data Zwrotu Samochodu:</label>
            <input type="date" name="return_date" id="return_date" required>

            <button type="submit">Zarezerwuj Samochód</button>
        </form>
    </div>

    <?php
    // Zwolnij zasoby wyniku zapytania
    mysqli_free_result($result);

    // Zamknij połączenie z bazą danych
    mysqli_close($conn);
    ?>

    <script src="js/app.js"></script>
</body>

</html>