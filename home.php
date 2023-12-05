<link rel="stylesheet" href="home.css">
<section>
    <div class="container mt-4 overflow-auto">
        <div class="row">
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
                function getCookie(name) {
                    const value = `; ${document.cookie}`;
                    const parts = value.split(`; ${name}=`);
                    if (parts.length === 2) return parts.pop().split(';').shift();
                }

                function handleTimeslotClick(weekday, time) {
                    const xhttp = new XMLHttpRequest();
                    xhttp.open('POST', "time_slot_processing.php", true);
                    xhttp.setRequestHeader('Content-Type', 'application/json');
                    xhttp.onreadystatechange = function() {
                        if (xhttp.readyState === XMLHttpRequest.DONE && xhttp.status === 200) {
                            console.log(xhttp.responseText);
                        } else if (xhttp.status !== 200) {
                            console.error('Error:', xhr.status);
                        }
                    };
                    let selectedDay = new Date(getCookie("selected_day"));
                    let month = selectedDay.getUTCMonth() + 1; //months from 1-12
                    let day = selectedDay.getUTCDate() + 1;
                    let year = selectedDay.getUTCFullYear();
                    xhttp.send(JSON.stringify({
                        "year": year,
                        "month": month,
                        "day": day,
                        "weekday": weekday,
                        "time": time,
                    }));
                }
            </script>
</section>