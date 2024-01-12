<!DOCTYPE html>
<html>
<head>
    <?php include 'header.php'; ?>
</head>
<body>
<?php


// Sprawdź, czy użytkownik jest zalogowany
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    
    // Pobierz dane użytkownika z bazy danych na podstawie $user_id
    $query = "SELECT * FROM uzytkownicy WHERE id = $user_id";
    $result = pg_query($dbconn, $query);
    
    // Sprawdź, czy zapytanie zwróciło wyniki
    if ($result) {
        $user = pg_fetch_assoc($result);
        
        // Wyświetl dane użytkownika na stronie
        echo "Witaj, {$user['imie']} {$user['nazwisko']}!";
    } else {
        // Obsłuż błąd zapytania
        echo "Błąd zapytania do bazy danych.";
    }
} else {
    // Jeśli użytkownik nie jest zalogowany, przekieruj go na stronę logowania
    echo "Użytkownik nie jest zalogowany.";
    header('Location: login.php');
}
?>
</body>
</html>