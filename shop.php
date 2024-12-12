<?php
include 'database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин</title>
    <link rel="stylesheet" href="styles/shop.css">
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
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="logout.php">Выход</a>
                <?php else: ?>
                    <a href="login.php">Авторизация</a>
                    <a href="register.php">Регистрация</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main>
        <h2>Каталог товаров</h2>
        <table class="product-table">
            <tr>
                <th>Изображение</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Описание</th>
            </tr>
            <?php
            $query = "SELECT * FROM products";
            $result = $mysqli->query($query);

            if ($result && $result->num_rows > 0) {
                while ($product = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td><img src='images/{$product['image']}' alt='{$product['name']}' width='100'></td>
                            <td><a href='product.php?id={$product['id']}'>{$product['name']}</a></td>
                            <td>{$product['price']} руб.</td>
                            <td>{$product['description']}</td>
                        </tr>
                    ";
                }
            } else {
                echo "<tr><td colspan='4'>Товары не найдены.</td></tr>";
            }
            ?>
        </table>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>