<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Погода</title>
</head>
<body>
    <h1>Проверка погоды</h1>
    <form method="GET" action="">
        <label for="city">Введите город:</label>
        <input type="text" id="city" name="city" required>
        <button type="submit">Узнать погоду</button>
    </form>

    <?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['city']) && !empty($_GET['city'])) {
    $city = htmlspecialchars($_GET['city']);
    $apiKey = "5c26a8f769a83b078238d58d6c764dcb"; // ключ OpenWeatherMap
    $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&units=metric&lang=ru&appid=" . $apiKey;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['cod']) && $data['cod'] == 200) {
        echo "<h2>Погода в городе: " . $data['name'] . "</h2>";
        echo "<p>Температура: " . $data['main']['temp'] . "°C</p>";
        echo "<p>Описание: " . ucfirst($data['weather'][0]['description']) . "</p>";
        echo "<p>Влажность: " . $data['main']['humidity'] . "%</p>";
        echo "<p>Скорость ветра: " . $data['wind']['speed'] . " м/с</p>";
    } elseif (isset($data['cod']) && $data['cod'] == 404) {
        echo "<p>Город не найден. Проверьте правильность ввода.</p>";
    } else {
        echo "<p>Ошибка при получении данных.</p>";
    }
}
?>
</body>
</html>