<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $carId = $_GET['id'];
    
    // Usuń samochód o podanym identyfikatorze z bazy danych
    $query = "DELETE FROM cars WHERE id = $carId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Zwróć odpowiedź do JavaScript (możesz zwrócić JSON z dodatkowymi informacjami, jeśli potrzebujesz)
        echo "Samochód został pomyślnie usunięty.";
    } else {
        // Zwróć odpowiedź do JavaScript w przypadku błędu
        echo "Błąd podczas usuwania samochodu: " . mysqli_error($conn);
    }
    
    // Zamknij połączenie z bazą danych
    mysqli_close($conn);
} else {
    // Zwróć odpowiedź do JavaScript w przypadku nieprawidłowego żądania
    echo "Nieprawidłowe żądanie.";
}
?>
