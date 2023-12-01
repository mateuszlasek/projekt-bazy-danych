<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <title>GALERIA</title>
    <link rel="stylesheet" href="css/stylecars.css" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200&amp;display=swap" rel="stylesheet">
    <script>
        function toggleAddCarForm() {
            var addCarForm = document.getElementById("addCarForm");
            addCarForm.style.display = (addCarForm.style.display === "none" || addCarForm.style.display === "") ? "block" : "none";
        }

        
    </script>
</head>

<body>
    
    <?php 
    include("navbar.php"); 
    include("db_connection.php");
    
    

    // add car
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addCarBtn'])) {
        $brand = $_POST["brand"];
        $model = $_POST["model"];
        $year = $_POST["year"];
        $color = $_POST["color"];
        $availability = $_POST["availability"];
        $images = $_POST["images"];
        $opis = $_POST["opis"];
    
        // Dodaj odpowiednią obsługę błędów i zabezpiecz przed atakami SQL Injection
    
        $query = "INSERT INTO cars (brand, model, year, color, availability, images, opis)
                  VALUES ('$brand', '$model', $year, '$color', $availability, 'images/$images', '$opis')";
        $addResult = mysqli_query($conn, $query);
        if ($addResult) {
            
                echo "<div style=text-align: center; margin-left: 20px;>Samochód został dodany pomyślnie.</div>";
            
        } else {
            
            echo "<div style='text-align: center; margin-left: 20px;>Błąd podczas dodawania samochodu: " . mysqli_error($conn) . "</div>";
        } 
    
        
    }

    // delete car
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteCarBtn'])) {
        $carIdToDelete = $_POST['car_id'];
        
        
        $deleteQuery = "DELETE FROM cars WHERE id = $carIdToDelete";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        if ($deleteResult) {
            echo "<div style='text-align: center; margin-left: 20px;'>Samochód został pomyślnie usunięty.</div>";
        } else {
            echo "<div style='text-align: center; margin-left: 20px;'>Błąd podczas usuwania samochodu: " . mysqli_error($conn) . "</div>";
        }
    }

    
   
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        echo '<button class="addCarFormBtn" onclick="toggleAddCarForm()">Dodaj samochód</button>';
    }
    ?>

    <!-- Dodaj pod pętlą wyświetlającą samochody -->
    <div action="process_add_car.php" class="form-container" id="addCarForm" style="display: none;">
        <!-- Formularz dodawania samochodu -->
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <label for="brand">Marka:</label>
            <input type="text" name="brand" required>

            <label for="model">Model:</label>
            <input type="text" name="model" required>

            <label for="year">Rok produkcji:</label>
            <input type="number" name="year" required>

            <label for="color">Kolor:</label>
            <input type="text" name="color" required>

            <label for="availability">Dostępność:</label>
            <select name="availability" required>
                <option value="1">Dostępny</option>
                <option value="0">Niedostępny</option>
            </select>

            <label for="images">Zdjęcie:</label>
            <input type="file" name="images" accept="image/*" required>

            <label for="opis">Opis:</label>
            <textarea name="opis"></textarea>

            <button class="addCarBtn" type="submit" name="addCarBtn">Dodaj</button>
        </form>
    </div>

    <?php
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
                ?>
                <div class="cars">
                    <div class="photos">
                        <a href="<?php echo $wypozyczenie_link; ?>">
                            <img src="<?php echo $row['images']; ?>" alt="<?php echo $row['model']; ?>">
                            <div class="photo-info">
                                <h3><?php echo $row['model']; ?></h3>
                                <p><?php echo $row['opis']; ?></p>
                            </div>
                        </a>
                        <?php
                            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                // Dodaj formularz do usuwania samochodu
                                echo '<form method="post" action="' . $_SERVER["PHP_SELF"] . '">';
                                echo '<input type="hidden" name="car_id" value="' . $row['id'] . '">';
                                echo '<button type="submit" class="deleteCarBtn" name="deleteCarBtn">Usuń samochód</button>';
                                echo '</form>';
                            }
                            ?>
                    </div>
                    
                </div>

                <?php
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
