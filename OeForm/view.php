<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Selected Subjects</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Selected Subjects</h2>
    <table>
        <thead>
            <tr>
                <th>Register No</th>
                <th>Name</th>
                <th>Department</th>
                <th>Year</th>
                <th>Subject</th>
            </tr>
        </thead>
        <tbody>
            <?php
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

            // Fetch data from the selected_subjects table
            $sql = "SELECT * FROM selected_subjects";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["register_no"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["dept"] . "</td>";
                    echo "<td>" . $row["years"] . "</td>";
                    echo "<td>" . $row["subject"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No data available</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>