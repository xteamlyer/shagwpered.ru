<?php
session_start();
if (isset($_SESSION['Login'])) {
  header("Location: lk.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Студия «Шаг вперед» - Авторизация</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/login.css">
  <link rel="icon" type="image/x-icon" href="assets/images/logo.webp">
</head>

<body>
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
    <div class="login-container">
      <img src="assets/images/logo-black.webp" height="150px">
      <h2 id="formTitle">Авторизация</h2>
      <?php
      if (isset($_SESSION['error_message'])) {
        echo '<div id="error-message">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
      }
      ?>
      <form id="authForm" action="php/LoginProcess.php" method="post">
        <input type="text" name="Login" placeholder="Логин" required>
        <input type="password" name="Password" placeholder="Пароль" required>
        <button class="login-btn" type="submit">Войти</button>
      </form>
      <form id="regForm" action="php/register.php" method="post" style="display: none;">
        <input type="text" name="FullName" placeholder="ФИО" required>
        <input type="text" name="PhoneNumber" placeholder="Номер телефона" required>
        <input type="text" name="Login" placeholder="Логин" required>
        <input type="password" name="Password" placeholder="Пароль" required>
        <p class="PrivacyPolicy"><label><input type="checkbox" name="PrivacyPolicy" required>Вы соглашаетесь с <a href="privacy.php">политикой конфиденциальности?</a></label></p>
        <button class="login-btn" type="submit">Регистрация</button>
      </form>
      <button id="VKIDSDKAuthButton" class="VkIdWebSdk__button VkIdWebSdk__button_reset">
        <div class="VkIdWebSdk__button_container">
          <div class="VkIdWebSdk__button_icon">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M4.54648 4.54648C3 6.09295 3 8.58197 3 13.56V14.44C3 19.418 3 21.907 4.54648 23.4535C6.09295 25 8.58197 25 13.56 25H14.44C19.418 25 21.907 25 23.4535 23.4535C25 21.907 25
           19.418 25 14.44V13.56C25 8.58197 25 6.09295 23.4535 4.54648C21.907 3 19.418 3 14.44 3H13.56C8.58197 3 6.09295 3 4.54648 4.54648ZM6.79999 10.15C6.91798 15.8728 9.92951 19.31 14.8932 19.31H15.1812V16.05C16.989 16.2332 18.3371
           17.5682 18.8875 19.31H21.4939C20.7869 16.7044 18.9535 15.2604 17.8141 14.71C18.9526 14.0293 20.5641 12.3893 20.9436 10.15H18.5722C18.0747 11.971 16.5945 13.6233 15.1803 13.78V10.15H12.7711V16.5C11.305 16.1337 9.39237 14.3538 9.314 10.15H6.79999Z" fill="white" />
            </svg>
          </div>
          <div class="VkIdWebSdk__button_text">
            Войти через VK ID
          </div>
        </div>
      </button>
      <a id="switchForm" href="javascript:void(0);" onclick="toggleForm()">Нет аккаунта? Регистрация</a>
    </div>
  </div>
  <footer>
    <p>© <?php echo date("Y"); ?> Студия «Шаг вперёд». Все права защищены.</p>
  </footer>
  <script src="https:://unpkg.com/@vkid/sdk@<2.0.0/dist-sdk/umd/index.js"></script>
  <script src="js/Login.js"></script>
</body>

</html>