
<?php
session_start();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit;
}

function handleLikeDislike($action, $post_id) {
    // Подключение к базе данных (вставьте ваши реальные данные)
    $conn = new mysqli("DataBase_IpAdress", "ataBase_Username", "DataBase_Password", "DataBase_Name");

    // Проверка подключения
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

    // Проверка, голосовал ли пользователь за этот пост
    $voted_posts = isset($_SESSION['voted_posts']) ? $_SESSION['voted_posts'] : array();

    if (in_array($post_id, $voted_posts)) {
        // Если пользователь уже голосовал за этот пост, не даем ему голосовать снова
        echo "<span id='already-voted'>Вы уже проголосовали за этот пост.</span>";
        echo "<script>
                setTimeout(function() {
                    document.getElementById('already-voted').style.display = 'none';
                }, 3000); // Скрыть сообщение через 3 секунды (3000 миллисекунд)
              </script>";
        return;
    }

    if ($action === 'like') {
        $sql = "UPDATE posts SET likes = likes + 1 WHERE post_id = $post_id";
    } elseif ($action === 'dislike') {
        $sql = "UPDATE posts SET dislikes = dislikes + 1 WHERE post_id = $post_id";
    }

    if ($conn->query($sql) === TRUE) {
        // Сохраняем информацию о голосе пользователя в сессии
        $voted_posts[] = $post_id;
        $_SESSION['voted_posts'] = $voted_posts;

        header("Location: ".$_SERVER['PHP_SELF']); // Перенаправление на эту же страницу после обработки
        exit;
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['like'])) {
        $post_id = $_POST['post_id'];
        handleLikeDislike('like', $post_id);
    } elseif (isset($_POST['dislike'])) {
        $post_id = $_POST['post_id'];
        handleLikeDislike('dislike', $post_id);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>WHITES |Новостная страница</title>
    <!-- Подключение CSS-стилей -->
    <link rel="icon" href="icon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<!-- Скрипт для автоматического скрытия сообщения -->
    <script>
        setTimeout(function() {
            var alreadyVoted = document.getElementById('already-voted');
            if (alreadyVoted) {
                alreadyVoted.style.display = 'none';
            }
        }, 3000); // Скрыть сообщение через 3 секунды (3000 миллисекунд)
    </script>
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
        
        <!-- Полоска для создания поста -->
        <div class="create-post" style="border-radius: 10px; background-color: #f2f2f2; padding: 10px;">
            <?php
            if (isset($_SESSION['username'])) {
                echo '<form method="post" action="">';
                echo '<input type="text" name="post_content" placeholder="Создать пост">';
                echo '<button type="submit" name="submit_post">Опубликовать</button>';
                echo '</form>';

                if (isset($_POST['submit_post'])) { if (isset($_POST['submit_post'])) {
                    if (!empty(trim($_POST['post_content']))) {
                        $new_post_content = $_POST['post_content'];
                        $username = $_SESSION['username'];

                        $servername = "DataBase_IpAdress";
                        $username = "DataBase_Username";
                        $password = "DataBase_Password";
                        $dbname = "DataBase_Name";

                        $conn = new mysqli($servername, $username_db, $password_db, $dbname);

                        if ($conn->connect_error) {
                            die("Ошибка подключения: " . $conn->connect_error);
                        }

                        $table_name = "posts";
                        $sql = "INSERT INTO $table_name (username, post_content, likes, dislikes) VALUES ('$username', '$new_post_content', 0, 0)";

                        if ($conn->query($sql) === TRUE) {
                            echo "<p id='success_message'>Пост успешно опубликован.</p>"; // ID сообщения для управления через JavaScript
                            echo "<script>
                                    setTimeout(function() {
                                        document.getElementById('success_message').style.display = 'none'; // Скрыть сообщение через 5 секунд
                                    }, 5000);
                                  </script>";
                        } else {
                            echo "Ошибка: " . $sql . "<br>" . $conn->error;
                        }

                        $conn->close();
                    } else {
                        echo "<p>Введите текст поста.</p>";
                    }
                }
            }
            }
            ?>
        </div>
    </header>

    <!-- Стили для блока поста -->
    <style>
        .post {
            border-radius: 10px;
            background-color: #1b1b1b9d;
            padding: 10px;
            margin-top: 10px;
        }
    </style>

    <main>
        <!-- Блок с постами пользователей -->
        <div class="user-posts">
            <?php
            // Подключение к базе данных (используйте ваши реальные данные для подключения)
            $servername = "DataBase_IpAdress";
            $username = "DataBase_Username";
            $password = "DataBase_Password";
            $dbname = "DataBase_Name";


            // Создание соединения с базой данных
            $conn = new mysqli($servername, $username_db, $password_db, $dbname);

            // Проверка соединения
            if ($conn->connect_error) {
                die("Ошибка подключения: " . $conn->connect_error);
            }

            // SQL-запрос для выборки постов пользователей
            $sql = "SELECT * FROM posts";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Вывод данных каждого поста
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="post">';
                    echo '<p><strong>' . $row['username'] . '</strong>: ' . $row['post_content'] . '</p>';
                    echo '<div class="like-buttons">';
                    echo '<form method="post" action="">';
                    echo '<input type="hidden" name="post_id" value="' . $row['post_id'] . '">';
                    echo '<button type="submit" name="like">👍 ' . $row['likes'] . '</button>';
                    echo '<button type="submit" name="dislike">👎 ' . $row['dislikes'] . '</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "Нет постов, может ты его напишишь первым?";
            }
            $conn->close();
            ?>
        </div>
    </main>

    <!-- Скрипт для скрытия сообщения через 5 секунд -->
    <script>
        setTimeout(function() {
            document.getElementById('success-message').style.display = 'none';
        }, 5000);
    </script>



    <!-- Подключение скриптов JavaScript -->
    <script src="scripts.js"></script>
</body>
</html>
