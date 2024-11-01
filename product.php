<?php
include 'database.php';

// Получаем ID продукта и проверяем его
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Проверка, чтобы ID продукта был корректным
if ($product_id > 0) {
    // Подготавливаем и выполняем запрос
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    // Если продукт не найден, перенаправляем на страницу магазина
    if (!$product) {
        header("Location: shop.php");
        exit;
    }
} else {
    // Если ID не указан, перенаправляем на страницу магазина
    header("Location: shop.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <main>
        <div class="product-card">
            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p>Цена: <?php echo htmlspecialchars($product['price']); ?> руб.</p>
            <p>Описание: <?php echo htmlspecialchars($product['description']); ?></p>
            <p>В наличии: <?php echo htmlspecialchars($product['stock']); ?> шт.</p>
            <button onclick="addToCart(<?php echo $product['id']; ?>)">Добавить в корзину</button>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
