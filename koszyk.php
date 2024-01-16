<!DOCTYPE html>
<html>
<head>
    <?php include 'header.php'; ?>
</head>
<body>
    <?php
    // Sprawdź, czy użytkownik jest zalogowany
    if (isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        
        // Pobierz dane użytkownika z bazy danych na podstawie $user_id
        $query_user = "SELECT * FROM uzytkownicy WHERE id = $user_id";
        $result_user = pg_query($dbconn, $query_user);
        
        // Sprawdź, czy zapytanie zwróciło wyniki
        if ($result_user) {
            $user = pg_fetch_assoc($result_user);
            
            // Wyświetl dane użytkownika na stronie
            echo "Witaj, {$user['imie']} {$user['nazwisko']}!";

            // Zapytanie o koszyk danego użytkownika
            $query_koszyk = "SELECT id FROM koszyki WHERE uzytkownik_id = $user_id";
            $result_koszyk = pg_query($dbconn, $query_koszyk);

            if ($result_koszyk) {
                $row_koszyk = pg_fetch_assoc($result_koszyk);

                if ($row_koszyk) {
                    $koszyk_id = $row_koszyk['id'];

                    // Zapytanie o elementy koszyka
                    $query_elementy_koszyka = "SELECT ubrania.nazwa, elementy_koszyka.ilosc, ubrania.cena
                                              FROM elementy_koszyka
                                              JOIN ubrania ON elementy_koszyka.produkt_id = ubrania.id
                                              WHERE elementy_koszyka.koszyk_id = $koszyk_id";
                    $result_elementy_koszyka = pg_query($dbconn, $query_elementy_koszyka);

                    if ($result_elementy_koszyka) {
                        if (pg_num_rows($result_elementy_koszyka) > 0) {
                            echo "<h2>Twój koszyk:</h2>";
                            echo "<table border='1'>
                                    <tr>
                                        <th>Nazwa Produktu</th>
                                        <th>Ilość</th>
                                        <th>Cena</th>
                                    </tr>";

                            while ($row_elementy_koszyka = pg_fetch_assoc($result_elementy_koszyka)) {
                                echo "<tr>
                                        <td>{$row_elementy_koszyka['nazwa']}</td>
                                        <td>{$row_elementy_koszyka['ilosc']}</td>
                                        <td>{$row_elementy_koszyka['cena']}</td>
                                    </tr>";
                            }

                            echo "</table>";
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
            // Obsłuż błąd zapytania
            echo "Błąd zapytania do bazy danych.";
        }
    } else {
        // Jeśli użytkownik nie jest zalogowany, przekieruj go na stronę logowania
        echo "Użytkownik nie jest zalogowany.";
        header('Location: login.php');
    }
    ?>
</body>
</html>
