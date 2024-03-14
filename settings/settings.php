<?php
session_start();

// Подключение к базе данных - замените значения на свои
$servername = "DataBase_IpAdress";
$username = "DataBase_Username";
$password = "DataBase_Password";
$dbname = "DataBase_Name";


$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
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

// Обработка смены пароля
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    // Замените "your_users_table" на имя вашей таблицы с пользователями
    // и "your_password_column" на имя колонки, в которой хранится хэш пароля
    $query = "SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password_hash);
        $stmt->fetch();

        // Проверяем, соответствует ли введенный старый пароль хэшу в базе данных
        if (password_verify($old_password, $stored_password_hash)) {
            // Старый пароль верный, можно обновлять пароль в базе данных

            // Хэшируем новый пароль перед обновлением
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

            // Обновляем пароль в базе данных
            $update_query = "UPDATE users SET password = ? WHERE username = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ss", $new_password_hashed, $_SESSION['username']);
            $update_stmt->execute();

            echo '<div class="success-message">Пароль успешно изменен.</div>';
        } else {
            echo '<div class="error-message">Неверный старый пароль.</div>';
        }
    } else {
        echo '<div class="error-message">Пользователь не найден.</div>';
    }

    $stmt->close();
}

// Обработка смены электронной почты
if (isset($_POST['change_email'])) {
    $new_email = $_POST['new_email'];
    $password = $_POST['password'];

    // Замените "your_users_table" на имя вашей таблицы с пользователями
    // и "your_password_column" на имя колонки, в которой хранится хэш пароля
    $query = "SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($stored_password_hash);
        $stmt->fetch();

        // Проверяем, соответствует ли введенный пароль хэшу в базе данных
        if (password_verify($password, $stored_password_hash)) {
            // Пароль верный, можно обновлять электронную почту в базе данных

            // Обновляем электронную почту в базе данных
            $update_query = "UPDATE users SET email = ? WHERE username = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ss", $new_email, $_SESSION['username']);
            $update_stmt->execute();

            echo '<div class="success-message">Электронная почта успешно изменена.</div>';
        } else {
            echo '<div class="error-message">Неверный пароль.</div>';
        }
    } else {
        echo '<div class="error-message">Пользователь не найден.</div>';
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<div class="settings-container">
    <div class="change-password-container">
        <h2>Смена пароля</h2>
        <form method="post" action="">
            <label for="old_password">Старый пароль:</label>
            <input type="password" name="old_password" required>

            <label for="new_password">Новый пароль:</label>
            <input type="password" name="new_password" required>

            <input type="submit" name="change_password" value="Сменить пароль">
        </form>
    </div>

    <div class="change-email-container">
        <h2>Смена электронной почты</h2>
        <form method="post" action="">
            <label for="new_email">Новая электронная почта:</label>
            <input type="email" name="new_email" required>

            <label for="password">Пароль:</label>
            <input type="password" name="password" required>

            <input type="submit" name="change_email" value="Сменить эл.почту">
        </form>
    </div>

    <?php
    // Проверка статуса пользователя и вывод блока админ-панели
    if ($user_status == 'admin') {
        echo '<div class="admin-panel"><a href="../admin_@sdasjwkhjsud&2sdjkasdhwhashducgasdgwyustsasdhtgcyushdhwedhuiau/all_panels/admin_panel.php">Админ-панель</a></div>';
    }
    ?>
</div>

<script>
    // Скрипт для автоматического скрытия уведомлений об успешном и неуспешном изменении через 5 секунд
    setTimeout(function () {
        var successMessages = document.querySelectorAll('.success-message');
        for (var i = 0; i < successMessages.length; i++) {
            successMessages[i].style.display = 'none';
        }

        var errorMessages = document.querySelectorAll('.error-message');
        for (var j = 0; j < errorMessages.length; j++) {
            errorMessages[j].style.display = 'none';
        }
    }, 5000);
</script>
</body>
</html>
