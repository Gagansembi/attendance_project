<?php
$servername = "localhost";
$username = "attendance_user";
$password = "secure_password";
$dbname = "AttendanceDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Example: Fetch employees
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Employee: " . $row["name"] . " - Department: " . $row["department"] . "<br>";
    }
} else {
    echo "No records found.";
}

$conn->close();
?>

