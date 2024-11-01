<?php
session_start();
include 'database.php';

// Проверка, есть ли товары в корзине
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Добавление товара в корзину
if (isset($_GET['add'])) {
    $productId = intval($_GET['add']);
    if (!in_array($productId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $productId;
    }
}

// Удаление товара из корзины
if (isset($_GET['remove'])) {
    $productId = intval($_GET['remove']);
    if (($key = array_search($productId, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
}

// Получение товаров из корзины
$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', $_SESSION['cart']);
    $query = "SELECT * FROM products WHERE id IN ($ids)";
    $result = $mysqli->query($query);
    while ($product = $result->fetch_assoc()) {
        $cartItems[] = $product;
    }
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
    <?php include 'header.php'; ?>

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
                    <th>Действия</th>
                </tr>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><img src='../images/<?php echo $item['image']; ?>' alt='<?php echo $item['name']; ?>' width='100'></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['price']; ?> руб.</td>
                        <td>
                            <a href='cart.php?remove=<?php echo $item['id']; ?>'>Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>
