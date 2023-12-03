<link rel="stylesheet" href="home.css">
<section>
<div class="container mt-4 overflow-auto">
    <?php include('calendar/index.html') ?>
    <table class="table table-bordered overflow-auto">
        <thead>
            <tr>
                <th scope="col" class="time-col">Time</th>
                <th scope="col" class="day-col">Monday</th>
                <th scope="col" class="day-col">Tuesday</th>
                <th scope="col" class="day-col">Wednesday</th>
                <th scope="col" class="day-col">Thursday</th>
                <th scope="col" class="day-col">Friday</th>
                <th scope="col" class="day-col">Saturday</th>
                <th scope="col" class="day-col">Sunday</th>
            </tr>
        </thead>
        <tbody>
            <?php
                require_once 'session.php';
                require_once 'config.php';
            $availability_data = array();
            
            if ($result = $mysqli->query("SELECT DayOfWeek, StartTime, statusSlot FROM slot")) {
                while ($row = $result->fetch_assoc()) {
                    $availability_data[$row['DayOfWeek']][$row['StartTime']] = $row['statusSlot'];
                }
                $result->free();
            }
            
            $mysqli->close();
            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $start_time = strtotime("09:00:00");
            $end_time = strtotime("21:00:00");

            $start_time_temp = strtotime("09:00");

            $interval = 30 * 60;

            $current_time = $start_time;
            $current_time_temp = $start_time_temp;

            while ($current_time < $end_time) {
                $start_time_formatted = date('H:i:s', $current_time);
                $end_time_formatted = date('H:i:s', $current_time + $interval);

                $start_time_out = date("H:i", $current_time_temp);
                $end_time_out = date("H:i", $current_time_temp + $interval); 
                // echo "<tr>";
                // echo "<td>$current_time - " . date("H:i", strtotime('+30 minutes', $start_time)) . "</td>";

                // foreach ($daysOfWeek as $day) {
                //     echo "<td class='timeslot' onclick='handleTimeslotClick(\"$day\", \"$current_time\")'></td>";
                // }

                // echo "</tr>";
                echo "<tr>";
                echo "<td>$start_time_out - $end_time_out</td>";

                foreach ($daysOfWeek as $day) {
                    $status = isset($availability_data[$day][$start_time_formatted]) ? $availability_data[$day][$start_time_formatted] : 'unavailable';
                    $color = ($status == 'available') ? 'green' : (($status == 'busy') ? 'red' : '');

                    echo "<td class='timeslot' onclick='handleTimeslotClick(\"$day\", \"$start_time_out\")' style='background-color:$color;'></td>";
                }

                echo "</tr>";

                $current_time += $interval;
                $current_time_temp += $interval;
            }
            ?>
        </tbody>
    </table>
    <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        function handleTimeslotClick(wDay, time) {
            var selectedDay = new Date(getCookie("selected_day"));
            var month = selectedDay.getUTCMonth() + 1; //months from 1-12
            var day = selectedDay.getUTCDate() + 1;
            var year = selectedDay.getUTCFullYear();
            var userRole = '<?php echo $_SESSION['role']; ?>';
            var color = document.querySelector(`td[onclick='handleTimeslotClick("${wDay}", "${time}")']`).style.backgroundColor;
            if (userRole === 'doctor') {
                if (color === 'green') {
                    alert(`Doctor clicked timeslot to update to busy on ${day}/${month}/${year}, ${wDay} at ${time}`);
                    updateTimeslotStatus(year, month, day, wDay, time, 'update', 'busy');
                } else if (color === 'red') {
                    alert(`Doctor clicked timeslot to update to available on ${day}/${month}/${year}, ${wDay} at ${time}`);
                    updateTimeslotStatus(year, month, day, wDay, time, 'update', 'available');
                } else {
                    var statusUpdated = prompt(`Choose status for the timeslot on ${day}/${month}/${year}, ${wDay} at ${time}: "available" or "busy"`, 'available');

                    if (statusUpdated === 'available' || statusUpdated === 'busy') {
                        alert(`Doctor create timeslot of ${statusUpdated} on ${day}/${month}/${year}, ${wDay} at ${time}`);
                        updateTimeslotStatus(year, month, day, wDay, time, 'firstUpdate', statusUpdated);
                    } else {
                        alert('Invalid status option. Please choose "available" or "busy".');
                    }
                }
            } else {
                var id = '<?php echo $_SESSION['ID']; ?>';

                if (color === 'green') {
                    alert(`User clicked available timeslot on ${day}/${month}/${year}, ${wDay} at ${time}`);
                    makeAppointment(year, month, day, wDay, time, id);
                } else {
                    alert(`Sorry, the timeslot on ${day}/${month}/${year}, ${wDay} at ${time} is already booked`);
                }
            }
            header("Location: index.php?page=home");
        }

        function updateTimeslotStatus(year, month, day, wDay, time, action, statusUpdated) {
            alert(`debugging ${action} ${statusUpdated}`);
            fetch('update_timeslot_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    year: year,
                    month: month,
                    day: day,
                    wDay: wDay,
                    time: time,
                    statusUpdated: statusUpdated,
                    action: action,
                }),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => {
                alert('Error updating/creating timeslot status');
            });
        }

        function makeAppointment(year, month, day, wDay, time, id) {
            fetch('make_appointment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    year: year,
                    month: month,
                    day: day,
                    wDay: wDay,
                    time: time,
                    id: id,
                    action: 'makeAppointment',
                }),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => {
                alert('Error making appointment');
            });
        }
    </script>
</section>
      