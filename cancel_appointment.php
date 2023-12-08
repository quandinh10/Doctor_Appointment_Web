<?php
require_once 'config.php';
require_once 'session.php';
if (isset($_POST["date"]) && isset($_POST["day"]) && isset($_POST["timeslot"])) {
    $date = $_POST["date"];
    $day = $_POST["day"];
    $timeslot = $_POST["timeslot"];
    $DAYS_OF_WEEK = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $day = $DAYS_OF_WEEK[$day];

    $query = "UPDATE slot SET PatientID = NULL, Status = 'available' WHERE Date = '{$date}' AND DayofWeek = '{$day}' AND TimeSlot = '{$timeslot}'";
    if ($mysqli->query($query) === true) {
        $response = ['message' => 'Cancel an appointment successfully'];
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode($response);
    }
    else {
        $response = ['message' => 'Cannot cancel an appointment: ' . $mysqli->error];
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode($response);
    }
}
