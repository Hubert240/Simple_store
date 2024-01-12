<?php

$host = "localhost";
$port = "5432";
$dbname = "ubranka";
$user = "postgres";
$password = "123";
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";
$dbconn = pg_connect($connection_string);




if(isset($_POST['submit'])&&!empty($_POST['submit'])){
  $email = $_POST["email"];

  // Przygotuj zapytanie SQL
  $query = "SELECT COUNT(*) FROM uzytkownicy WHERE email = $1";
  $params = array($email);
  $result = pg_query_params($dbconn, $query, $params);
  
  if ($result) {
      $row = pg_fetch_assoc($result);
      $count = $row['count'];
  
      if ($count > 0) {
          // E-mail już istnieje w bazie danych
          echo "E-mail już istnieje w bazie danych.";
      } else {
          // E-mail jest nowy i może być użyty
          echo "Możesz użyć tego e-maila.";
      }
  } else {
      // Błąd zapytania do bazy danych
      echo "Błąd zapytania do bazy danych.";
  }





    $sql = "insert into uzytkownicy(imie,nazwisko,rola,email,haslo)values('".$_POST['imie']."','".$_POST['nazwisko']."','klient','".$_POST['email']."','".md5($_POST['haslo'])."')";
    $result = pg_query($dbconn, $sql);
    if($result){
        
            echo "Rejestracja przebiegła pomyślnie";
    }else{
        
            echo "Podczas rejestracji wystąpił błąd";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="login.css">
    <?php include 'header.php'; ?>
</head>
<body>
<div class="container">
  <form method="post">
  
    <div class="form-group">
      <label for="imie">Imie:</label>
      <input type="text" class="form-control" id="imie" placeholder="Wprowadź imie" name="imie" required>
    </div>

    <div class="form-group">
      <label for="nazwisko">Nazwisko:</label>
      <input type="text" class="form-control" id="nazwisko" placeholder="Wprowadź nazwisko" name="nazwisko" required>
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Wprowadź email" name="email" required>
    </div>
    
    <div class="form-group">
      <label for="haslo">Hasło:</label>
      <input type="password" class="form-control" id="haslo" placeholder="Wprowadź hasło" name="haslo" required>
    </div>
     
    <input type="submit" name="submit" class="btn btn-primary" value="Zatwierdź">
  </form>
</div>
</body>
</html>