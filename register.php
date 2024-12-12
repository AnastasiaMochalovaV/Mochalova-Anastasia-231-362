<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    if (empty($username) || empty($password) || empty($email)) {
        echo "Все поля обязательны для заполнения.";
        exit;
    }

    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Пользователь с таким email уже существует.";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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
        <div class="navbar">
            <a href="index.php" class="logo">
                <img src="images/logo.png" alt="Мой Магазин" style="height: 15px;">
            </a>
            <nav id="auth-links">
                <a href="index.php">Главная</a>
                <a href="shop.php">Каталог</a>
                <a href="cart.php">Корзина</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php">Выход</a>
                <?php else: ?>
                    <a href="login.php">Авторизация</a>
                    <a href="register.php">Регистрация</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <h1>Регистрация</h1>
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