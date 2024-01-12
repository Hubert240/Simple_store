<?php
session_start();
$host = "localhost";
$port = "5432";
$dbname = "ubranka";
$user = "postgres";
$password = "123";

$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";
$dbconn = pg_connect($connection_string);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Ciao Bella Bella</title>
    <link rel="icon" href="logo/gotowe_logo.ico" type="image/x-icon">
    <style>
        body {
        margin: 0;
        font-family: Arial, sans-serif;
        }
        .top-bar {
            background-color: #f6b98c;
            display: flex;
            justify-content: space-between;
            align-items: center;
            user-select: none;
        }

        .second-top-bar {
            background-color: #f6b98c;
            display: flex;
            user-select: none;
            justify-content: center; 
            align-items: center;
        }


        .second-top-bar button {
            margin: 0 40px;
            padding: 5px 10px;
            color: #fff;
            font-weight: bold;
            font-size: 16px;
            background-color: transparent; 
            border: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }


        .second-top-bar button:hover {
            color: #000;
        }

        .logo {
            margin-left: 30px;
            user-select: none;
        }

        .logo img {
            width: 100px;
            height: auto;
        }


        .napis img{
            width: 500px;
            height: auto;
            margin-right: 40px;
            user-select: none;
        }

        .login img {
            margin-right: 30px;
            width: 60px;
            height: auto;
        }

        .logout img {
            width: 60px;
            height: auto;
            margin-right: 30px;
        }
        .loged img {
            margin-left: 580%;
            width: 60px;
            height: auto;
        }

        .lognapis img{
            width: 500px;
            height: auto;
            margin-left: 40%;
            user-select: none;
        }
    </style>
</head>
<body>


<div class="top-bar">
    <a href="hello.php" class="logo">
        <img src="logo/gotowe_logo.png" alt="logo">
    </a>


<?php
if (isset($_SESSION['id'])) {
        echo '<a href="hello.php" class="lognapis">';
        echo '<img src="logo/napis.png" alt="lognapis">';
        echo '</a>';
        echo '<a href="login.php" class="loged">';
        echo '<img src="logo/login.png" alt="loged">';
        echo '</a>';
        echo '<a href="logout.php" class="logout">';
        echo '<img src="logo/logout_icon.png" alt="logout">';
        echo '</a>';}
else{
        echo '<a href="hello.php" class="napis">';
        echo '<img src="logo/napis.png" alt="napis">';
        echo '</a>';
        echo '<a href="login.php" class="login">';
        echo '<img src="logo/login.png" alt="login">';
        echo '</a>';
}


?>

</div>

<div class="second-top-bar">
    <button onclick="window.location.href='#koszule'">Koszule</button>
    <button onclick="window.location.href='#spodnie'">Spodnie</button>
    <button onclick="window.location.href='#kurtki'">Kurtki</button>
    <button onclick="window.location.href='#buty'">Buty</button>
</div>