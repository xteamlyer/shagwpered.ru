<?php
require_once('db.php');

class TimeSlotFetcher
{
    private $dbConnection;

    public function __construct()
    {
        $this->dbConnection = new DBConnection();
        $this->dbConnection->connect();
    }

    public function fetchTimeSlots($date, $instructorId)
    {
        try {
            $conn = $this->dbConnection->getConnection();
            $stmt = $conn->prepare("SELECT StartTime, EndTime FROM Timetable WHERE Date = ? AND ID_Instructor = ?");
            $stmt->bind_param("si", $date, $instructorId);
            $stmt->execute();
            $result = $stmt->get_result();
            $timeSlots = [];

            while ($row = $result->fetch_assoc()) {
                $start = new DateTime($row['StartTime']);
                $end = new DateTime($row['EndTime']);
                while ($start <= $end) {
                    $timeSlots[] = $start->format('H:i');
                    $start->modify('+1 hour');
                }
            }

            if (empty($timeSlots)) {
                return ['error' => 'У инструктора нет записи на эту дату'];
            }
            return $timeSlots;
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

if (isset($_GET['date']) && isset($_GET['instructor'])) {
    $fetcher = new TimeSlotFetcher();
    $response = $fetcher->fetchTimeSlots($_GET['date'], intval($_GET['instructor']));
    echo json_encode($response);
} else {
    echo json_encode(['error' => 'Недостаточно данных']);
}
