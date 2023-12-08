<?php
require_once 'config.php';
require_once 'session.php';
$db_config = include("./DB_config/db_config.php");
$doctor_email = $db_config["doctor_email"];
$isPatient = $_SESSION["role"] == 'patient';
if (isset($isPatient) && isset($_POST["date"]) && isset($_POST["day"]) && isset($_POST["timeslot"])) {
    $date = $_POST["date"];
    $day = $_POST["day"];
    $timeslot = $_POST["timeslot"];
    $patientID = $_SESSION["ID"];

    $query = "UPDATE slot SET PatientID = '$patientID', Status = 'appointment' WHERE Date = '{$date}' AND DayofWeek = '{$day}' AND TimeSlot = '{$timeslot}'";
    if ($mysqli->query($query) === true) {
        $response = ['message' => 'Make an appointment successfully'];
        // $to = $doctor_email; // Replace with the recipient's email address
        // $subject = "A new appointment";
        // $message = "Test";

        // $headers = "From: kaitojackjessica22@gmail.com\r\n";
        // $headers .= "Reply-To: $doctor_email\r\n";
        // $headers = "Content-Type: text/plain; charset=utf-8\r\n";

        // // Send the email
        // if (mail($to, $subject, $message, $headers)) {
        //     header('Content-Type: application/json');
        //     http_response_code(200);
        //     echo json_encode($response);
        // } else {
        //     header('Content-Type: application/json');
        //     http_response_code(400);
        //     $response = ['message' => 'Make an appointment unsuccessfully'];
        //     echo json_encode($response);
        // }

        header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode($response);
        
    }
    else {
        $response = ['message' => 'Cannot make an appointment: ' . $mysqli->error];
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode($response);
    }
}
