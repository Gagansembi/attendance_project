<!DOCTYPE html>
<html>
<head>
    <title>Attendance Upload</title>
</head>
<body>
    <h1>Upload Attendance File</h1>

    <!-- HTML Form -->
    <form action="attendance_upload.php" method="post" enctype="multipart/form-data">
        <label for="attendance_file">Choose Attendance File (TXT format):</label>
        <input type="file" name="attendance_file" id="attendance_file" required>
        <br><br>
        <button type="submit">Upload</button>
    </form>

    <?php
    // PHP Logic
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $uploadedFile = $_FILES['attendance_file']['tmp_name'];
        if ($uploadedFile) {
            $serverName = "localhost";
            $username = "attendance_user";
            $password = "Securepassword@12";
            $database = "AttendanceDB";

            // Establish MySQL connection
            $conn = new mysqli($serverName, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Open and process the uploaded file
            $file = fopen($uploadedFile, "r");
            $lineNumber = 0;

            while (($line = fgetcsv($file, 1000, "\t")) !== FALSE) {
                // Skip the header row
                if ($lineNumber == 0) {
                    $lineNumber++;
                    continue;
                }

                $employee_code = $line[2]; // Employee Code (adjust index as per your file)
                $dateTime = strtotime($line[9]); // DateTime (adjust index as per your file)
                $date = date("Y-m-d", $dateTime); // Extract date
                $time = date("H:i:s", $dateTime); // Extract time
                $status = $line[11] ?? 'Present'; // Default to 'Present'

                // Insert into MySQL table
                $sql = "INSERT INTO attendance (employee_code, date, time_in, status)
                        VALUES ('$employee_code', '$date', '$time', '$status')";

                if (!$conn->query($sql)) {
                    echo "Error inserting record: " . $conn->error . "<br>";
                }
            }

            fclose($file);
            $conn->close();
            echo "<p>Attendance uploaded successfully!</p>";
        } else {
            echo "<p>No file uploaded.</p>";
        }
    }
    ?>
</body>
</html>
