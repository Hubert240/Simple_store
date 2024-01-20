<!DOCTYPE html>
<html>
<head>
    <?php include 'header.php'; ?>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
<?php
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

        echo "<h1>Dodaj nowy produkt</h1>";
        echo "<form method='post' action='' enctype='multipart/form-data'>
                <label for='nazwa'>Nazwa:</label>
                <input type='text' id='nazwa' name='nazwa' required><br>

                <label for='rodzaj'>Rodzaj:</label>
                <input type='text' id='rodzaj' name='rodzaj' required><br>

                <label for='opis'>Opis:</label>
                <textarea id='opis' name='opis' required></textarea><br>

                <label for='cena'>Cena:</label>
                <input type='number' step='0.01' id='cena' name='cena' required><br>

                <label for='zdjecie'>Zdjęcie:</label>
                <input type='file' id='zdjecie' name='zdjecie' accept='image/*' required><br>

                <input type='submit' name='dodajProdukt' value='Dodaj produkt'>
            </form>";

        if (isset($_POST['dodajProdukt'])) {
            $nazwa = $_POST['nazwa'];
            $rodzaj = $_POST['rodzaj'];
            $opis = $_POST['opis'];
            $cena = $_POST['cena'];

            $targetDir = "images/";
            $targetFile = $targetDir . basename($_FILES["zdjecie"]["name"]);
            move_uploaded_file($_FILES["zdjecie"]["tmp_name"], $targetFile);

            $queryDodajProdukt = "INSERT INTO ubrania (nazwa, rodzaj, opis, cena, data_dodania, zdjecie)
                                  VALUES ($1, $2, $3, $4, CURRENT_DATE, $5)";
            $params = array($nazwa, $rodzaj, $opis, $cena, $targetFile);
            $resultDodajProdukt = pg_query_params($dbconn, $queryDodajProdukt, $params);

            if ($resultDodajProdukt) {
                echo "<p>Produkt został dodany pomyślnie.</p>";
            } else {
                echo "<p>Błąd podczas dodawania produktu.</p>";
            }
        }
    } 
 else {
    echo "<p>Użytkownik nie jest zalogowany.</p>";
    header('Location: login.php');
}
?>
</body>
</html>