<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/koszyk.css">
    <?php include 'header.php'; ?>
</head>
<body>
<?php
ob_start();
if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    $query_user = "SELECT * FROM uzytkownicy WHERE id = $user_id";
    $result_user = pg_query($dbconn, $query_user);
    if ($result_user) {
        $user = pg_fetch_assoc($result_user);

        $query_koszyk = "SELECT id FROM koszyki WHERE uzytkownik_id = $user_id";
        $result_koszyk = pg_query($dbconn, $query_koszyk);
        if ($result_koszyk) {
            $row_koszyk = pg_fetch_assoc($result_koszyk);

            if ($row_koszyk) {
                $koszyk_id = $row_koszyk['id'];

                $query_elementy_koszyka = "SELECT ubrania.nazwa, elementy_koszyka.ilosc, ubrania.cena, elementy_koszyka.id
                                          FROM elementy_koszyka
                                          JOIN ubrania ON elementy_koszyka.produkt_id = ubrania.id
                                          WHERE elementy_koszyka.koszyk_id = $koszyk_id";
                $result_elementy_koszyka = pg_query($dbconn, $query_elementy_koszyka);

                if ($result_elementy_koszyka) {
                    if (pg_num_rows($result_elementy_koszyka) > 0) {
                        echo "<h2>Twój koszyk:</h2>";
                        echo "<table class='styled-table'>
                                <tr>
                                    <th>Nazwa Produktu</th>
                                    <th>Cena</th>
                                    <th>Usuwanie</th>
                                </tr>";

                        while ($row_elementy_koszyka = pg_fetch_assoc($result_elementy_koszyka)) {
                            echo "<tr>
                                    <td>{$row_elementy_koszyka['nazwa']}</td>
                                    <td>{$row_elementy_koszyka['cena']}</td>
                                    <td>
                                        <form method='post' action=''>
                                            <input type='hidden' name='id' value='{$row_elementy_koszyka['id']}'>
                                            <input type='submit' name='usunZKoszyka' value='Usuń z koszyka'>
                                        </form>
                                    </td>
                                  </tr>";
                        }

                        echo "</table>";

                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usunZKoszyka'])) {
                            $produkt_id_do_usuniecia = $_POST['id'];
                            usunZKoszyka($dbconn, $user_id, $produkt_id_do_usuniecia);
                        }
                    } else {
                        echo "<p>Twój koszyk jest pusty.</p>";
                    }
                } else {
                    echo "<p>Błąd podczas pobierania elementów koszyka.</p>";
                }
            } else {
                echo "<p>Nie znaleziono koszyka dla tego użytkownika.</p>";
            }
        } else {
            echo "<p>Błąd podczas pobierania koszyka.</p>";
        }
    } else {
        echo "Błąd zapytania do bazy danych.";
    }
} else {
    echo "Użytkownik nie jest zalogowany.";
    header('Location: login.php');
}
?>



<script>
    <?php 
function usunZKoszyka($dbconn, $user_id, $idProduktu) {
    
    $queryKoszyk = "SELECT id FROM koszyki WHERE uzytkownik_id = $1";
    $resultKoszyk = pg_query_params($dbconn, $queryKoszyk, array($user_id));

    if ($resultKoszyk) {
        $rowKoszyk = pg_fetch_assoc($resultKoszyk);

        if ($rowKoszyk) {
            $idKoszyka = $rowKoszyk['id'];

            $queryUsunZKoszyka = "DELETE FROM elementy_koszyka WHERE koszyk_id = $1 AND id = $2";
            $resultUsunZKoszyka = pg_query_params($dbconn, $queryUsunZKoszyka, array($idKoszyka, $idProduktu));

            if ($resultUsunZKoszyka) {
                header("Refresh:0");

                ob_end_flush();
                exit();
            } else {
                echo "Błąd przy usuwaniu produktu z koszyka.";
            }
        } else {
            echo "Nie znaleziono koszyka dla tego użytkownika.";
        }
    } else {
        echo "Błąd przy pobieraniu koszyka.";
    }
}

?>

    </script>
</body>
</html>
