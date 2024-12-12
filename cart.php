<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cartItems = [];

$query = "SELECT c.product_id, c.quantity, p.name, p.price, p.image 
          FROM cart c 
          JOIN products p ON c.product_id = p.id 
          WHERE c.user_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($item = $result->fetch_assoc()) {
    $cartItems[] = $item;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина - Магазин</title>
    <link rel="stylesheet" href="styles/cart.css">
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
        <h2>Корзина</h2>
        <?php if (empty($cartItems)): ?>
            <p>Ваша корзина пуста.</p>
        <?php else: ?>
            <table class="cart-table">
                <tr>
                    <th>Изображение</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Количество</th>
                    <th>Итого</th>
                    <th>Действия</th>
                </tr>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><img src="images/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" width="100"></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['price']; ?> руб.</td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo $item['price'] * $item['quantity']; ?> руб.</td>
                        <td>
                            <form action="update_cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                <input type="number" name="quantity" min="1" max="<?php echo $item['quantity']; ?>" value="1">
                                <button type="submit">Удалить</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </main>
</body>

</html>