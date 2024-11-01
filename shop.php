<?php
include 'database.php';
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
    <?php include 'header.php'; ?>

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
            // Получение списка товаров
            $query = "SELECT * FROM products";
            $result = $mysqli->query($query);

            // Проверка на наличие товаров
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
                echo "<tr><td colspan='4'>Товары не найдены.</td></tr>"; // Сообщение, если товаров нет
            }
            ?>
        </table>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>