<!DOCTYPE html>
<html lang="pl">
<head>
    <link rel="stylesheet" href="/css/produkty.css">
    <?php include 'header.php'; ?>
</head>
<body>

<div class="content">
    <h1>Wszystkie Produkty</h1>


<?php
// Ustal rodzaj produktu do wyświetlenia (możesz przekazać to jako parametr)
$rodzajToShow = isset($_GET['rodzaj']) ? $_GET['rodzaj'] : '';

// Przygotuj zapytanie SQL z warunkiem WHERE
$query = "SELECT * FROM ubrania";

// Dodaj warunek WHERE, jeśli określono rodzaj
if (!empty($rodzajToShow)) {
    $query .= " WHERE rodzaj = '$rodzajToShow'";
}

$result = pg_query($dbconn, $query);

// Sprawdź, czy zapytanie zwróciło wyniki
if ($result) {
    $counter = 0; // Inicjalizuj licznik

    // Wyświetl wszystkie produkty
// Wyświetl wszystkie produkty
while ($row = pg_fetch_assoc($result)) {
    // Rozpocznij nowy rząd po trzech produktach
    if ($counter % 3 == 0) {
        echo "<div class='row'>";
    }

    // Dodaj klasę zdjecie do kontenera obrazu
    echo "<div class='product zdjecie'>";
    // Dodaj klasę zdjecie do samego obrazu
    echo "<a href='produkt.php?nazwa={$row['nazwa']}'>";
    echo "<img src='{$row['zdjecie']}' alt='{$row['nazwa']}' class='zdjecie-img'>";
    echo "</a>";
    echo "<h2>{$row['nazwa']}</h2>";


    echo "</div>";

    // Zakończ rząd po trzech produktach
    if ($counter % 3 == 2) {
        echo "</div>";
    }

    $counter++;
}

// Zakończ ostatni rząd, jeśli nie zakończył się po trzech produktach
if ($counter % 3 != 0) {
    echo "</div>";
}


} else {
    // Jeśli zapytanie nie zwróciło wyników, wyświetl odpowiedni komunikat
    echo "<p>Nie znaleziono żadnych produktów.</p>";
}

    ?>
</div>

</body>
</html>
