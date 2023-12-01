<!-- navbar.php -->
<?php
include("db_connection.php");
session_start();
?>
<head>
<link rel="stylesheet" href="css/stylenav.css" type="text/css">
</head>
<body>
<div class="navbar">
    <div class="logo">
        <div class="logoimage">
            <a href="index.php">
                <img src="images/logo.jpg" alt="Camera" width="150" height="70">
            </a>
        </div>
        <div class="logoname">
            <div class="logotext1">Wypożyczalnia</div>
            <div class="logotext2">Samochodów</div>
        </div>
    </div>
    <ul class="nav-links">
        <li>
            <a href="index.php"><span>STRONA GŁÓWNA</span></a>
        </li>
        <li>
            <a href="cars.php"><span>SAMOCHODY</span></a>
        </li>
        <li>
            <a href="aboutus.php"><span>O NAS</span></a>
        </li>
        <li>
            <a href="reviews.php"><span>RECENZJE</span></a> <!-- Dodano przycisk "RECENZJE" -->
        </li>
        <li class="user-info">
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<span class="welcome-message">Witaj, ' . $_SESSION['username'] . '!</span>';
                echo '<a href="logout.php" class="logout-button">Wyloguj</a>';
            } else {
                echo '<a href="login.php"><span>MOJE KONTO</span></a>';
            }
            ?>
        </li>
    </ul>
    <div class="button">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
</div>
</body>
