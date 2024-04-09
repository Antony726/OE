<?php
// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'] ?? '';
    $register_no = $_POST['Register'] ?? '';
    $dept = $_POST['Dept'] ?? '';
    $year = isset($_POST['year']) ? (int)$_POST['year'] : 0;
    $subject = $_POST['Subject'] ?? '';

    // Convert year to integer
    $year = intval($year);

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "1234567";
    $dbname = "subjects";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname, 3308);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the subject is available in the old table and there are available seats
    $sql = "SELECT id,total_seats, available_seats FROM subjects WHERE dept <> ? AND years = ? AND subjects = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("Error in prepared statement: " . $conn->error);
    }

    $stmt->bind_param("sis", $dept, $year, $subject);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id=$row['id'];
        $total_seats = $row['total_seats'];
        $available_seats = $row['available_seats'];

        if ($available_seats > 0) {
            // Insert form data into the new table
            $sql_insert = "INSERT INTO selected_subjects (register_no, name, dept, years, subject) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("issss", $register_no, $name, $dept, $year, $subject);

            if ($stmt_insert->execute()) {
                echo "Record inserted successfully";
                // Decrease available seat count in the old table
                $new_available_seats = $available_seats - 1;
                $sql_update = "UPDATE subjects SET available_seats = ? WHERE id = ? AND years = ? AND subjects = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param("iiss", $new_available_seats, $id, $year, $subject);
                $stmt_update->execute();
                $stmt_update->close();
            } else {
                echo "Error inserting record: " . $stmt_insert->error;
            }

            $stmt_insert->close();
        } else {
            echo "No available seats for selected subject";
        }
    } else {
        echo "Subject not found in the old table";
    }

    $stmt->close();
    $conn->close();
}