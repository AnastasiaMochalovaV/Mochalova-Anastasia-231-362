<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Вы не авторизованы']);
    exit;
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(['success' => false, 'message' => 'Некорректные данные']);
    exit;
}

$query = "SELECT stock FROM products WHERE id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo json_encode(['success' => false, 'message' => 'Продукт не найден']);
    exit;
}

if ($product['stock'] < $quantity) {
    echo json_encode(['success' => false, 'message' => 'Недостаточно товара на складе']);
    exit;
}

$query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ii", $_SESSION['user_id'], $product_id);
$stmt->execute();
$result = $stmt->get_result();
$cartItem = $result->fetch_assoc();

if ($cartItem) {
    $new_quantity = $cartItem['quantity'] + $quantity;
    $query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("iii", $new_quantity, $_SESSION['user_id'], $product_id);
} else {
    $query = "INSERT INTO cart (user_id, product_id, quantity, date_added) VALUES (?, ?, ?, NOW())";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("iii", $_SESSION['user_id'], $product_id, $quantity);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Товар добавлен в корзину']);
} else {
    echo json_encode(['success' => false, 'message' => 'Ошибка добавления товара']);
}
?>