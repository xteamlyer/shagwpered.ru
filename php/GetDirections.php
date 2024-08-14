<?php
require_once('db.php');

class DirectionFetcher
{
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DBConnection();
        $this->dbConnection->connect();
    }

    public function fetchDirections()
    {
        try {
            $conn = $this->dbConnection->getConnection();
            $stmt = $conn->prepare("SELECT ID_Direction, Name FROM Directions");
            $stmt->execute();
            $directions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            if (!empty($directions)) {
                return $directions;
            } else {
                return ['error' => "Ошибка: нет доступных направлений."];
            }
        } catch (Exception $e) {
            return ['error' => "Ошибка при выполнении запроса: " . $e->getMessage()];
        } finally {
            $stmt->close();
            $conn->close();
        }
    }
}

header('Content-Type: application/json');

$fetcher = new DirectionFetcher();
$response = $fetcher->fetchDirections();
echo json_encode($response);
