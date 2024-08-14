<?php
require_once('db.php');
session_start();

if (isset($_SESSION['Login']) && isset($_GET['code'])) {
    $login = $_SESSION['Login'];
    $tokenData = getTokenData($_GET['code']);

    if ($tokenData && isset($tokenData['access_token'])) {
        $userInfo = getUserInfo($tokenData['access_token'], $tokenData['user_id']);

        if ($userInfo && isset($userInfo['response'][0])) {
            $vkUser = $userInfo['response'][0];
            $vkId = $vkUser['id'];

            $dbConnection = new DBConnection();
            $dbConnection->connect();
            $conn = $dbConnection->getConnection();

            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM Clients WHERE vk_id = ?");
            $checkStmt->bind_param("s", $vkId);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                $_SESSION['error'] = "Страница VK уже привязана.";
            } else {
                $stmt = $conn->prepare("UPDATE Clients SET vk_id = ? WHERE Login = ?");
                $stmt->bind_param("ss", $vkId, $login);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $_SESSION['message'] = "VK ID успешно привязан.";
                } else {
                    $_SESSION['error'] = "Ошибка при привязке VK ID.";
                }

                $stmt->close();
            }

            $conn->close();
        } else {
            $_SESSION['error'] = "Не удалось получить данные пользователя VK.";
        }
    } else {
        $_SESSION['error'] = "Не удалось получить токен доступа VK.";
    }
} else {
    $_SESSION['error'] = "Пользователь не авторизован или код авторизации не получен.";
}

header("Location: ../lk.php");
exit();

function getTokenData($code)
{
    $clientId = '';
    $clientSecret = '';
    $redirectUri = '';
    $tokenUrl = "https://oauth.vk.com/access_token?client_id={$clientId}&client_secret={$clientSecret}&redirect_uri={$redirectUri}&code={$code}";
    $tokenResponse = file_get_contents($tokenUrl);
    return json_decode($tokenResponse, true);
}

function getUserInfo($accessToken, $userId)
{
    $userInfoUrl = "https://api.vk.com/method/users.get?user_ids={$userId}&access_token={$accessToken}&v=5.199";
    $userInfoResponse = file_get_contents($userInfoUrl);
    return json_decode($userInfoResponse, true);
}
