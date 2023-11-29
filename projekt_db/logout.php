<?php
session_start();

// Zniszcz sesję
session_destroy();

// Przekieruj użytkownika na stronę logowania
header('Location: login.php');
exit();
?>
