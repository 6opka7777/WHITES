<?php
session_start();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>WHITES|settings</title>
    <link rel="icon" href="icon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<header>
        <!-- Имя пользователя или кнопка авторизации -->
        <div class="user-info">
    <?php
    if (isset($_SESSION['username'])) {
        echo 'Привет, ' . $_SESSION['username'];
        echo '<form method="post" action="">
                <input type="submit" name="logout" value="Выйти из профиля">
            </form>';
        
        // Добавляем ссылку на страницу настроек
        echo '<a href="../htdocs/settings/settings.php">Дополнительно</a>';
    } else {
        echo '<button onclick="location.href=\'../htdocs/index.php\'">Авторизация</button>';
    }
    ?>
</div>

<h1 class="JDH">WHITE'S</h1>

        
        <!-- Блок сервисов -->
        <nav class="services">
            <ul>
                <li><a class="a" href="../htdocs/news/news.php">Новости</a></li>
                <li><a class="a" href="../htdocs/music/index.php">Музыка</a></li>
                <li><a class="a" href="#">Чаты</a></li>
                <li><a class="a" href="../htdocs/profile/profile.php">Пользователи</a></li>
                <li><a class="a" href="../server/server.php">Проект</a></li>
            </ul>
        </nav>

</header>