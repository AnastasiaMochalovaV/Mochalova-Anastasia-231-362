<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_POST['product_id']) || !isset($_POST['quantity']) || !is_numeric($_POST['product_id']) || !is_numeric($_POST['quantity'])) {
    header("Location: cart.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$_POST['product_id'];
$quantity_to_remove = (int)$_POST['quantity'];

$query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();
$cartItem = $result->fetch_assoc();

if ($cartItem) {
    $new_quantity = $cartItem['quantity'] - $quantity_to_remove;

    if ($new_quantity <= 0) {
        $query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ii", $user_id, $product_id);
    } else {
        $query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("iii", $new_quantity, $user_id, $product_id);
    }

    if ($stmt->execute()) {
        header("Location: cart.php");
        exit;
    } else {
        echo "Ошибка при обновлении корзины.";
    }
} else {
    header("Location: cart.php");
    exit;
}
?>
