<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
    header("Location: cart.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$_GET['product_id'];

$query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);

if ($stmt->execute()) {
    header("Location: cart.php");
    exit;
} else {
    echo "Ошибка при удалении товара из корзины.";
}
?>
