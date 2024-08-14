<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('db.php');
    $dbConnection = new DBConnection();
    $dbConnection->connect();
    $conn = $dbConnection->getConnection();

    $theme = intval($_POST['theme']);
    $date = $_POST['event-date'];
    $time = $_POST['event-time'];
    $instructor = intval($_POST['instructor']);

    if (isset($_SESSION['ID_Client'])) {
        $ID_Client = $_SESSION['ID_Client'];

        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM `Records` WHERE `Date` = ? AND `Time` = ?");
        $checkStmt->bind_param("ss", $date, $time);
        $checkStmt->execute();
        $checkStmt->bind_result($recordCount);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($recordCount > 0) {
            http_response_code(409);
            echo json_encode(array("status" => "error", "message" => "На указанную дату и время уже существует занятие"));
        } else {
            $stmt = $conn->prepare("INSERT INTO `Records` (ID_Instructor, ID_Direction, ID_Client, Date, Time) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiss", $instructor, $theme, $ID_Client, $date, $time);

            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode(array("status" => "success", "message" => "Занятие успешно добавлено"));
            } else {
                http_response_code(500);
                echo json_encode(array("status" => "error", "message" => "Ошибка при добавлении занятия: " . $stmt->error));
            }

            $stmt->close();
        }
    } else {
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Ошибка: ID пользователя не найден в сессии"));
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Метод не разрешен"));
}
