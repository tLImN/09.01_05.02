<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['theme'])) {
        setcookie("theme", $_POST['theme'], time() + (30 * 24 * 60 * 60));
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

$currentTheme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : "не выбрана";
?>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тема сайта</title>
    <style>
        body.light {
            background-color: #f4f4f4;
            color: #000;
        }
        body.dark {
            background-color: #000;
            color: #f4f4f4;
        }
    </style>
</head>
<body class="<?= htmlspecialchars($currentTheme) ?>">
    <h1>Выбор темы для сайта</h1>
    <p>Текущая тема: <strong><?= htmlspecialchars($currentTheme) ?></strong></p>
    <form method="post">
        <button class="light-theme-btn" name="theme" value="light">Светлая тема</button>
        <button class="dark-theme-btn" name="theme" value="dark">Темная тема</button>
    </form>
</body>
</html>