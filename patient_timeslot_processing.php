<?php
require_once 'config.php';
header('Content-Type: application/json');
$isPatient = $_SESSION["role"] == 'patient';
if (isset($isPatient) && isset($_POST["date"]) && isset($_POST["day"]) && isset($_POST["status"]) && isset($_POST["timeslot"])) {
    $date = $_POST["date"];
    $day = $_POST["day"];
    $timeslot = $_POST["timeslot"];
    $status = $_POST["status"];
    $DAYS_OF_WEEK = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $day = $DAYS_OF_WEEK[$day];

    $query = "SELECT SlotID FROM slot WHERE Date = '{$date}' AND DayofWeek = '{$day}' AND Status = '{$status}' AND TimeSlot = '{$timeslot}'";
    $res = $mysqli->query($query);

    if ($res->num_rows > 0) {
        if ($row = $res->fetch_assoc()) {
            $id = $row["SlotID"];
            $update_sql = "UPDATE slot SET Status = '$status' WHERE SlotID = $id";
            if ($mysqli->query($update_sql)) {
                $response = ['message' => 'Timeslot status updated successfully'];
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode($response);
            } else {
                $response = ['message' => 'Error updating timeslot status: ' . $mysqli->error];
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode($response);
            }
        }
    } else {
        $insert_sql = "INSERT INTO slot (Date, DayofWeek, TimeSlot, Status) VALUES ('$date', '$day', '$timeslot', '$status')";
        if ($mysqli->query($insert_sql)) {
            $response = ['message' => 'Timeslot status creating successfully'];
            header('Content-Type: application/json');
            http_response_code(201);
            echo json_encode($response);
        } else {
            $response = ['message' => 'Error creating timeslot status: ' . $mysqli->error];
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode($response);
        }
    }
}
