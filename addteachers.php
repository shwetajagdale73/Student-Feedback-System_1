<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $teacherName = $_POST["teacher_name"];
    $subjectName = $_POST["subject_name"];
    $className = $_POST["class_name"];

    // Database connection details
    $servername = "localhost"; // Replace with your server name if necessary
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $dbname = "studentdb"; // Replace with your database name

    // Create a new connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to insert data into the table
    $sql = "INSERT INTO class_to_teachers_mapping (teacher_name, subject_name, class_name)
            VALUES ('$teacherName', '$subjectName', '$className')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Mapping</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Add Mapping</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Teacher Name:</label>
        <input type="text" name="teacher_name" required><br><br>

        <label>Subject Name:</label>
        <input type="text" name="subject_name" required><br><br>

        <label>Class Name:</label>
        <input type="text" name="class_name" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
