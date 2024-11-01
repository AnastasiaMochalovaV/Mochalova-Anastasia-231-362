<?php
include 'database.php';
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Главная - Магазин</title>
  <link rel="stylesheet" href="styles/main.css">
  <script src="script.js" defer></script>
</head>

<body>
  <?php include 'header.php'; ?>

  <main>
    <section class="hero">
      <div class="hero-content">
        <h1>Цветы - Язык сердец, расцветай с нами</h1>
        <p>Удивите близких свежими цветами! В нашем магазине вы найдете идеальные букеты для любого случая: от романтических свиданий до праздничных событий. Наслаждайтесь удобной доставкой в любую точку города и делайте дни особенными с нашими цветами!</p>
        <button onclick="window.location.href='shop.php'">Перейти в каталог</button>
      </div>
    </section>

    <section class="products">
      <h2>Популярные товары</h2>
      <div class="product-list">
        <?php
        $query = "SELECT * FROM products LIMIT 3";
        $result = $mysqli->query($query);

        while ($product = $result->fetch_assoc()) {
          echo "
              <div class='product-card'>
                  <img src='images/{$product['image']}' alt='{$product['name']}'>
                  <h3>{$product['name']}</h3>
                  <p>Цена: {$product['price']} руб.</p>
                  <button onclick=\"window.location.href='product.php?id={$product['id']}'\">Подробнее</button>
              </div>
          ";
        }
        ?>
      </div>
    </section>
  </main>

  <?php include 'footer.php'; ?>
</body>

</html>