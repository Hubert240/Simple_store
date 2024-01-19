<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <?php include 'header.php'; ?>
</head>
<body>
<div class="zobacz-produkty">
        <a href="produkty.php">Zobacz wszystkie produkty</a>
    </div>


<div class="content">
    <?php
    // Sprawdź, czy parametr "nazwa" został przekazany w URL
    if (isset($_GET['nazwa'])) {
        // Pobierz nazwę produktu z URL
        $nazwaProduktu = $_GET['nazwa'];
        $user_id = $_SESSION['id'];
        // Przygotuj zapytanie SQL z parametrami
        $query = "SELECT * FROM ubrania WHERE nazwa = $1";

        $result = pg_query_params($dbconn, $query, array($nazwaProduktu));

        // Sprawdź, czy zapytanie zwróciło wyniki
        if ($result) {
            // Pobierz dane o produkcie
            $row = pg_fetch_assoc($result);
            $product_id = $row['id'];
            // Wyświetl zdjęcie po lewej stronie
            echo "<div class='left-content'>";
            echo "<img src='{$row['zdjecie']}' alt='{$nazwaProduktu}'></div>";

            // Wyświetl informacje o produkcie po prawej stronie
            echo "<div class='right-content'>";
            echo "<h1>{$row['nazwa']}</h1>";
            echo "<p>{$row['opis']}</p>";
            echo "<p>Cena: {$row['cena']}</p>";
            echo "<div class='koszyk-button'>";
            echo "<button onclick='dodajDoKoszyka()'>Dodaj do koszyka</button>";
            echo "</div>";
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
<script>
function dodajDoKoszyka() {
       
       <?php
           // Sprawdź, czy użytkownik ma już koszyk
           $queryCheckBasket = "SELECT id FROM koszyki WHERE uzytkownik_id = $1";
           $paramsCheckBasket = array($user_id);
           $resultCheckBasket = pg_query_params($dbconn, $queryCheckBasket, $paramsCheckBasket);

           if ($resultCheckBasket && pg_num_rows($resultCheckBasket) > 0) {
               // Użytkownik ma już koszyk, pobierz ID koszyka
               $rowBasket = pg_fetch_assoc($resultCheckBasket);
               $basket_id = $rowBasket['id'];
           } else {
               // Użytkownik nie ma koszyka, stwórz nowy koszyk
               $queryCreateBasket = "INSERT INTO koszyki (uzytkownik_id) VALUES ($1) RETURNING id";
               $paramsCreateBasket = array($user_id);
               $resultCreateBasket = pg_query_params($dbconn, $queryCreateBasket, $paramsCreateBasket);

               if ($resultCreateBasket) {
                   $rowCreateBasket = pg_fetch_assoc($resultCreateBasket);
                   $basket_id = $rowCreateBasket['id'];
               } else {
                   // Obsłuż błąd przy tworzeniu koszyka
                   echo "alert('Błąd przy tworzeniu koszyka.');";
                   exit();
               }
           }

           // Dodaj produkt do koszyka (element koszyka)
           $quantity = 1; // Możesz dostosować ilość
           $queryAddToBasket = "INSERT INTO elementy_koszyka (koszyk_id, produkt_id, ilosc) VALUES ($1, $2, $3)";
           $paramsAddToBasket = array($basket_id, $product_id, $quantity);
           $resultAddToBasket = pg_query_params($dbconn, $queryAddToBasket, $paramsAddToBasket);

           if ($resultAddToBasket) {
               echo "alert('Produkt dodany do koszyka.');";
           } else {
               // Obsłuż błąd przy dodawaniu produktu do koszyka
               echo "alert('Błąd przy dodawaniu produktu do koszyka.');";
           }
       ?>
   }
</script>
</body>
</html>