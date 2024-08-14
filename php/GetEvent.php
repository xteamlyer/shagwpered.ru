<?php
session_start();

require_once('db.php');
$dbConnection = new DBConnection();
$dbConnection->connect();
$conn = $dbConnection->getConnection();

$response = array();

if (!isset($_SESSION['Login'])) {
    $response['error'] = "Ошибка: Пользователь не авторизован.";
} else {
    $Login = $_SESSION['Login'];

    $stmt_user = $conn->prepare("SELECT * FROM Clients WHERE Login = ?");
    $stmt_user->bind_param("s", $Login);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();

        $ID_Client = $row_user['ID_Client'];

        $stmt_classes = $conn->prepare("
            SELECT Records.ID_Record, Records.Date, Records.Time, Directions.Name AS direction_name
            FROM Records
            INNER JOIN Directions ON Records.ID_Direction = Directions.ID_Direction
            WHERE Records.ID_Client = ?
        ");
        $stmt_classes->bind_param("i", $ID_Client);
        $stmt_classes->execute();
        $result_classes = $stmt_classes->get_result();

        $events = array();
        while ($row_classes = $result_classes->fetch_assoc()) {
            $start_datetime = $row_classes['Date'] . ' ' . $row_classes['Time'];

            $event = array(
                'id' => $row_classes['ID_Record'],
                'title' => $row_classes['direction_name'],
                'start' => $start_datetime,
            );
            $events[] = $event;
        }

        $response['events'] = $events;
    } else {
        header("Location: logout.php");
    }
    $stmt_user->close();
    $stmt_classes->close();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
