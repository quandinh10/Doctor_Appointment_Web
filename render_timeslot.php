<?php
require_once 'config.php';
require_once 'session.php';
// header('Content-Type: application/json');
$patientID = $_SESSION["ID"];
$query = "SELECT Date, DayofWeek, TIME_FORMAT(TimeSLot, '%H:%i') AS FormatedTimeSlot FROM slot WHERE PatientID = '{$patientID}'";
$res = $mysqli->query($query);
if ($res->num_rows > 0) {
    if ($row = $res->fetch_assoc()) {
        $prev_date = $row["Date"];
        $prev_day = $row["DayofWeek"];
        $prev_timeslot = $row["FormatedTimeSlot"];
        echo "<p style=\"font-weight: 400; color: black; \">Your current an appointment is on <strong>$prev_date $prev_day</strong> at <strong>$prev_timeslot</strong></p>";
    }
}
if (isset($_POST["date"])) {
    $role = $_SESSION["role"];
    $userID = $_SESSION["ID"];
    $date = $_POST["date"];
    $query = "SELECT TIME_FORMAT(TimeSLot, '%H:%i') AS FormatedTimeSlot, Status, PatientID FROM slot WHERE Date = '{$date}'";
    $res = $mysqli->query($query);

    $slot_available = array();
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $slot_available[$row["FormatedTimeSlot"]] = ["Status" => $row["Status"], "PatientID" => $row["PatientID"]];
        }
    }
    $html = '<table class="table table-bordered overflow-auto">
    <thead>
        <tr>
            <th scope="col" class="day-col">09:00</th>
            <th scope="col" class="day-col">09:30</th>
            <th scope="col" class="day-col">10:00</th>
            <th scope="col" class="day-col">10:30</th>
            <th scope="col" class="day-col">11:00</th>
            <th scope="col" class="day-col">11:30</th>
            <th scope="col" class="day-col">12:00</th>
            <th scope="col" class="day-col">12:30</th>
            <th scope="col" class="day-col">13:00</th>
        </tr>
    </thead>
    <tbody>
    <tr>';
    $start_time = strtotime("09:00");
    $end_time = strtotime("13:30");
    $interval = 30 * 60;
    $current_time = $start_time;
    while ($current_time < $end_time) {
        $start_time_formatted = date('H:i', $current_time);
        $status_str = 'Empty';
        $color = '';
        if ($role == 'doctor') {
            $status_str = isset($slot_available[$start_time_formatted]) ? $slot_available[$start_time_formatted]["Status"] : 'empty';
            $color = ($status_str == 'available') ? '#66ff66' : (($status_str == 'busy') ? '#ff6633' : (($status_str == 'appointment') ? 'yellow' : ''));
            $html .= '<td>
                <button data-bs-target=' . ($status_str == 'appointment' ? '"#doctor-appoinment-modal" class="btn btn-light btn-doctor-appointment-1"' : '"#doctor-status-modal" class="btn btn-light btn-doctor-status-1"') . ' type="button" style="font-weight: 500; background-color:' . $color . '; color: \'black\';" data-bs-toggle="modal">' . ucfirst($status_str) . '</button>
            </td>';
        } else if ($role == 'patient') {
            $status_str = isset($slot_available[$start_time_formatted]) ? $slot_available[$start_time_formatted]["Status"] : 'empty';
            $status_str = ($status_str == "appointment" && $userID == $slot_available[$start_time_formatted]["PatientID"]) ? "appointment" : (($status_str == "appointment") ? "busy" : $status_str);
            $color = ($status_str == 'available') ? '#66ff66' : (($status_str == 'busy') ? '#ff6633' : (($status_str == 'appointment') ? 'yellow' : ''));
            $html .= '<td>
                <button ' . ($status_str == 'available' ? 'data-bs-toggle="modal" data-bs-target="#patient-modal"' : ($status_str == 'appointment' ? 'data-bs-toggle="modal" data-bs-target="#patient-cancel-modal"' : ' ')) . ' class="btn btn-light btn-patient-1" type="button" style="font-weight: 500; background-color:' . $color . '; color: \'black\';">' . ucfirst($status_str) . '</button>
            </td>';
        }

        $current_time += $interval;
    }
    $html .= '</tr>
    </tbody>
    <thead>
        <tr>
            <th scope="col" class="day-col">13:30</th>
            <th scope="col" class="day-col">14:00</th>
            <th scope="col" class="day-col">14:30</th>
            <th scope="col" class="day-col">15:00</th>
            <th scope="col" class="day-col">15:30</th>
            <th scope="col" class="day-col">16:00</th>
            <th scope="col" class="day-col">16:30</th>
            <th scope="col" class="day-col">17:00</th>
            <th scope="col" class="day-col">17:30</th>
        </tr>
    </thead>
    <tbody>
    <tr>';
    $start_time = strtotime("13:30");
    $end_time = strtotime("18:00");
    $interval = 30 * 60;
    $current_time = $start_time;
    while ($current_time < $end_time) {
        $start_time_formatted = date('H:i', $current_time);
        $status_str = 'Empty';
        $color = '';
        if ($role == 'doctor') {
            $status_str = isset($slot_available[$start_time_formatted]) ? $slot_available[$start_time_formatted]["Status"] : 'empty';
            $color = ($status_str == 'available') ? '#66ff66' : (($status_str == 'busy') ? '#ff6633' : (($status_str == 'appointment') ? 'yellow' : ''));
            $html .= '<td>
                <button data-bs-target=' . ($status_str == 'appointment' ? '"#doctor-appoinment-modal" class="btn btn-light btn-doctor-appointment-2"' : '"#doctor-status-modal" class="btn btn-light btn-doctor-status-2"') . ' type="button" style="font-weight: 500; background-color:' . $color . '; color: \'black\';" data-bs-toggle="modal">' . ucfirst($status_str) . '</button>
            </td>';
        } else if ($role == 'patient') {
            $status_str = isset($slot_available[$start_time_formatted]) ? $slot_available[$start_time_formatted]["Status"] : 'empty';
            $status_str = ($status_str == "appointment" && $userID == $slot_available[$start_time_formatted]["PatientID"]) ? "appointment" : (($status_str == "appointment") ? "busy" : $status_str);
            $color = ($status_str == 'available') ? '#66ff66' : (($status_str == 'busy') ? '#ff6633' : (($status_str == 'appointment') ? 'yellow' : ''));
            $html .= '<td>
                <button ' . ($status_str == 'available' ? 'data-bs-toggle="modal" data-bs-target="#patient-modal"' : ($status_str == 'appointment' ? 'data-bs-toggle="modal" data-bs-target="#patient-cancel-modal"' : ' ')) . ' class="btn btn-light btn-patient-2" type="button" style="font-weight: 500; background-color:' . $color . '; color: \'black\';">' . ucfirst($status_str) . '</button>
            </td>';
        }
        $current_time += $interval;
    }
    echo $html;
}
?>
<div class="modal fade" id="doctor-status-modal" tabindex="-1" aria-labelledby="doctor-status-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select class="form-select" id="status-select" aria-label="Default select example">
                        <option selected>Choose status</option>
                        <option value="available">Available</option>
                        <option value="busy">Busy</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="handleSaveStatus()">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="doctor-appoinment-modal" tabindex="-1" aria-labelledby="doctor-appoinment-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-dr-appointment"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="doctor-detail-appointment"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="handleDoctorCancelAppointment()">Cancel Appoinment</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="patient-modal" tabindex="-1" aria-labelledby="patient-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-patient"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="patient-detail-appointment"></div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="patient-cancel-modal" tabindex="-1" aria-labelledby="patient-cancel-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-patient-cancel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="font-weight: 400; color: black;">You are canceling the appointment</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="handleCancelAppointment()">Yes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.btn-doctor-status-1').click(function() {
            var timeSlot = $(this).closest('table').find('thead').eq(0).find('th').eq($(this).closest('td').index()).text();
            if ($(this).text() === "Available") {
                $('#status-select').val('available');
            } else if ($(this).text() === "Busy") {
                $('#status-select').val('busy');
            }
            document.getElementById("modal-title").innerHTML = `${timeSlot}`;
        });

        $('.btn-doctor-appointment-1').click(function() {
            var timeSlot = $(this).closest('table').find('thead').eq(0).find('th').eq($(this).closest('td').index()).text();
            let [fullDate, day] = getSelectedDay();
            document.getElementById("modal-title-dr-appointment").innerHTML = `${timeSlot}`;
            $.ajax({
                type: "POST",
                url: "get_detail_appointment.php",
                data: {
                    date: fullDate,
                    day: day,
                    timeslot: timeSlot
                },
                success: function(response) {
                    $("#doctor-detail-appointment").html(response);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            })
        });

        $('.btn-patient-1').click(function() {
            var timeSlot = $(this).closest('table').find('thead').eq(0).find('th').eq($(this).closest('td').index()).text();
            document.getElementById("modal-title-patient").innerHTML = `${timeSlot}`;
            document.getElementById("modal-title-patient-cancel").innerHTML = `${timeSlot}`;
            let [fullDate, day] = getSelectedDay();
            $.ajax({
                type: "POST",
                url: "get_detail_appointment.php",
                data: {
                    date: fullDate,
                    day: day,
                    timeslot: timeSlot
                },
                success: function(response) {
                    $("#patient-detail-appointment").html(response);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            })
        });

        $('.btn-doctor-status-2').click(function() {
            var timeSlot = $(this).closest('table').find('thead').eq(1).find('th').eq($(this).closest('td').index()).text();
            if ($(this).text() === "Available") {
                $('#status-select').val('available');
            } else if ($(this).text() === "Busy") {
                $('#status-select').val('busy');
            }
            document.getElementById("modal-title").innerHTML = `${timeSlot}`;
        });

        $('.btn-doctor-appointment-2').click(function() {
            var timeSlot = $(this).closest('table').find('thead').eq(1).find('th').eq($(this).closest('td').index()).text();
            let [fullDate, day] = getSelectedDay();
            document.getElementById("modal-title-dr-appointment").innerHTML = `${timeSlot}`;
            $.ajax({
                type: "POST",
                url: "get_detail_appointment.php",
                data: {
                    date: fullDate,
                    day: day,
                    timeslot: timeSlot
                },
                success: function(response) {
                    $("#doctor-detail-appointment").html(response);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            })
        });

        $('.btn-patient-2').click(function() {
            var timeSlot = $(this).closest('table').find('thead').eq(1).find('th').eq($(this).closest('td').index()).text();
            document.getElementById("modal-title-patient").innerHTML = `${timeSlot}`;
            document.getElementById("modal-title-patient-cancel").innerHTML = `${timeSlot}`;
            let [fullDate, day] = getSelectedDay();
            $.ajax({
                type: "POST",
                url: "get_detail_appointment.php",
                data: {
                    date: fullDate,
                    day: day,
                    timeslot: timeSlot
                },
                success: function(response) {
                    $("#patient-detail-appointment").html(response);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            })
        });
    });

    function handleSaveStatus() {
        let [fullDate, day] = getSelectedDay();
        let timeslot = document.getElementById("modal-title").innerHTML;
        let status = document.getElementById("status-select").value;
        if (status === "Choose status") {
            alert("Missing required field status!");
            return;
        }
        jQuery.ajax({
            type: "POST",
            url: "doctor_timeslot_processing.php",
            dataType: "json",
            data: {
                date: fullDate,
                day: day,
                timeslot: timeslot,
                status: status
            },
            success: function(response) {
                $('#doctor-status-modal').modal('hide');
                renderTimeslot(fullDate);
              
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function handleCancelAppointment() {
        let [fullDate, day] = getSelectedDay();
        let timeslot = document.getElementById("modal-title-patient-cancel").innerHTML;
        jQuery.ajax({
            type: "POST",
            url: "cancel_appointment.php",
            data: {
                date: fullDate,
                day: day,
                timeslot: timeslot,
            },
            success: function(response) {
                $('#patient-cancel-modal').modal('hide');
                renderTimeslot(fullDate);
              
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function handleDoctorCancelAppointment() {
        let [fullDate, day] = getSelectedDay();
        let timeslot = document.getElementById("modal-title-dr-appointment").innerHTML;
        jQuery.ajax({
            type: "POST",
            url: "cancel_appointment.php",
            data: {
                date: fullDate,
                day: day,
                timeslot: timeslot,
            },
            success: function(response) {
                $('#doctor-appoinment-modal').modal('hide');
                renderTimeslot(fullDate);
              
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function handleConfirmAppointment(date, day, timeslot) {
        jQuery.ajax({
            type: "POST",
            url: "make_appointment.php",
            data: {
                date: date,
                day: day,
                timeslot: timeslot
            },

            success: function(response) {
                $('#patient-modal').modal('hide');
                renderTimeslot(date);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });
    }

    function handleChangeAppointment(prev_date, prev_day, prev_timeslot, date, day, timeslot) {
        jQuery.ajax({
            type: "POST",
            url: "change_appointment.php",
            data: {
                prev_date: prev_date, 
                prev_day: prev_day, 
                prev_timeslot: prev_timeslot, 
                date: date, 
                day: day, 
                timeslot: timeslot
            },

            success: function(response) {
                $('#patient-modal').modal('hide');
                renderTimeslot(date);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    function getSelectedDay() {
        let selectedDay = new Date(getCookie("selected_day"));
        let year = selectedDay.getFullYear();
        let month = ('0' + (selectedDay.getMonth() + 1)).slice(-2);
        let date = ('0' + selectedDay.getDate()).slice(-2);
        let fullDate = year + '-' + month + '-' + date;
        let day = selectedDay.getDay();
        return [fullDate, day];
    }

    function renderTimeslot(date) {
        jQuery.ajax({
            type: "POST",
            url: "render_timeslot.php",
            data: {
                date: date
            },

            success: function(response) {
                $('#slot-render').html(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.log(error);
            }
        });
    }
</script>