<?php
session_start();

require_once('db.php');
$dbConnection = new DBConnection();
$dbConnection->connect();
$conn = $dbConnection->getConnection();

$Login = $_SESSION['Login'];
$FullName = $_POST['FullName'];
$PhoneNumber = $_POST['PhoneNumber'];
$Password = $_POST['Password'];
$ConfirmPassword = $_POST['ConfirmPassword'];

if ($Password !== $ConfirmPassword) {
    echo json_encode(array("error" => "Пароли не совпадают."));
    exit;
}

if (!empty($Password)) {
    $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);
    $stmt_update = $conn->prepare("UPDATE Clients SET FullName = ?, PhoneNumber = ?, Password = ? WHERE Login = ?");
    $stmt_update->bind_param("ssss", $FullName, $PhoneNumber, $hashedPassword, $Login);
} else {
    $stmt_update = $conn->prepare("UPDATE Clients SET FullName = ?, PhoneNumber = ? WHERE Login = ?");
    $stmt_update->bind_param("sss", $FullName, $PhoneNumber, $Login);
}

if ($stmt_update->execute()) {
    echo json_encode(array("success" => "Данные успешно обновлены."));
} else {
    echo json_encode(array("error" => "Ошибка при обновлении данных."));
}

$stmt_update->close();
$conn->close();
