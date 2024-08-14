<?php
require_once('php/db.php');
$dbConnection = new DBConnection();
$dbConnection->connect();
$conn = $dbConnection->getConnection();
function truncateText($text, $wordLimit)
{
  $words = explode(" ", $text);
  if (count($words) > $wordLimit) {
    return implode(" ", array_slice($words, 0, $wordLimit)) . "...";
  } else {
    return $text;
  }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Студия «Шаг вперед» | Архангельск | Фитнес и ОФП</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/index.css">
  <link rel="icon" type="image/x-icon" href="assets/images/logo.webp">
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
      <div class="banner">
        <div class="banner-text">
          <h2>Студия «Шаг вперед»</h2>
          <p>Архангельск | Фитнес и ОФП</p>
          <div class="reg-btn"><a href="lk.php">Записаться</a></div>
        </div>
      </div>
      <div class="sections">
        <section style="text-align: center;">
          <h2>Наши тренеры</h2>
          <div class="card-container">
            <?php
            $sql = "SELECT FullName, About, Avatar FROM instructors";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $truncatedAbout = truncateText($row["About"], 20);
                echo '<div class="card" onclick="openModal(\'' . $row["FullName"] . '\', \'' . addslashes($row["About"]) . '\', \'\', \'' . $row["Avatar"] . '\')">';
                echo "<img src='" . $row["Avatar"] . "' height='100px' />";
                echo '<h3>' . $row["FullName"] . '</h3>';
                echo '<p>' . $truncatedAbout . '</p>';
                echo '</div>';
              }
            } else {
              echo "Нет тренеров для отображения.";
            }
            ?>
          </div>
        </section>
        <section style="text-align: center;">
          <h2>Мы предлагаем Вам</h2>
          <div class="card-container">
            <?php
            $sql = "SELECT Name, Description, Price, Image FROM directions";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                $truncatedDescription = truncateText($row["Description"], 20);
                echo '<div class="card" onclick="openModal(\'' . $row["Name"] . '\', \'' . addslashes($row["Description"]) . '\', \'' . $row["Price"] . '\', \'' . $row["Image"] . '\')">';
                echo "<img src='" . $row["Image"] . "' height='100px' />";
                echo '<h3>' . $row["Name"] . '</h3>';
                echo '<p>' . $truncatedDescription . '</p>';
                // echo '<p>Цена: ' . $row["Price"] . ' руб.</p>';
                echo '</div>';
              }
            } else {
              echo "Нет направлений для отображения.";
            }

            $conn->close();
            ?>
          </div>
        </section>
        <section id="contacts" style="text-align: left;">
          <h2 style="text-align: center;">Где нас найти?</h2>
          <div class="contacts-container">
            <div class="contact-info">
              <p>Адрес: ул. Тимме 23, 3 этаж, 308 каб.</p>
              <p>Телефон: <a href="tel:8800553535">8800553535</a></p>
              <p>Email: <a href="mailto:info@shagwpered.ru">info@shagwpered.ru</a></p>
              <p>Социальные сети:</p>
              <a href="https://vk.com/id1" target="_blank"><img src="assets\images\vk.svg" /></a>
              </p>
            </div>
            <div class="map">
              <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Af616301d4a54c0dc4eb9682baa7c84cc129c8031bcafe681b2c4b112037ddf70&amp;width=100%&amp;height=100%&amp;lang=ru_RU&amp;scroll=true"></script>
            </div>
          </div>
        </section>
      </div>
    </div>
    <footer>
      <p>© <?php echo date("Y"); ?> Студия «Шаг вперёд». Все права защищены.</p>
    </footer>
  </div>
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h3 id="modal-title"></h3>
      <img id="modal-image" src="">
      <p id="modal-description"></p>
      <p id="modal-price"></p>
    </div>
  </div>
  <script>
    function openModal(name, description, price, image) {
      document.getElementById('modal-title').innerText = name;
      document.getElementById('modal-description').innerText = description;
      // document.getElementById('modal-price').innerText = 'Цена: ' + price + ' руб.';
      document.getElementById('modal-image').src = image;
      document.getElementById('myModal').style.display = 'block';
    }
    document.querySelector('.close').onclick = function() {
      document.getElementById('myModal').style.display = 'none';
    }
    window.onclick = function(event) {
      if (event.target == document.getElementById('myModal')) {
        document.getElementById('myModal').style.display = 'none';
      }
    }
  </script>
</body>

</html>