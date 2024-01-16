<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="produkty.css">
    <?php include 'header.php'; ?>
    <title>Wszystkie Produkty</title>
</head>
<body>

<div class="content">
    <h1>Wszystkie Produkty</h1>

    <?php
    // Przygotuj zapytanie SQL
// Przygotuj zapytanie SQL
$query = "SELECT * FROM ubrania";
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
