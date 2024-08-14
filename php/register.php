<?php
require_once('db.php');
session_start();
$dbConnection = new DBConnection();
$dbConnection->connect();
$conn = $dbConnection->getConnection();

$FullName = $_POST['FullName'];
$PhoneNumber = $_POST['PhoneNumber'];
$Login = $_POST['Login'];
$Password = $_POST['Password'];

$hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT ID_Client FROM Clients WHERE Login = ?");
$stmt->bind_param("s", $Login);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Логин уже существует. Пожалуйста, выберите другой логин.";
} else {
    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO Clients (FullName, PhoneNumber, Login, Password, vk_id) VALUES (?, ?, ?, ?, 0)");
    $stmt->bind_param("ssss", $FullName, $PhoneNumber, $Login, $hashedPassword);
    if ($stmt->execute()) {
        $_SESSION['ID_Client'] = $stmt->insert_id;
        $_SESSION['Login'] = $Login;
        header("Location: ../lk.php");
        exit;
    } else {
        echo "Ошибка: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
