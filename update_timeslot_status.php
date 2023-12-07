<?php
require_once 'config.php';
header('Content-Type: application/json');
if (isset($_POST["date"]) && isset($_POST["day"]) && isset($_POST["status"]) && isset($_POST["timeslot"])) {
    $date = $_POST["date"];
    $day = $_POST["day"];
    $timeslot = $_POST["timeslot"];
    $id = $_POST["id"];
    $role = $_POST["role"];
    $status = $_POST["status"];
    $DAYS_OF_WEEK = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    $day = $DAYS_OF_WEEK[$day];
    
    $query = "SELECT SlotID FROM slot WHERE Date = '{$date}' AND DayofWeek = '{$day}' AND TimeSlot = '{$timeslot}'";
    $res = $mysqli->query($query);
    
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $slotid = $row["SlotID"];

        $query_status = "SELECT Status FROM slot where SlotID = $slotid";
        $status_res = $mysqli->query($query_status);
        $status_res_row = $status_res->fetch_assoc();
        $slotStatus = $status_res_row['Status'];

        if($status === 'busy') {
            if($slotStatus === 'busy')
            {
                if($role ===  'doctor') {
                    $sql = "SELECT PatientID FROM slot WHERE SlotID = $slotid";
                    $patient_res = $mysqli->query($sql);
                    $patient_row = $patient_res->fetch_assoc();
                    $patientID = $patient_row['PatientID'];
                    if($patientID) {
                        $response = ['success' => false, 'message' => 'You have an appointment with patient ' . $patientID . '.'];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    } else {
                        $response = ['success' => false, 'message' => 'You are busy at this time.'];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    }   
                } elseif($role === 'patient') {
                    $response = ['success' => false, 'message' => 'Doctor is busy at this time.'];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } elseif($slotStatus === 'available') {
                if($role === 'doctor') {
                    $update_sql = "UPDATE slot SET Status = '$status' WHERE SlotID = $slotid";
                    $update = $mysqli->query($update_sql);
                    $response = ['success' => true, 'message' => 'Timeslot status updated successfully.'];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
                elseif($role === 'patient') {
                    $sql = "SELECT availableSlot FROM user WHERE ID = '$id'";
                    $avaiSlot_res = $mysqli->query($sql);
                    $avaiSlot_row = $avaiSlot_res->fetch_assoc();
                    if($avaiSlot_row['availableSlot'] == 0)
                    {
                        $response = ['success' => false, 'message' => 'You are out of available slot.'];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    } else {
                        $sql = "UPDATE user SET availableSlot = availableSlot - 1 WHERE ID = '$id'";
                        $reduce = $mysqli->query($sql);
                        $sql = "UPDATE slot SET Status = '$status', PatientID = '$id' WHERE SlotID = $slotid";
                        $update = $mysqli->query($sql);
                        $response = ['success' => true, 'message' => 'Appointment with doctor is created successfully.'];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    }
                }
            }
        } elseif($status === 'available') {
            if($slotStatus === 'busy') {
                $sql = "SELECT PatientID FROM slot WHERE SlotID = $slotid";
                $patient_res = $mysqli->query($sql);
                $patient_row = $patient_res->fetch_assoc();
                $patientID = $patient_row['PatientID'];
                if($patientID) {
                    $response = ['success' => false, 'message' => 'You have an appointment with patient ' . $patientID . '.'];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                } else {
                    $update_sql = "UPDATE slot SET Status = '$status' WHERE SlotID = $slotid";
                    $update = $mysqli->query($update_sql);
                    $response = ['success' => true, 'message' => 'Timeslot status updated successfully.'];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                } 
            } elseif($slotStatus === 'available') {
                $response = ['success' => false, 'message' => 'You have already set available at this time.'];
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        } elseif($status === 'cancel') {
            if($slotStatus === 'busy') {
                $sql = "SELECT PatientID FROM slot WHERE SlotID = $slotid";
                $patient_res = $mysqli->query($sql);
                $patient_row = $patient_res->fetch_assoc();
                $patientID = $patient_row['PatientID'];
                if($role === 'doctor'){
                    if($patientID) {
                        $sql = "UPDATE user SET availableSlot = availableSlot + 1 WHERE ID = '$patientID'";
                        $reduce = $mysqli->query($sql);
                        $sql = "UPDATE slot SET Status = 'available', PatientID = NULL WHERE SlotID = $slotid";
                        $update = $mysqli->query($sql);
                        $response = ['success' => true, 'message' => 'Appointment with ' . $patientID . ' is cancelled.'];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    } else {
                        $response = ['success' => false, 'message' => 'You don\'t have any appointments at this time.'];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    }    
                } elseif($role === 'patient') {
                    if($patientID) {
                        if($id === $patientID) {
                            $sql = "UPDATE user SET availableSlot = availableSlot + 1 WHERE ID = '$patientID'";
                            $reduce = $mysqli->query($sql);
                            $sql = "UPDATE slot SET Status = 'available', PatientID = NULL WHERE SlotID = $slotid";
                            $update = $mysqli->query($sql);
                            $response = ['success' => true, 'message' => 'Appointment with doctor is cancelled.'];
                            header('Content-Type: application/json');
                            echo json_encode($response);
                        } else {
                            $response = ['success' => false, 'message' => 'You can not edit the timeslot that are not your appointment.'];
                            header('Content-Type: application/json');
                            echo json_encode($response);
                        }
                    } else {
                        $response = ['success' => false, 'message' => 'You can not edit the timeslot that are not your appointment.'];
                        header('Content-Type: application/json');
                        echo json_encode($response);
                    }
                }
            } elseif($slotStatus === 'available') {
                if($role === 'doctor') {
                    $response = ['success' => false, 'message' => 'There are no appointments at this time.'];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                } elseif($role === 'patient') {
                    $response = ['success' => false, 'message' => 'You can not edit the timeslot that are not your appointment.'];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            }
        }
    } else {
        if($status === 'busy' || $status === 'available')
        {
            if($role ===  'doctor'){
                $sql = "INSERT INTO slot (Date, DayofWeek, TimeSlot, Status) VALUES ('$date', '$day', '$timeslot', '$status')";
                $update = $mysqli->query($sql);
                $response = ['success' => true, 'message' => 'Timeslot status updated successfully.'];
                header('Content-Type: application/json');
                echo json_encode($response);
            } elseif($role === 'patient') {
                $response = ['success' => false, 'message' => 'Patient can\'t setup new timeslot.'];
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        } elseif($status === 'cancel') {
            $response = ['success' => false, 'message' => 'This timeslot doesn\'t created.'];
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}
