<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Хешируем пароль
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Подготовка и выполнение запроса
    $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sss", $username, $hashed_password, $email);

    if ($stmt->execute()) {
        echo "Регистрация прошла успешно!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="styles/form.css">
</head>
<body>
    <header>
        <h1>Регистрация</h1>
    </header>

    <main>
        <form method="POST" action="">
            <label for="username">Имя пользователя:</label>
            <input type="text" name="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Пароль:</label>
            <input type="password" name="password" required>

            <button type="submit">Зарегистрироваться</button>
        </form>
        <p>Уже зарегистрированы? <a href="login.php">Войти</a></p>
    </main>
</body>
</html>
