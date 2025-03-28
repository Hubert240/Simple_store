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

        $query = "SELECT * FROM uzytkownicy WHERE id = $1";
        $result = pg_query_params($dbconn, $query, array($user_id));

        if ($result) {
            $user = pg_fetch_assoc($result);
            if ($user['rola'] === 'admin') {
                echo '<a href="nowy_produkt.php" class="add-button">Dodaj Nowy Produkt</a>';
            }
            echo "<h1>Edycja profilu użytkownika</h1>";
            echo "<form method='post' action=''>
                    <label for='imie'>Imię:</label>
                    <input type='text' id='imie' name='imie' value='{$user['imie']}' required><br>

                    <label for='nazwisko'>Nazwisko:</label>
                    <input type='text' id='nazwisko' name='nazwisko' value='{$user['nazwisko']}' required><br>

                    <label for='email'>E-mail:</label>
                    <input type='email' id='email' name='email' value='{$user['email']}' required><br>

                    <input type='submit' name='updateProfile' value='Zapisz zmiany'>
                </form>";

            if (isset($_POST['updateProfile'])) {
                $imie = $_POST['imie'];
                $nazwisko = $_POST['nazwisko'];
                $email = $_POST['email'];
                $queryUpdate = "UPDATE uzytkownicy SET imie = $1, nazwisko = $2, email = $3 WHERE id = $4";
                $resultUpdate = pg_query_params($dbconn, $queryUpdate, array($imie, $nazwisko, $email, $user_id));

                if ($resultUpdate) {
                    echo "<p>Dane użytkownika zostały zaktualizowane.</p>";
                    header('Location: profile.php');
                    exit();
                } else {
                    echo "<p>Błąd podczas aktualizacji danych użytkownika.</p>";
                }
            }
        } else {
            echo "<p>Błąd zapytania do bazy danych.</p>";
        }
    } else {
        echo "<p>Użytkownik nie jest zalogowany.</p>";
        header('Location: login.php');
    }
    ?>
</body>
</html>
