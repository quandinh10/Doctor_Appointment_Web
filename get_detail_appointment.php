<?php
require_once 'config.php';
require_once 'session.php';

if (isset($_POST["date"]) && isset($_POST["day"]) && isset($_POST["timeslot"])) {
    $date = $_POST["date"];
    $day = $_POST["day"];
    $timeslot = $_POST["timeslot"];
    $DAYS_OF_WEEK = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $day = $DAYS_OF_WEEK[$day];
    $role = $_SESSION["role"];

    if ($role == "doctor") {
        $query = "SELECT U.UserID, U.Firstname, U.Lastname, U.Email FROM slot S JOIN user U ON S.PatientID = U.UserID WHERE S.Date = '{$date}' AND S.DayofWeek = '{$day}' AND S.TimeSlot = '{$timeslot}'";
        $res = $mysqli->query($query);

        if ($res->num_rows > 0) {
            if ($row = $res->fetch_assoc()) {
                $patientID = $row["UserID"];
                $firstname = $row["Firstname"];
                $lastname = $row["Lastname"];
                $email = $row["Email"];
                echo "<h4>Patient Detail</h4><br><p style=\"font-weight: 400; color: black; \"><strong>PatientID:</strong> $patientID</p>
                <p style=\"font-weight: 400; color: black; \"><strong>Name:</strong> $firstname $lastname</p>
                <p style=\"font-weight: 400; color: black; \"><strong>Email:</strong> $email</p>";
            }
        }
    } else if ($role == "patient") {
        $patientID = $_SESSION["ID"];
        $query = "SELECT Date, DayofWeek, TIME_FORMAT(TimeSLot, '%H:%i') AS FormatedTimeSlot FROM slot WHERE PatientID = '{$patientID}'";
        $res = $mysqli->query($query);
        $html = '';
        if ($res->num_rows > 0) {
            if ($row = $res->fetch_assoc()) {
                $prev_date = $row["Date"];
                $prev_day = $row["DayofWeek"];
                $prev_timeslot = $row["FormatedTimeSlot"];
                $html .= "<p style=\"font-weight: 400; color: black; \">You have already booked an appointment on <strong>$prev_date $prev_day</strong> at <strong>$prev_timeslot</strong></p>";
                $html .= '<div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="handleChangeAppointment('. "'$prev_date', '$prev_day', '$prev_timeslot', '$date', '$day', '$timeslot'" .')">Change Appointment</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>';
            }
        } else {
            $html .= "<p style=\"font-weight: 400; color: black; \">You are booking an appointment on <strong>$date $day</strong> at <strong>$timeslot</strong></p>";
            $html .= '<div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="handleConfirmAppointment('. "'$date', '$day', '$timeslot'" .')">Confirm Appointment</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>';
        }
        echo $html;
    }
}
