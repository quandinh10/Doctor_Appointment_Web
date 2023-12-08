<?php
require_once 'config.php';
require_once 'session.php';
if (isset($_POST["date"]) && isset($_POST["day"]) && isset($_POST["timeslot"]) && isset($_POST["prev_date"]) && isset($_POST["prev_day"]) && isset($_POST["prev_timeslot"])) {
    $date = $_POST["date"];
    $day = $_POST["day"];
    $timeslot = $_POST["timeslot"];
    $prev_date = $_POST["prev_date"];
    $prev_day = $_POST["prev_day"];
    $prev_timeslot = $_POST["prev_timeslot"];
    $patientID = $_SESSION["ID"];

    $query = "UPDATE slot SET PatientID = NULL, Status = 'available' WHERE Date = '{$prev_date}' AND DayofWeek = '{$prev_day}' AND TimeSlot = '{$prev_timeslot}'";
    if ($mysqli->query($query) === true) {
        $query = "UPDATE slot SET PatientID = $patientID, Status = 'appointment' WHERE Date = '{$date}' AND DayofWeek = '{$day}' AND TimeSlot = '{$timeslot}'";
        if ($mysqli->query($query) === true) {
            $response = ['message' => 'Change an appointment successfully'];
            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($response);
        }
    }
    else {
        $response = ['message' => 'Cannot cancel an appointment: ' . $mysqli->error];
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode($response);
    }
}
