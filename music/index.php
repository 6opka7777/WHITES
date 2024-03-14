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
    <title>>WHITES|music</title>
    <link rel="icon" href="icon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="style.css">
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


    <div class="search-bar">
        <input class="find" type="text" id="search-input" placeholder="Поиск по названию">
        <button class="search-button" id="search-button">Поиск</button>
        <script src="script.js"></script>
    </div>

    

    <main class="container">
        
        <!-- Трек 1 -->
        <div class="track">
    <h3>Track_Name</h3>
    <p>Track_Lore</p>
    <audio controls>
        <source src="music/Track_File" type="audio/mpeg">
        Ваш браузер не поддерживает аудио элемент.
    </audio>
    </div>
</div>
    </main>

    <div class="info">
        WHITE'S|music - хорошая музыка, только у нас!
    </div>

    <script src="script.js"></script>
</body>
</html>
