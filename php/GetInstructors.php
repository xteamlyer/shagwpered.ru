<?php
require_once('db.php');

class InstructorFetcher
{
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DBConnection();
        $this->dbConnection->connect();
    }

    public function fetchInstructors()
    {
        try {
            $conn = $this->dbConnection->getConnection();
            $stmt = $conn->prepare("SELECT ID_Instructor, FullName FROM Instructors");
            $stmt->execute();
            $instructors = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            if (!empty($instructors)) {
                return $instructors;
            } else {
                return ['error' => "Ошибка: нет доступных инструкторов."];
            }
        } catch (Exception $e) {
            return ['error' => "Ошибка при выполнении запроса: " . $e->getMessage()];
        } finally {
            if ($stmt) {
                $stmt->close();
            }
            $conn->close();
        }
    }
}

header('Content-Type: application/json');

$fetcher = new InstructorFetcher();
$response = $fetcher->fetchInstructors();
echo json_encode($response);
