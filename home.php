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
            $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $start_time = strtotime("09:00");
            $end_time = strtotime("21:00");

            while ($start_time <= $end_time) {
                $current_time = date("H:i", $start_time);
                echo "<tr>";
                echo "<td>$current_time - " . date("H:i", strtotime('+30 minutes', $start_time)) . "</td>";

                foreach ($daysOfWeek as $day) {
                    echo "<td class='timeslot' onclick='handleTimeslotClick(\"$day\", \"$current_time\")'></td>";
                }

                echo "</tr>";

                $start_time = strtotime('+30 minutes', $start_time);
            }
            ?>
        </tbody>
    </table>
    <script>
    function handleTimeslotClick(day, time) {
        alert("Clicked timeslot on ${day} at ${time}");
        // Implement your logic for handling timeslot clicks
    }
</script>
</section>
      