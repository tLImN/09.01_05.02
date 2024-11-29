<?php
    if (isset($_POST['scrollPosition'])) {
        setcookie('scrollPosition', $_POST['scrollPosition'], time() + 3600, "/");
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сохранение позиции прокрутки</title>
    <style>
        body {
            height: 2000px; /* Для демонстрации длинной страницы */
            margin: 0;
            padding: 0;
        }
    </style>
    <script>
        window.onload = function() {
            const scrollPosition = <?php echo isset($_COOKIE['scrollPosition']) ? $_COOKIE['scrollPosition'] : 0; ?>;
            window.scrollTo(0, scrollPosition);
        };

        window.onbeforeunload = function() {
            const scrollPosition = window.scrollY || document.documentElement.scrollTop;
            document.getElementById('scrollPosition').value = scrollPosition;
            document.getElementById('scrollForm').submit();
        };
    </script>
</head>
<body>
    <form id="scrollForm" method="post" style="display: none;">
        <input type="hidden" name="scrollPosition" id="scrollPosition" value="0">
    </form>
    <h1>Запоминание позиции прокрутки</h1>
    <p>Скролльте вниз и обновите страницу, чтобы проверить сохранение позиции прокрутки.</p>
</body>
</html>