<?php
session_start();

require_once('db.php');
$dbConnection = new DBConnection();
$dbConnection->connect();
$conn = $dbConnection->getConnection();

$Login = $_SESSION['Login'];
$FullName = "";
$PhoneNumber = "";

$stmt_user = $conn->prepare("SELECT FullName, PhoneNumber, Login FROM Clients WHERE Login = ?");
$stmt_user->bind_param("s", $Login);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $FullName = $row_user['FullName'];
    $PhoneNumber = $row_user['PhoneNumber'];
    $Login = $row_user['Login'];
} else {
    header("Location: logout.php");
    exit;
}

$stmt_user->close();
$conn->close();

echo json_encode(array(
    "FullName" => $FullName,
    "PhoneNumber" => $PhoneNumber,
    "Login" => $Login
));
