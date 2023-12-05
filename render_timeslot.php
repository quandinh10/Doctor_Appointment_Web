<?php
require_once 'config.php';
header('Content-Type: application/json');
if (isset($_POST["year"]) && isset($_POST["month"]) && isset($_POST["day"])) {
    $year = $_POST["year"];
    $month = $_POST["month"];
    $day = $_POST["day"];
    $query = "SELECT DayOfWeek, StartTime, statusSlot FROM slot WHERE Year = {$year} AND Month = {$month} AND Day = {$day}";
    $res = $mysqli->query($query);

    $slot_available = array();
    if ($res->num_rows > 0) {
        while($row = $res->fetch_assoc()) {
            echo $row["DayOfWeek"];
          }
    }
}
?>