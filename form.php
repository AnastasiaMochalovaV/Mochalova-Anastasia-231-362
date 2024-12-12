<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Обратная связь</title>
  <link rel="stylesheet" href="styles/main.css">
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
        <?php if (isset($_SESSION['user'])): ?>
          <a href="logout.php">Выход</a>
        <?php else: ?>
          <a href="login.php">Авторизация</a>
          <a href="register.php">Регистрация</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <main>
    <h1>Форма обратной связи</h1>
    <div class="container">
      <form
        action="home.php"
        method="POST"
        enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="6" />

        <div class="form-group">
          <label class="form-label" for="name">ФИО</label>
          <input
            id="name"
            type="text"
            name="name"
            placeholder="Введите имя"
            value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>"
            required />
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Электронная почта</label>
          <input
            id="email"
            type="email"
            name="email"
            placeholder="Введите email"
            value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"
            required />
        </div>

        <div class="form-group">
          <p class="form-label">Как Вы узнали о нас?</p>
          <input
            type="radio"
            name="source"
            id="advertising"
            value="advertising"
            <?php echo (isset($_POST['source']) && $_POST['source'] == 'advertising') ? 'checked' : ''; ?>>
          <label for="advertising">Реклама в интернете</label>
          <input
            type="radio"
            name="source"
            id="friends"
            value="friends"
            <?php echo (isset($_POST['source']) && $_POST['source'] == 'friends') ? 'checked' : ''; ?>>
          <label for="friends">Рассказали знакомые</label>
        </div>

        <div class="form-group">
          <label class="form-label" for="category">Категория обращения</label>
          <select name="category" id="category">
            <option value="proposal">Предложение</option>
            <option value="grievance">Жалоба</option>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="message">Текст сообщения</label>
          <textarea
            name="message"
            id="message"
            cols="50"
            rows="5"
            placeholder="Введите сообщение"></textarea>
        </div>

        <div class="form-group">
          <label class="form-label" for="attachment">Вложение</label>
          <input type="file" name="attachment" id="attachment" />
        </div>

        <div class="form-group">
          <input
            type="checkbox"
            name="agreement"
            id="agreement"
            value="yes" />
          <label for="agreement">Даю согласие на обработку персональных данных</label>
        </div>

        <input class="button-main" type="submit" value="Отправить" />
      </form>
    </div>
  </main>
</body>

</html>