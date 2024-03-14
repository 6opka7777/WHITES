<?php
session_start();

$servername = "DataBase_IpAdress";
$username = "DataBase_Username";
$password = "DataBase_Password";
$dbname = "DataBase_Name";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login_button'])) {
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
                echo '<div id="error-message" class="error-message">Пароль не верный.</div>';
            }
        } else {
            echo '<div id="error-message" class="error-message">Пользователь не найден.</div>';
        }
    }

    if (isset($_POST['register_button'])) {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, username, password, email) VALUES ('$name', '$username', '$hashedPassword', '$email')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['username'] = $username;
            header('Location: ../news/news.php');
            exit();
        } else {
            echo '<div id="error-message" class="error-message">Ошибка при регистрации: ' . $conn->error . '</div>';
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WHITES</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <style>
      #error-message {
      background-color: #f44336;
      color: #fff;
      text-align: center;
      margin-top: 10px;
      padding: 10px;
      border-radius: 5px;
}
    </style>
</head>
<body>

<header class="header">
    <h1 class="logo">WHITE'S</h1>
</header>

<main class="main-content">
    <div class="container">
        <?php
        if (isset($_SESSION['username'])) {
            echo '<div class="auth-form"><button onclick="location.href=\'news/news.php\'">Привет, ' . $_SESSION['username'] . '!</button></div>';
        } else {
            echo '
            <div class="auth-form" id="login-form">
                <h2>Вход</h2>
                <form action="index.php" method="POST">
                    <input type="text" name="username" placeholder="Логин" required>
                    <input type="password" name="password" placeholder="Пароль" required>
                    <button type="submit" name="login_button">Войти</button>
                </form>
            </div>
            <div class="auth-form" id="registration-form">
                <h2>Регистрация</h2>
                <form action="index.php" method="POST">
                    <input type="text" name="name" placeholder="Имя" required>
                    <input type="text" name="username" placeholder="Логин" required>
                    <input type="password" name="password" placeholder="Пароль" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <button type="submit" name="register_button">Зарегистрироваться</button>
                </form>
            </div>';
        }
        ?>
    </div>
</main>

<script>
    // Скрипт для автоматического скрытия уведомлений об ошибке через 5 секунд
    setTimeout(function() {
        var errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.display = 'none';
        }
    }, 5000);
</script>

</body>
</html>
