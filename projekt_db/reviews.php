<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>Recenzje Samochodów</title>
    <link rel="stylesheet" href="css/reviews.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200&amp;display=swap" rel="stylesheet">
</head>

<body>
    <?php
    include("navbar.php");
    include("db_connection.php");

    // Sprawdź, czy użytkownik jest zalogowany
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sprawdź, czy formularz został przesłany
        if (isset($_POST['car'], $_POST['rating'], $_POST['review_text'])) {
            $car_id = $_POST['car'];
            $rating = $_POST['rating'];
            $review_text = $_POST['review_text'];

            // Pobierz name z tabeli users na podstawie user_id
            $user_query = "SELECT username FROM users WHERE id = ?";
            $user_stmt = $conn->prepare($user_query);
            $user_stmt->bind_param("i", $user_id);
            $user_stmt->execute();
            $user_result = $user_stmt->get_result();
            $user_row = $user_result->fetch_assoc();
            $name = $user_row['username'];

            // Pobierz brand i model samochodu na podstawie car_id
            $car_query = "SELECT brand, model, images FROM cars WHERE id = ?";
            $car_stmt = $conn->prepare($car_query);
            $car_stmt->bind_param("i", $car_id);
            $car_stmt->execute();
            $car_result = $car_stmt->get_result();
            $car_row = $car_result->fetch_assoc();
            $car_name = $car_row['brand'] . ' ' . $car_row['model'];
            $car_image = $car_row['images'];

            // Wstaw dane do tabeli reviews
            $insert_query = "INSERT INTO reviews (id_client, car_id, name, rating, text) VALUES (?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);

            // Dodajemy 's' dla stringa, ponieważ name jest typu string
            $insert_stmt->bind_param("iisss", $user_id, $car_id, $name, $rating, $review_text);
            $insert_stmt->execute();
            $insert_stmt->close();
        }
    }
    ?>

    <div class="container">
        <h2>Formularz Recenzji Samochodu</h2>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <label for="car">Wybierz Samochód:</label>
            <select name="car" id="car" required>
                <?php
                // Pobierz dostępne samochody z bazy danych
                $car_query = "SELECT * FROM cars";
                $car_result = mysqli_query($conn, $car_query);

                while ($row = mysqli_fetch_assoc($car_result)) {
                    echo '<option value="' . $row['id'] . '">' . $row['brand'] . ' ' . $row['model'] . '</option>';
                }
                ?>
            </select>

            <label for="rating">Ocena (1-5):</label>
            <input type="number" name="rating" id="rating" min="1" max="5" required>

            <label for="review_text">Tekst recenzji:</label>
            <textarea name="review_text" id="review_text" rows="4" required></textarea>

            <button type="submit">Dodaj Recenzję</button>
        </form>

        <h2>Recenzje Samochodów</h2>
        <div class="reviews-container">
    <?php
    // Pobierz recenzje z tabeli reviews
    $reviews_query = "SELECT name, car_id, rating, text FROM reviews";
    $reviews_result = mysqli_query($conn, $reviews_query);

    while ($review_row = mysqli_fetch_assoc($reviews_result)) {
        // Pobierz brand, model i images samochodu na podstawie car_id
        $car_query = "SELECT brand, model, images FROM cars WHERE id = ?";
        $car_stmt = $conn->prepare($car_query);
        $car_stmt->bind_param("i", $review_row['car_id']);
        $car_stmt->execute();
        $car_result = $car_stmt->get_result();
        $car_row = $car_result->fetch_assoc();
    
        echo '<div class="review">';
        echo '<p><strong>Użytkownik:</strong> ' . $review_row['name'] . '</p>';
        echo '<p><strong>Samochód:</strong> ' . $car_row['brand'] . ' ' . $car_row['model'] . '</p>';
        echo '<p><strong>Ocena:</strong> ' . $review_row['rating'] . '</p>';
        echo '<p><strong>Recenzja:</strong> ' . $review_row['text'] . '</p>';
        echo '<img src="' . $car_row['images'] . '" alt="' . $car_row['brand'] . ' ' . $car_row['model'] . '" class="car-image">';
        echo '</div>';
    }

    // Funkcja do pobierania nazwy samochodu na podstawie ID
    function getCarName($conn, $car_id)
    {
        $car_query = "SELECT brand, model FROM cars WHERE id = ?";
        $car_stmt = $conn->prepare($car_query);
        $car_stmt->bind_param("i", $car_id);
        $car_stmt->execute();
        $car_result = $car_stmt->get_result();
        $car_row = $car_result->fetch_assoc();
        return $car_row['brand'] . ' ' . $car_row['model'];
    }
    ?>
</div>
    </div>

    <?php
    // Zamknij połączenie z bazą danych
    mysqli_close($conn);
    ?>

    <script src="js/app.js"></script>
</body>

</html>