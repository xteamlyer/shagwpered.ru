<?php
require_once('db.php');
session_start();

if (isset($_GET['payload'])) {
    $payload = json_decode(urldecode($_GET['payload']), true);

    if ($payload && $payload['type'] === 'silent_token' && $payload['auth'] === 1) {
        $vkUser = $payload['user'];
        $vkId = $vkUser['id'];
        $vkName = $vkUser['first_name'] . ' ' . $vkUser['last_name'];
        $phoneNumber = isset($vkUser['phone']) ? $vkUser['phone'] : 'Не указан';

        $clientData = getClientDataByVkId($vkId);

        if (!$clientData) {
            $randomPassword = generateRandomPassword();
            $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);
            $clientId = createNewClient($vkName, $vkId, $hashedPassword, $phoneNumber);
        } else {
            $clientId = $clientData['ID_Client'];
            $clientLogin = $clientData['Login'];
        }

        if ($clientId) {
            $_SESSION['ID_Client'] = $clientId;
            $_SESSION['Login'] = $clientLogin;
            header("Location: ../lk.php");
            exit;
        } else {
            echo "Ошибка при аутентификации пользователя.";
        }
    } else {
        echo "Некорректный ответ от VK.";
    }
} else {
    echo "Ответ от VK не был получен.";
}

function getClientDataByVkId($vkId)
{
    $dbConnection = new DBConnection();
    $dbConnection->connect();
    $conn = $dbConnection->getConnection();
    $sql = "SELECT ID_Client, Login FROM Clients WHERE vk_id='{$vkId}'";
    $result = $conn->query($sql);
    $clientData = $result->fetch_assoc();
    $conn->close();
    return $clientData;
}

function createNewClient($vkName, $vkId, $hashedPassword, $phoneNumber)
{
    $dbConnection = new DBConnection();
    $dbConnection->connect();
    $conn = $dbConnection->getConnection();
    $sql = "INSERT INTO Clients (FullName, PhoneNumber, Login, Password, vk_id) VALUES ('$vkName', '$phoneNumber', '$vkName', '$hashedPassword', '$vkId')";
    $success = $conn->query($sql);
    if ($success) {
        $clientId = $conn->insert_id;
    } else {
        $clientId = false;
    }
    $conn->close();
    return $clientId;
}

function generateRandomPassword()
{
    return bin2hex(random_bytes(8));
}
