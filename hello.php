<?php
$host = "localhost";
$port = "5432";
$dbname = "ubranka";
$user = "postgres";
$password = "123";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    echo "Error: Unable to connect to the database.\n";
    exit;
}

$query = "SELECT * FROM ubrania ORDER BY data_dodania DESC LIMIT 8";
$result = pg_query($conn, $query);

if (!$result) {
    echo "Error in SQL query: " . pg_last_error($conn);
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <?php include 'header.php'; ?>
</head>
<body>



<div class="image-container">
    <?php
    // Pobierz obrazy z bazy danych
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
