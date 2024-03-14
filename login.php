<?php

session_start();



// Подключение к базе данных (замените значения на ваши)

$servername = "DataBase_IpAdress";
$username = "DataBase_Username";
$password = "DataBase_Password";
$dbname = "DataBase_Name";




$conn = new mysqli($servername, $username, $password, $dbname);



if ($conn->connect_error) {

  die("Connection failed: " . $conn->connect_error);

}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];

    $password = $_POST['password'];



    $sql = "SELECT * FROM users WHERE username='$username'";

    $result = $conn->query($sql);



    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {

            $_SESSION['username'] = $username;

            header('Location: ../news/news.php');

            exit();

        } else {

            echo '<div class="error-message">Пароль не верный.</div>';

        }

    } else {

        echo '<div class="error-message">Пользователь не найден.</div>';

    }



    $conn->close();

}

?>

