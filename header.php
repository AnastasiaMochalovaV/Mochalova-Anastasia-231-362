<?php
session_start(); // Начинаем сессию
?>

<header>
    <div class="navbar">
        <a href="index.php" class="logo">
            <img src="images/logo.png" alt="Мой Магазин" style="height: 15px;">
            <nav>
                <a href="index.php">Главная</a>
                <a href="shop.php">Каталог</a>
                <?php if (isset($_SESSION['user'])): // Проверяем, авторизован ли пользователь 
                ?>
                    <a href="cart.php">Корзина</a>
                    <a href="logout.php">Выход</a>
                <?php else: ?>
                    <a href="login.php">Авторизация</a>
                    <a href="register.php">Регистрация</a>
                <?php endif; ?>
            </nav>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Проверяем наличие переменной сессии
        const userLoggedIn = <?php echo json_encode(isset($_SESSION['user'])); ?>;

        const authLinks = document.getElementById("auth-links");

        if (userLoggedIn) {
            // Если пользователь авторизован, показываем корзину и выход
            authLinks.innerHTML = `
            <a href="cart.php">Корзина</a>
            <a href="logout.php">Выход</a>
        `;
        } else {
            // Если пользователь не авторизован, показываем авторизацию и регистрацию
            authLinks.innerHTML = `
            <a href="login.php">Авторизация</a>
            <a href="register.php">Регистрация</a>
        `;
        }
    });
</script>