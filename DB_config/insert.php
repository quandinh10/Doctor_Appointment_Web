<?php
// Create a connection
$mysqli = new mysqli("localhost", "root", "", "medicalDoctor");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$hashed_password_new_user = password_hash('superdoctor123', PASSWORD_DEFAULT);
$product_sql = "INSERT INTO user (firstname, lastname, email, password, availableSlot, role) VALUES ('user', 'new', 'abc@gmail.com', '$hashed_password_new_user','0','doctor')";
if ($mysqli->query($product_sql) === TRUE) {
    echo "New doctor inserted successfully.<br>";
} else {
    echo "Error inserting products: " . $mysqli->error . "<br>";
}


$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
foreach ($daysOfWeek as $day) {
    $start_time = strtotime('09:00:00');
    $end_time = strtotime('21:00:00');
    $interval = 30 * 60; // 30 minutes in seconds

    $current_time = $start_time;
    while ($current_time < $end_time) {
        $start_time_formatted = date('H:i:s', $current_time);
        $end_time_formatted = date('H:i:s', $current_time + $interval);

        // Insert into the slot table
        $sql_insert_slot = "INSERT INTO slot (DayOfWeek, StartTime, EndTime, statusSlot) 
                            VALUES ('$day', '$start_time_formatted', '$end_time_formatted', 'available')";
        $mysqli->query($sql_insert_slot);

        // Move to the next time slot
        $current_time += $interval;
    }
}

$mysqli->close();
?>
