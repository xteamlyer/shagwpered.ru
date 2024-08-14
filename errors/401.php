<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Студия «Шаг вперед»</title>
  <link rel="icon" type="image/x-icon" href="../assets/images/logo.webp">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>
  <div class="wrapper">
    <header>
      <div class="header-content">
        <a href="../index.php" class="logo"><img src="../assets/images/logo.webp" class="logo"></a>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>
        <nav>
          <ul class="menu">
            <li><a href="../index.php">Главная</a></li>
            <li><a href="../news.php">Новости</a></li>
            <li><a href="../lk.php">Личный кабинет</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <div class="content">
      <div class="banner-text" style="color: black;">
        <h2>Ошибка 401</h2>
        <p>Для доступа нужно авторизоваться</p>
      </div>
    </div>
    <footer>
      <p>© <?php echo date("Y"); ?>Студия «Шаг вперед». Все права защищены.</p>
    </footer>
  </div>
</body>

</html>