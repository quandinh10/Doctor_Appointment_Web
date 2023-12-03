<link rel="stylesheet" href="home.css">
<section>
<div class="container mt-4 overflow-auto">
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
        function handleTimeslotClick(day, time) {
            var userRole = '<?php echo $_SESSION['role']; ?>';
            var color = document.querySelector(`td[onclick='handleTimeslotClick("${day}", "${time}")']`).style.backgroundColor;
            if (userRole === 'doctor') {
                if (color === 'green') {
                    alert(`Doctor clicked timeslot to update to busy on ${day} at ${time}`);
                    updateTimeslotStatus(day, time, 'updateToBusy');
                } else if (color === 'red') {
                    alert(`Doctor clicked timeslot to update to available on ${day} at ${time}`);
                    updateTimeslotStatus(day, time, 'updateToAvailable');
                } else {
                    alert('Invalid state for doctor to update');
                }
            } else {
                if (color === 'green') {
                    alert(`User clicked available timeslot on ${day} at ${time}`);
                    makeAppointment(day, time);
                } else {
                    alert(`Sorry, the timeslot on ${day} at ${time} is already booked`);
                }
            }
        }

        function updateTimeslotStatus(day, time, action) {
            fetch('update_timeslot_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    day: day,
                    time: time,
                    action: action,
                }),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => {
                alert('Error updating timeslot status');
            });
        }

        function makeAppointment(day, time) {
            fetch('make_appointment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    day: day,
                    time: time,
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
      