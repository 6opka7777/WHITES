// scripts.js

// Функция отправки данных поста на сервер
function createPost() {
    let postContent = document.querySelector('.create-post input[type="text"]').value;
    
    // Проверка наличия контента поста
    if (postContent.trim() !== '') {
        // В этом месте можно использовать AJAX или fetch для отправки данных на сервер
        // Пример использования fetch для отправки данных на сервер
        fetch('серверный_скрипт_для_обработки_поста.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ content: postContent }),
        })
        .then(response => {
            // Действия после успешной отправки
            console.log('Пост отправлен!');
            // Дополнительные действия, например, обновление списка постов
        })
        .catch(error => {
            // Обработка ошибок при отправке данных на сервер
            console.error('Ошибка при отправке поста:', error);
        });
    } else {
        alert('Пожалуйста, введите содержимое поста.');
    }
}

// Пример использования обработчика события для кнопки создания поста
document.querySelector('.create-post button').addEventListener('click', createPost);
