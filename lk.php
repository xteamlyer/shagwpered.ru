<?php
session_start();
if (!isset($_SESSION['Login'])) {
  header("Location: login.php");
  exit();
}
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['message']);
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Студия «Шаг вперед» - Личный кабинет</title>
  <link rel="icon" type="image/x-icon" href="assets/images/logo.webp">
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/lk.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
  <script src="js/GetUserData.js"></script>
  <script src="js/GetEvent.js"></script>
  <script src="js/Calendar.js"></script>
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
            <li><a href="php/logout.php">Выйти</a></li>
          </ul>
        </nav>
      </div>
    </header>
    <div class="content lk">
      <h2>Привет, <span id="FullName"></span>!</h2>
      <div id="user-info" class="user-info">
        <?php if ($message) : ?>
          <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if ($error) : ?>
          <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        <p><strong>Имя:</strong> <span id="userFullName"></span></p>
        <p><strong>Телефон:</strong> <span id="userPhoneNumber"></span></p>
        <p><strong>Логин:</strong> <span id="userLogin"></span></p>
        <button id="edit-user-info">Изменить данные</button>
        <button id="link-vk">Привязать VK ID</button>
      </div>
      <div id="link-vk-modal" style="display: none;">
        <p>Вы уверены, что хотите привязать аккаунт VK?</p>
        <button id="confirm-link-vk">Да, привязать</button>
        <button id="close-link-vk">Отмена</button>
      </div>
      <div id="edit-user-info-modal" style="display: none;">
        <form id="edit-user-info-form">
          <p><strong>Имя:</strong> <input type="text" id="editFullName" name="FullName"></p>
          <p><strong>Телефон:</strong> <input type="text" id="editPhoneNumber" name="PhoneNumber"></p>
          <p><strong>Пароль:</strong> <input type="password" id="editPassword" name="Password"></p>
          <p><strong>Подтвердите Пароль:</strong> <input type="password" id="confirmPassword" name="ConfirmPassword"></p>
          <button type="submit">Сохранить изменения</button>
          <button type="button" id="close-edit-popup">Закрыть</button>
        </form>
      </div>
      <h3>Ваш календарь занятий:</h3>
      <div id='calendar'></div>
      <div id="event-info" style="display: none;">
        <p>Дата: <span id="event-date-info"></span></p>
        <p>Направление: <span id="event-title"></span></p>
        <button id="close-popup">Закрыть</button>
        <button id="delete-event">Удалить занятие</button>
      </div>
      <div id="add-event-modal" style="display: none;">
        <form id="add-event-form">
          <p>Дата: <input type="date" id="event-date" name="event-date"></p>
          <p>
            <label for="instructor">Инструктор:</label>
            <select id="instructor" name="instructor">
            </select>
          </p>
          <p>
            <label for="theme">Направление:</label>
            <select id="theme" name="theme">
            </select>
          </p>
          <p>Время:
            <select id="event-time" name="event-time"></select>
          </p>
          <button id="add-event-btn" type="submit" disabled>
            Добавить
          </button>
          <button type="button" id="close-add-popup">Закрыть</button>
        </form>
      </div>
    </div>
    <footer>
      <p>© <?php echo date("Y"); ?> Студия «Шаг вперёд». Все права защищены.</p>
    </footer>
  </div>
</body>

</html>