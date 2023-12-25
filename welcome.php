<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

// Retrieve the logged-in user's username
$username = $_SESSION["username"];

// Database connection details
$servername = "localhost"; // Replace with your server name if necessary
$usernameDB = "root"; // Replace with your database username
$passwordDB = ""; // Replace with your database password
$dbname = "studentdb"; // Replace with your database name

// Create a new connection
$conn = new mysqli($servername, $usernameDB, $passwordDB, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to retrieve the user's class
$sql = "SELECT class FROM student WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    // Retrieve the user's class from the result
    $row = $result->fetch_assoc();
    $class = $row["class"];

    // Prepare the SQL statement to retrieve the associated teacher names
    $sql = "SELECT teacher_name FROM class_to_teachers_mapping WHERE class_name = '$class' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the teacher names and questions
        echo "<h2 style='text-align: center; font-family: Arial, sans-serif;'>Welcome, $username!</h2>";
        echo "<p style='text-align: center; font-family: Arial, sans-serif;'>Your class is $class.</p>";

        echo "<form method='POST' action='submit.php' style='width: 300px; margin: 0 auto;'>";
        while ($row = $result->fetch_assoc()) {
            $teacherName = $row["teacher_name"];
            echo "<h3 style='font-family: Arial, sans-serif;'>Teacher: $teacherName</h3>";

            echo "<label for='question1' style='font-family: Arial, sans-serif;'>Question 1:</label>";
            echo "<select name='question1[$teacherName]' id='question1' style='width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 3px; margin-bottom: 15px;'>";
            for ($i = 1; $i <= 10; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            echo "</select><br>";

            echo "<label for='question2' style='font-family: Arial, sans-serif;'>Question 2:</label>";
            echo "<select name='question2[$teacherName]' id='question2' style='width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 3px; margin-bottom: 15px;'>";
            for ($i = 1; $i <= 10; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            echo "</select><br>";

            // Repeat the above code for the remaining questions
        }
        echo "<input type='submit' name='submit' value='Submit' style='background-color: #4CAF50; color: white;
padding: 10px 20px; border: none; border-radius: 3px; cursor: pointer;'>";
echo "</form>";
} else {
echo "<p style='text-align: center; font-family: Arial, sans-serif;'>No associated teachers found for your class.</p>";
}
} else {
echo "<p style='text-align: center; font-family: Arial, sans-serif;'>Error retrieving user's class.</p>";
}

// Close the connection
$conn->close();
?>