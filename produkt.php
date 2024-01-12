<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <?php include 'header.php'; ?>
</head>
<body>


<div class="content">
    <?php
    // Sprawdź, czy parametr "nazwa" został przekazany w URL
    if (isset($_GET['nazwa'])) {
        // Pobierz nazwę produktu z URL
        $nazwaProduktu = $_GET['nazwa'];

        // Przygotuj zapytanie SQL z parametrami
        $query = "SELECT * FROM ubrania WHERE nazwa = $1";
        $result = pg_query_params($dbconn, $query, array($nazwaProduktu));

        // Sprawdź, czy zapytanie zwróciło wyniki
        if ($result) {
            // Pobierz dane o produkcie
            $row = pg_fetch_assoc($result);

            // Wyświetl zdjęcie po lewej stronie
            echo "<div class='left-content'>";
            echo "<img src='{$row['zdjecie']}' alt='{$nazwaProduktu}'></div>";

            // Wyświetl informacje o produkcie po prawej stronie
            echo "<div class='right-content'>";
            echo "<h1>{$row['nazwa']}</h1>";
            echo "<p>{$row['opis']}</p>";
            echo "<p>Cena: {$row['cena']}</p>";
            echo "</div>";
        } else {
            // Jeśli zapytanie nie zwróciło wyników, wyświetl odpowiedni komunikat
            echo "<p>Nie znaleziono informacji o produkcie.</p>";
        }
    } else {
        // Jeśli parametr "nazwa" nie został przekazany, wyświetl odpowiedni komunikat
        echo "<p>Nie znaleziono informacji o produkcie.</p>";
    }
    ?>
</div>

</body>
</html>