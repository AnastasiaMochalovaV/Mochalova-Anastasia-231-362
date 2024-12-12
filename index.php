<?php
include 'database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Главная - Магазин</title>
  <link rel="stylesheet" href="styles/main.css">
  <script defer>
    window.onload = function () {
      const modal = document.getElementById("successModal");
      if (modal) {
        modal.style.display = "block";
      }
    };

    function closeModal() {
      const modal = document.getElementById("successModal");
      if (modal) {
        modal.style.display = "none";
      }
    }
  </script>
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
    <?php if (isset($_SESSION['success_message'])): ?>
      <div id="successModal" class="modal">
        <div class="modal-content">
          <span class="close" onclick="closeModal()">&times;</span>
          <p><?php echo $_SESSION['success_message']; ?></p>
        </div>
      </div>
      <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

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