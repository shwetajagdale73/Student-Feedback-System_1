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

// Check if the form is submitted
if (isset($_POST["submit"])) {
// Retrieve form data
$teacherNames = array_keys($_POST["question1"]);
$question1Scores = $_POST["question1"];
$question2Scores = $_POST["question2"];

// Loop through the submitted data
foreach ($teacherNames as $teacherName) {
    $question1Score = $question1Scores[$teacherName];
    $question2Score = $question2Scores[$teacherName];

    // Prepare the SQL statement to insert the form data into the table
    $sql = "INSERT INTO Questions_score (question1, question1_score, question2, question2_score, teacher_name)
            VALUES ('question1', $question1Score, 'question2', $question2Score, '$teacherName')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully for $teacherName!<br>";
    } else {
        echo "Error: " . $conn->error;
    }
}
}

// Close the connection
$conn->close();
?>