<?php
require_once('db.php');
session_start();
$dbConnection = new DBConnection();
$dbConnection->connect();
$conn = $dbConnection->getConnection();

$Login = $_POST['Login'];
$Password = $_POST['Password'];

$stmt = $conn->prepare("SELECT ID_Client, Password FROM Clients WHERE Login = ?");
$stmt->bind_param("s", $Login);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($ID_Client, $hashedPasswordDB);
    $stmt->fetch();

    if (password_verify($Password, $hashedPasswordDB)) {
        $_SESSION['ID_Client'] = $ID_Client;
        $_SESSION['Login'] = $Login;
        header("Location: ../lk.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Неверный пароль";
        header("Location: ../login.php");
        exit;
    }
} else {
    $_SESSION['error_message'] = "Пользователь не найден";
    header("Location: ../login.php");
    exit;
}

$stmt->close();
$conn->close();
