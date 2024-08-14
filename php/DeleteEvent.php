<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once('db.php');
    $dbConnection = new DBConnection();
    $dbConnection->connect();
    $conn = $dbConnection->getConnection();

    $eventId = intval($_POST['event_id']);

    if (isset($_SESSION['ID_Client'])) {
        $ID_Client = $_SESSION['ID_Client'];

        $stmt = $conn->prepare("DELETE FROM `Records` WHERE `ID_Record` = ? AND `ID_Client` = ?");
        $stmt->bind_param("ii", $eventId, $ID_Client);

        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array("status" => "success", "message" => "Запись успешно удалена"));
        } else {
            http_response_code(500);
            echo json_encode(array("status" => "error", "message" => "Ошибка при удалении записи: " . $stmt->error));
        }

        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Ошибка: ID пользователя не найден в сессии"));
    }

    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Метод не разрешен"));
}
