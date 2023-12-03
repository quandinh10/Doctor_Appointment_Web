<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);

    $day = $requestData['day'];
    $time = $requestData['time'];

    require_once 'config.php';

    $status = $requestData['action'] === 'updateToAvailable' ? 'available' : 'busy';

    $sql = "UPDATE slot SET statusSlot = '$status' WHERE DayOfWeek = '$day' AND StartTime = '$time'";

    if ($mysqli->query($sql)) {
        $response = ['success' => true, 'message' => 'Timeslot status updated successfully.'];
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        $response = ['success' => false, 'message' => 'Error updating timeslot status: ' . $mysqli->error];
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
