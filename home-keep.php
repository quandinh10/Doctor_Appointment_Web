<!-- <?php

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
$daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
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
?> -->