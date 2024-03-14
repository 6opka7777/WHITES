
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="icon.ico" type="image/x-icon">
     <link rel="stylesheet" href="styles.css">
    <title>WHITES |Пользователи</title>
    <style>
        /* Стили для блока пользователей */
        .user-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 20px;
        }

        .user-box {
            border-radius: 10px;
            background-color: #f2f2f2;
            padding: 20px;
            margin-bottom: 20px;
            width: 300px;
            text-align: center;
        }

        .status {
            width: 100px;
            height: 20px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            margin-top: 5px;
            padding: 3px;
        }
    </style>
</head>
<body>
    <!-- Хедер -->
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

    <!-- Блок пользователей -->
    <div class="user-container">
        <?php
        // Подключение к базе данных
        $servername = "DataBase_IpAdress";
        $username = "DataBase_Username";
        $password = "DataBase_Password";
        $dbname = "DataBase_Name";


        // Создание соединения с базой данных
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Проверка соединения
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL запрос для извлечения пользователей с их статусами
        $sql = "SELECT id, name, status FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Вывод данных каждого пользователя с их статусами
            while ($row = $result->fetch_assoc()) {
                echo '<div class="user-box">';
                echo '<h2>' . $row["name"] . '</h2>';
                echo '<p>ID: ' . $row["id"] . '</p>';
                // Отображение статуса в зависимости от значения
                switch ($row["status"]) {
                    case 'user':
                        echo '<div class="status" style="background: rgba(0, 255, 163, 0.70);">Пользователь</div>';
                        break;
                    case 'plus':
                        echo '<div class="status" style="background: rgba(250, 255, 0, 0.90);">Plus</div>';
                        break;
                    case 'admin':
                        echo '<div class="status" style="background: rgba(255, 0, 0, 0.70);">ADMIN\'S</div>';
                        break;
                    default:
                        echo '<div class="status">Неизвестный статус</div>';
                }
                echo '</div>';
            }
        } else {
            echo "0 результатов";
        }

        // Закрытие соединения с базой данных
        $conn->close();
        ?>
    </div>

    <!-- Блок информации -->
    <div class="information">
        <!-- Ваш контент с информацией -->
    </div>
</body>
</html>
