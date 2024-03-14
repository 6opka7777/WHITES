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
    <title>WHITES|server</title>
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
<script src="https://api.trademc.org/trademcapi.js"></script>
<div id="trademc-buyform"></div>
<div class="rounded-box">
    <script>
/*API TRADE MC*/
    </script>
</div>

<div id="launcher-info" style="float: right; max-width: 300px; margin-top: 20px;">
  <p>WHITES - это уникальный Minecraft проект с оригинальными возможностями и эксклюзивными контентом. Наш лаунчер обеспечивает легкий доступ к миру WHITES, где вас ждут увлекательные приключения и креативные возможности.</p>
  <a href="#" class="download-button">Скачать лаунчер</a>
</div>


</body>
</html>