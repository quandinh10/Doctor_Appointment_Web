<?php
require_once 'config.php';
// header('Content-Type: application/json');
if (isset($_POST["date"])) {
    $date = $_POST["date"];
    $query = "SELECT TIME_FORMAT(TimeSLot, '%H:%i') AS FormatedTimeSlot, Status FROM slot WHERE Date = '{$date}'";
    $res = $mysqli->query($query);

    $slot_available = array();
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $slot_available[$row["FormatedTimeSlot"]] = $row["Status"];
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
        $status_str = isset($slot_available[$start_time_formatted]) ? $slot_available[$start_time_formatted] : 'Empty';
        $color = ($status_str == 'available') ? '#66ff66' : (($status_str == 'busy') ? '#ff6633' : '');
        $html .= '
        <td>
            <button type="button" style="font-weight: 500; background-color:' . $color . '; color: \'black\';"  class="btn btn-light btn-value-1" data-bs-toggle="modal" data-bs-target="#statusModal">' . ucfirst($status_str) . '</button>
        </td>';
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
        $status_str = isset($slot_available[$start_time_formatted]) ? $slot_available[$start_time_formatted] : 'Empty';
        $color = ($status_str == 'available') ? '#66ff66' : (($status_str == 'busy') ? '#ff6633' : '');
        $html .= '
        <td>
            <button type="button" style="font-weight: 500; background-color:' . $color . '; color: \'black\';"  class="btn btn-light btn-value-2" data-bs-toggle="modal" data-bs-target="#statusModal">' . ucfirst($status_str) . '</button>
        </td>';
        $current_time += $interval;
    }
    echo $html;
}
?>
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="status-modal-title"></h5>
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

<script>
    $(document).ready(function() {
        $('.btn-value-1').click(function() {
            var timeSlot = $(this).closest('table').find('thead').eq(0).find('th').eq($(this).closest('td').index()).text();
            if ($(this).text() === "Available") {
                $('#status-select').val('available');
            } else if ($(this).text() === "Busy") {
                $('#status-select').val('busy');
            }
            document.getElementById("status-modal-title").innerHTML = `${timeSlot}`;
        });
        $('.btn-value-2').click(function() {
            var timeSlot = $(this).closest('table').find('thead').eq(1).find('th').eq($(this).closest('td').index()).text();
            if ($(this).text() === "Available") {
                $('#status-select').val('available');
            } else if ($(this).text() === "Busy") {
                $('#status-select').val('busy');
            }
            document.getElementById("status-modal-title").innerHTML = `${timeSlot}`;
        });
    });

    function handleSaveStatus() {
        let selectedDay = new Date(getCookie("selected_day"));
        let year = selectedDay.getFullYear();
        let month = ('0' + (selectedDay.getMonth() + 1)).slice(-2);
        let date = ('0' + selectedDay.getDate()).slice(-2);
        let combineDate = year + '-' + month + '-' + date;
        let day = selectedDay.getDay();
        let timeslot = document.getElementById("status-modal-title").innerHTML;
        let status = document.getElementById("status-select").value;
        if (status === "Choose status") {
            alert("Missing required field status!");
            return;
        }

        $('#status-select').val('Choose status');
        jQuery.ajax({
            type: "POST",
            url: "update_timeslot_status.php",
            dataType: "json",
            data: {
                date: combineDate,
                day: day,
                timeslot: timeslot,
                status: status
            },

            success: function(response) {
                $('#statusModal').modal('hide');
                jQuery.ajax({
                    type: "POST",
                    url: "render_timeslot.php",
                    data: {
                        date: combineDate
                    },

                    success: function(response) {
                        $('#slot-render').html(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.log(error);
                    }
                });
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
</script>