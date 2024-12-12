<?php
include 'database.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = "Введите имя пользователя и пароль.";
        header("Location: login.php");
        exit;
    }

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $mysqli->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['success_message'] = "Вы успешно вошли в систему.";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error_message'] = "Неверный пароль.";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "Пользователь не найден.";
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
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
        <h1>Авторизация</h1>
        <form method="POST" action="">
            <label for="username">Имя пользователя:</label>
            <input type="text" name="username" required>

            <label for="password">Пароль:</label>
            <input type="password" name="password" required>

            <button type="submit">Войти</button>
        </form>
        <p>Нет аккаунта? <a href="register.php">Зарегистрироваться</a></p>
    </main>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div id="errorModal" class="modal">
            <div class="modal-content">
                <p><?php echo $_SESSION['error_message']; ?></p>
                <button class="modal-button" onclick="closeModal()">Закрыть</button>
            </div>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <script>
        window.onload = function() {
            var modal = document.getElementById("errorModal");
            if (modal) {
                modal.style.display = "block";
            }
        };

        function closeModal() {
            var modal = document.getElementById("errorModal");
            modal.style.display = "none";
        }
    </script>
</body>

</html>