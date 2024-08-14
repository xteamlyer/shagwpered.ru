<?php
require_once 'php/db.php';
$db = new DBConnection();
$db->connect();
$conn = $db->getConnection();
$sql = "SELECT ID_News, Title, Text, Date, Time, Banner FROM News ORDER BY Date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Студия «Шаг вперед»</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/news.css">
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
      <h1 style="text-align: center; padding-top: 30px;">Новости</h1>
      <section class="news-section">
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $title = htmlspecialchars_decode($row["Title"]);
            $text = htmlspecialchars_decode($row["Text"]);
            $date = htmlspecialchars_decode($row["Date"]);
            $time = htmlspecialchars_decode($row["Time"]);
            $banner = htmlspecialchars_decode($row["Banner"]);
            echo "<div class='news-card' onclick='openModal(" . json_encode($row) . ")'>";
            echo "<div class='news-text'>";
            echo "<h2>" . $title . "</h2>";
            // Декодируем текст новости и вставляем HTML-разрывы строк
            // echo "<p>" . nl2br($text) . "</p>";
            echo "<p class='news-date'><strong>Дата: </strong>" . $date . " <strong>Время: </strong>" . $time . "</p>";
            echo "</div>";
            // if (!empty($banner)) {
            //   echo "<div class='news-image'><img src='" . $banner . "' /></div>";
            // }
            echo "</div>";
          }
        } else {
          echo "<p>Новостей нет.</p>";
        }
        $conn->close();
        ?>
      </section>
    </div>
    <div id="newsModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-banner">
          <img id="modalBanner" src="">
        </div>
        <h2 id="modalTitle"></h2>
        <p id="modalText"></p>
      </div>
    </div>
    <footer>
      <p>© <?php echo date("Y"); ?> Студия «Шаг вперёд». Все права защищены.</p>
    </footer>
  </div>
  <script src="js\News.js"></script>
</body>

</html>