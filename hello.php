
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <?php include 'header.php'; ?>
</head>
<body>

<div class="zobacz-produkty">
        <a href="produkty.php">Zobacz wszystkie produkty</a>
    </div>

<div class="image-container">
    <?php
    // Pobierz obrazy z bazy danych
    $query = "SELECT * FROM ubrania ORDER BY data_dodania DESC LIMIT 6";
$result = pg_query($dbconn, $query);
    while ($row = pg_fetch_assoc($result)) {
        $nazwa = $row['nazwa'];
        $zdjecie = $row['zdjecie'];
        $sciezkaZdjecia = $zdjecie;

        if (file_exists($sciezkaZdjecia)) {
            echo "<div class=\"zdjecie\"><a href=\"produkt.php?nazwa=$nazwa\"><img src=\"$sciezkaZdjecia\" alt=\"$nazwa\"></a></div>";
        } else {
            echo "Plik zdjęcia \"$nazwa\" nie istnieje.<br>";
        }
    }
    ?>
</div>


<div class="controls">
    <button id="prevButton">&lt;</button>
    <button id="nextButton">&gt;</button>
</div>

<script src="skrypt.js"></script>
</body>
</html>
