<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);

    $year = $requestData['year'];
    $month = $requestData['month'];
    $day = $requestData['day'];
    $wDay = $requestData['wDay'];
    $time = $requestData['time'];
    $id = $requestData['id'];

    $statusUpdated = 'busy'; 
    $sql = "UPDATE slot SET statusSlot = '$statusUpdated', patientID = '$id'
            WHERE Year = $year AND
            Month = $month AND
            Day = $day And
            DayOfWeek = '$wDay' AND 
            StartTime = '$time'";
    if ($mysqli->query($sql)) {
        $response = ['success' => true, 'message' => 'Appointment made successfully.'];
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response = ['success' => false, 'message' => 'Error making appointment: ' . $mysqli->error];
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    $mysqli->close();
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
