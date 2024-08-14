<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Фитнес-студия «Шаг Вперед»</title>
  <link rel="icon" type="image/x-icon" href="assets/images/logo.webp">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/news.css">
</head>

<body>
  <div class="wrapper">
    <header>
      <div class="header-content">
        <a href="index.php" class="logo"><img src="assets/images/logo.webp" class="logo"></a>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>
        <nav>
          <ul class="menu">
            <li><a href="index.php">Главная</a></li>
            <li><a href="news.php">Новости</a></li>
            <li><a href="lk.php">Личный кабинет</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <div class="content">
      <h1 style="text-align: center; padding-top: 30px;">Конфиденциальность и защита данных 🛡️</h1>
      <h3 style="text-align: center;">Политика конфиденциальности</h3>
      <section class="news-section">
        <p><strong>Цель Сбора Данных:</strong> Мы собираем данные для регистрации пользователей и обработки заказов.</p>
        <p><strong>Собираемые Данные:</strong> В процессе работы с нами мы запрашиваем ФИО и номер телефона.</p>
        <p><strong>Использование Данных:</strong> Ваши данные никогда не будут переданы третьим лицам. Они используются исключительно для обеспечения работы нашей цифровой инфраструктуры.</p>
        <p><strong>Хранение Данных:</strong> Ваши данные хранятся на удаленном сервере, соответствующем всем последним стандартам безопасности.</p>
        <p><strong>Права Пользователя:</strong> Вы имеете право запросить список ваших данных, которые мы храним. Также вы можете потребовать удаления ваших данных по вашему запросу.</p>
        <p><strong>Согласие с Политикой:</strong> Пройдя процесс авторизации и регистрации, вы обязательно подтверждаете свое согласие с нашей политикой конфиденциальности.</p>
        <p><strong>Контактная информация:</strong> Если у вас возникнут вопросы, вы всегда можете обратиться к нам по номеру <a href="tel:8800553535">8800553535</a> или по Email: <a href="mailto:info@shagwpered.ru">info@shagwpered.ru</a></p>
      </section>
    </div>
    <footer>
      <p>© <?php echo date("Y"); ?> Студия «Шаг вперёд». Все права защищены.</p>
    </footer>
  </div>
</body>

</html>