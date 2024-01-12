<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="login.css">
    <?php include 'header.php'; ?>
</head>
<body>


<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-modal-btn">&times;</span>
        <p>Konto z podanym emailem już istnieje.</p>
    </div>
</div>

<div id="myModal2" class="modal">
    <div class="modal-content">
        <span class="close" id="close-modal-btn2">&times;</span>
        <p>Błędne dane logowania.</p>
    </div>
</div>



<div id="login-form" class="container">
    <div class="login-form">
  <form method="post"  autocomplete="off">
  <div class="form-group">
    <h1>Logowanie</h1>
    <input type="email" class="form-control" id="email" placeholder="Wprowadź email" name="email" required>
      <input type="password" class="form-control" id="haslo" placeholder="Wprowadź hasło" name="haslo" required>
    </div>
    <input type="submit" name="submit" class="button" value="Zaloguj">

  <?php
      if (isset($_SESSION['id'])) {
        header('Location: profile.php');
        exit();
    }

     if(isset($_POST['submit'])&&!empty($_POST['submit'])){

      $hashpassword = md5($_POST['haslo']);
      $sql ="select *from uzytkownicy where email = '".pg_escape_string($_POST['email'])."' and haslo ='".$hashpassword."'";
      $data = pg_query($dbconn,$sql); 
      $login_check = pg_num_rows($data);
      if($login_check > 0){ 
        $row = pg_fetch_assoc($data);
        $_SESSION['id'] = $row['id'];
        header('Location: profile.php');
      }else{
        echo '<script>';
        echo 'document.getElementById("myModal2").style.display = "block";';
        echo '</script>';
      }
    }

  ?>
  <div class="register-text">Nie masz konta?</div>
  <div class="register" id="show-register-form">Rejstracja</div>
</div>
</div>
</form>



<div id="register-form" class="container" >
    <div class="register-form">
  <form method="post"  autocomplete="off">
  <div class="form-group">
    <h1>Rejestracja</h1>
    <div class="form-group">
    <input type="text" class="form-control" id="imie" placeholder="Wprowadź imie" name="imie" required>
    <input type="text" class="form-control" id="nazwisko" placeholder="Wprowadź nazwisko" name="nazwisko" required>
    </div>
    <div class="form-group">
    <input type="email" class="form-control" id="email" placeholder="Wprowadź email" name="email" required>
    <input type="password" class="form-control" id="haslo" placeholder="Wprowadź hasło" name="haslo" required>
    </div>
    <div class="form-group">
    <input type="password" class="form-control"  placeholder="Powtórz hasło"  name="haslo-potw" required>
    </div>
  </div>
    <input type="submit" name="register" class="button" value="Zarejestruj">
    </form>
  <?php
      if (isset($_SESSION['id'])) {
        header('Location: profile.php');
        exit();
    }
    
  
    if(isset($_POST['register'])&&!empty($_POST['register'])){
      $email = $_POST["email"];
      $haslo = $_POST["haslo"];
      $haslo_potw = $_POST["haslo_potw"];
      if ($haslo !== $haslo_potw) {
        echo '<div class="error-line">Hasło i potwierdzenie hasła są różne.</div>';
    } else {
      $query = "SELECT COUNT(*) FROM uzytkownicy WHERE email = $1";
      $params = array($email);
      $result = pg_query_params($dbconn, $query, $params);
      
      if ($result) {
        $count = pg_fetch_result($result, 0, 0);
          
          if ($count > 0) {
            echo '<script>';
            echo 'document.getElementById("myModal").style.display = "block";';
            echo '</script>';
            
            
          } else {
            $sql = "insert into uzytkownicy(imie,nazwisko,rola,email,haslo)values('".$_POST['imie']."','".$_POST['nazwisko']."','klient','".$_POST['email']."','".md5($_POST['haslo'])."')";
            $result = pg_query($dbconn, $sql);
            if($result){
                
             echo"Rejestracja przebiegła pomyślnie.";
            }else{
                
                    echo "Podczas rejestracji wystąpił błąd";
            }
              echo "Możesz użyć tego e-maila.";
          }
      } else {
          echo "Błąd zapytania do bazy danych.";
      }

    }}
    ?>
  <div class="register-text">Masz już konto?</div>
  <div class="register" id="show-login-form">Logowanie</div>
</div>
</div>


<button id="open-modal-btn" class="modal-btn">Pokaż modal</button>
<button id="open-modal-btn2" class="modal-btn">Pokaż modal</button>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const isLoginFormVisible = localStorage.getItem("isLoginFormVisible");

    function showRegisterForm() {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('register-form').style.display = 'block';
        localStorage.setItem("isLoginFormVisible", "false");
    }

    function showLoginForm() {
        document.getElementById('register-form').style.display = 'none';
        document.getElementById('login-form').style.display = 'block';
        localStorage.setItem("isLoginFormVisible", "true");
    }

    if (isLoginFormVisible === "true") {
        showLoginForm();
    } else {
        showRegisterForm();
    }

    document.getElementById('show-login-form').addEventListener('click', showLoginForm);
    document.getElementById('show-register-form').addEventListener('click', showRegisterForm);

  });


var modal = document.getElementById('myModal');
var openBtn = document.getElementById('open-modal-btn');
var closeBtn = document.getElementById('close-modal-btn');

function openModal() {
  document.getElementById('myModal').style.display = 'block';
  document.getElementById('modal-content').innerHTML = content;
}

function closeModal() {
    modal.style.display = 'none';
    window.location.href = 'profile.php';
}

openBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);

window.addEventListener('click', function(event) {
    if (event.target === modal) {
        closeModal();
    }
});


var modal2 = document.getElementById('myModal2');
var openBtn2 = document.getElementById('open-modal-btn2');
var closeBtn2 = document.getElementById('close-modal-btn2');

function openModal2() {
  document.getElementById('myModal2').style.display = 'block';
  document.getElementById('modal-content2').innerHTML = content;
}

function closeModal2() {
    modal.style.display = 'none';
    window.location.href = 'profile.php';
}

openBtn2.addEventListener('click', openModal2);
closeBtn2.addEventListener('click', closeModal2);

window.addEventListener('click', function(event) {
    if (event.target === modal2) {
        closeModal2();
    }
});



</script>

</body>
</html>