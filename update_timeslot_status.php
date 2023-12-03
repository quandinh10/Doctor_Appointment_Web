<?php
require_once 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);

    $year = $requestData['year'];
    $month = $requestData['month'];
    $day = $requestData['day'];
    $wDay = $requestData['wDay'];
    $time = $requestData['time'];
    $statusUpdated = $requestData['statusUpdated'];
    $action = $requestData['action'];

    error_log('Debugging request data: ' . print_r($requestData, true));

    if($action === 'firstUpdate') {
        $sql = "INSERT INTO slot (Year, Month, Day, DayOfWeek, StartTime, statusSlot) 
                VALUES ($year, $month, $day, '$wDay', '$time', '$statusUpdated')";
        if ($mysqli->query($sql)) {
            $response = ['success' => true, 'message' => 'Timeslot status created successfully (server)'];
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = ['success' => false, 'message' => 'Error creating timeslot status (server) ' . $mysqli->error];
            header('Content-Type: application/json');
            echo json_encode($response);
        }
       
    } 
    else {
        $sql = "UPDATE slot SET statusSlot = '$statusUpdated' 
                WHERE Year = $year AND
                Month = $month AND
                Day = $day And
                DayOfWeek = '$wDay' AND 
                StartTime = '$time'";

        if ($mysqli->query($sql)) {
            $response = ['success' => true, 'message' => 'Timeslot status updated successfully (server).'];
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = ['success' => false, 'message' => 'Error updating timeslot status (server): ' . $mysqli->error];
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
 
    $mysqli->close();
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
