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
$rodzajToShow = isset($_GET['rodzaj']) ? $_GET['rodzaj'] : '';

$query = "SELECT * FROM ubrania";

if (!empty($rodzajToShow)) {
    $query .= " WHERE rodzaj = '$rodzajToShow'";
}

$result = pg_query($dbconn, $query);

if ($result) {
    $counter = 0;

while ($row = pg_fetch_assoc($result)) {
    if ($counter % 3 == 0) {
        echo "<div class='row'>";
    }

    echo "<div class='product zdjecie'>";
    echo "<a href='produkt.php?nazwa={$row['nazwa']}'>";
    echo "<img src='{$row['zdjecie']}' alt='{$row['nazwa']}' class='zdjecie-img'>";
    echo "</a>";
    echo "<h2>{$row['nazwa']}</h2>";


    echo "</div>";

    if ($counter % 3 == 2) {
        echo "</div>";
    }

    $counter++;
}

if ($counter % 3 != 0) {
    echo "</div>";
}


} else {
    echo "<p>Nie znaleziono żadnych produktów.</p>";
}

    ?>
</div>

</body>
</html>
