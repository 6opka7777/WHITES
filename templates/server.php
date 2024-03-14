<?php
session_start();

// Подключение к базе данных - замените значения на свои
$servername = "185.103.101.169";
$username = "whites-mysql";
$password = "root-mysql";
$dbname = "whites";

// Создание соединения с базой данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ваш код для разлогинивания пользователя
if (isset($_POST['logout'])) {
    // Дополнительные действия перед разлогиниванием, если необходимо
    // Например, выполнение каких-то действий в базе данных или другие операции

    // Очистка переменных сессии
    session_unset();

    // Разрушение сессии
    session_destroy();

    // Дополнительные действия после разлогинивания, если необходимо
    // Например, перенаправление на другую страницу или вывод сообщения

    // Перенаправление на страницу авторизации
    header("Location: ../index.php");
    exit;
}

// Проверка статуса пользователя
$user_status = '';
if (isset($_SESSION['username'])) {
    $query_status = "SELECT status FROM users WHERE username = ?";
    $stmt_status = $conn->prepare($query_status);
    $stmt_status->bind_param("s", $_SESSION['username']);
    $stmt_status->execute();
    $stmt_status->bind_result($user_status);
    $stmt_status->fetch();
    $stmt_status->close();
}

// Закрытие соединения с базой данных
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>WHITES|settings</title>
    <link rel="icon" href="icon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../templates/styles.css">
</head>
<body>

<header>
        <!-- Имя пользователя, статус и кнопка авторизации -->
    <div class="user-info">
        <?php
        if (isset($_SESSION['username'])) {
            echo 'Привет, ' . $_SESSION['username'];
            
            // Вывод статуса пользователя
            echo '<div class="status ';
switch ($user_status) {
    case 'user':
        echo 'user">Пользователь';
        break;
    case 'plus':
        echo 'plus">Plus';
        break;
    case 'admin':
        echo 'admin">ADMIN\'S';
        break;
    default:
        echo 'unknown">Неизвестный статус';
}
echo '</div>';
            
            // Вывод кнопки разлогинивания
            echo '<form method="post" action="">
                    <input type="submit" name="logout" value="Выйти из профиля">
                </form>';
            
            // Добавляем ссылку на страницу настроек
            echo '<a href="../settings/settings.php">Дополнительно</a>';
        } else {
            echo '<button onclick="location.href=\'../index.php\'">Авторизация</button>';
        }
        ?>
    </div>

<h1 class="JDH">WHITE'S</h1>

        
        <!-- Блок сервисов -->
        <nav class="services">
            <ul>
                <li><a class="a" href="../news/news.php">Новости</a></li>
                <li><a class="a" href="../music/index.php">Музыка</a></li>
                <li><a class="a" href="#">Чаты</a></li>
                <li><a class="a" href="../profile/profile.php">Пользователи</a></li>
                <li><a class="a" href="../server/server.php">Проект</a></li>
            </ul>
        </nav>

</header>