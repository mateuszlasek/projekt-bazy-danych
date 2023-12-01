<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>GALERIA</title>
    <link rel="stylesheet" href="css/stylecars.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200&amp;display=swap" rel="stylesheet">
</head>

<body>

    <?php 
    include("navbar.php"); 

    // Połącz się z bazą danych
    include("db_connection.php");

    // Pobierz dane o samochodach z bazy danych
    $query = "SELECT * FROM cars";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Iteruj przez wyniki zapytania
        while ($row = mysqli_fetch_assoc($result)) {
            // Sprawdź dostępność samochodu
            if ($row['availability'] == 1) {
                // Samochód jest dostępny, więc wyświetl informacje
                $wypozyczenie_link = isset($_SESSION['user_id']) ? "wypozyczenie.php" : "login.php";
                
                echo '<div class="photos">';
                echo '<a href="' . $wypozyczenie_link . '">';
                echo '<img src="' . $row['images'] . '" alt="' . $row['model'] . '">';
                echo '<div class="photo-info">';
                echo '<h3>' . $row['model'] . '</h3>';
                echo '<p>' . $row['opis'] . '</p>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
            }
        }

        // Zwolnij zasoby wyniku zapytania
        mysqli_free_result($result);
    }

    // Zamknij połączenie z bazą danych
    mysqli_close($conn);
    ?>

    <script src="js/app.js"></script>
</body>

</html>