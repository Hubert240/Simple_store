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

<div class="content">
    <?php
    if (isset($_GET['nazwa'])) {
        $nazwaProduktu = $_GET['nazwa'];

        $query = "SELECT * FROM ubrania WHERE nazwa = $1";

        $result = pg_query_params($dbconn, $query, array($nazwaProduktu));

        if ($result) {
            $row = pg_fetch_assoc($result);
            $product_id = $row['id'];
            echo "<div class='left-content'>";
            echo "<img src='{$row['zdjecie']}' alt='{$nazwaProduktu}'></div>";
            echo "<div class='right-content'>";
            echo "<h1>{$row['nazwa']}</h1>";
            echo "<p>{$row['opis']}</p>";
            echo "<p>Cena: {$row['cena']}</p>";
            if (isset($_SESSION['id'])) {
                $user_id = $_SESSION['id'];
                echo "<form method='post' action='' enctype='multipart/form-data'>
            
                <input type='submit' name='dodajProdukt' value='Dodaj produkt'>
                </form>";
                if (isset($_POST['dodajProdukt'])){
                    $queryCheckBasket = "SELECT id FROM koszyki WHERE uzytkownik_id = $1";
        $paramsCheckBasket = array($user_id);
        $resultCheckBasket = pg_query_params($dbconn, $queryCheckBasket, $paramsCheckBasket);

        if ($resultCheckBasket && pg_num_rows($resultCheckBasket) > 0) {
            $rowBasket = pg_fetch_assoc($resultCheckBasket);
            $basket_id = $rowBasket['id'];
        } else {
            $queryCreateBasket = "INSERT INTO koszyki (uzytkownik_id) VALUES ($1) RETURNING id";
            $paramsCreateBasket = array($user_id);
            $resultCreateBasket = pg_query_params($dbconn, $queryCreateBasket, $paramsCreateBasket);

            if ($resultCreateBasket) {
                $rowCreateBasket = pg_fetch_assoc($resultCreateBasket);
                $basket_id = $rowCreateBasket['id'];
            } else {
                echo "alert('Błąd przy tworzeniu koszyka.');";
                exit();
            }
        }

        $quantity = 1; 
        $queryAddToBasket = "INSERT INTO elementy_koszyka (koszyk_id, produkt_id, ilosc) VALUES ($1, $2, $3)";
        $paramsAddToBasket = array($basket_id, $product_id, $quantity);
        $resultAddToBasket = pg_query_params($dbconn, $queryAddToBasket, $paramsAddToBasket);



                }
            }
            echo "</div>";
        }
    } 
    ?>
</div>
</body>
</html>
