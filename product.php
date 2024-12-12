<?php
include 'database.php';
session_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: shop.php");
    exit;
}

$product_id = (int)$_GET['id'];

$query = "SELECT * FROM products WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header("Location: shop.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if ($quantity > 0) {
        $query = "SELECT stock FROM products WHERE id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product_data = $result->fetch_assoc();

        if ($product_data && $product_data['stock'] >= $quantity) {
            $query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("ii", $user_id, $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $cartItem = $result->fetch_assoc();

            if ($cartItem) {
                $new_quantity = $cartItem['quantity'] + $quantity;
                $query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
            } else {
                $query = "INSERT INTO cart (user_id, product_id, quantity, date_added) VALUES (?, ?, ?, NOW())";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("iii", $user_id, $product_id, $quantity);
            }

            if ($stmt->execute()) {
                header("Location: cart.php");
                exit;
            } else {
                $error_message = "Ошибка добавления товара в корзину.";
            }
        } else {
            $error_message = "Недостаточно товара на складе.";
        }
    } else {
        $error_message = "Некорректное количество.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Магазин</title>
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
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <div class="product-details">
            <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" width="300">
            <div class="product-info">
                <p><strong>Цена:</strong> <?php echo $product['price']; ?> руб.</p>
                <p><strong>Описание:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <form action="product.php?id=<?php echo $product_id; ?>" method="POST">
                    <label for="quantity">Количество:</label>
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                    <button type="submit">Добавить в корзину</button>
                </form>
                <?php if (isset($error_message)): ?>
                    <p class="error"><?php echo $error_message; ?></p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
