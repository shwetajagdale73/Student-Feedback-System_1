<?php
//Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentdb";
$conn = mysqli_connect($servername, $username, $password, $dbname);

//Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//Query to select unique teacher names
$sql = "SELECT DISTINCT teacher_name FROM Questions_score";
$result = mysqli_query($conn, $sql);

//Check if any results are found
if (mysqli_num_rows($result) > 0) {
    //Loop through each teacher name
    while ($row = mysqli_fetch_assoc($result)) {
        $teacher_name = $row["teacher_name"];

        echo "<h3 style='color: #333;'>Teacher Name: $teacher_name</h3>";

        //Query to select scores for the current teacher name
        $scores_sql = "SELECT question1_score, question2_score FROM Questions_score WHERE teacher_name = '$teacher_name'";
        $scores_result = mysqli_query($conn, $scores_sql);

        //Check if any scores are found
        if (mysqli_num_rows($scores_result) > 0) {
            //Create a table to display the scores
            echo "<table style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th style='border: 1px solid #333; padding: 8px;'>Question1 Score</th><th style='border: 1px solid #333; padding: 8px;'>Question2 Score</th></tr>";

            //Variables to store sum and count for average calculation
            $question1_sum = 0;
            $question2_sum = 0;
            $count = 0;

            //Loop through each score and add a table row
            while ($scores_row = mysqli_fetch_assoc($scores_result)) {
                $question1_score = $scores_row["question1_score"];
                $question2_score = $scores_row["question2_score"];

                echo "<tr>";
                echo "<td style='border: 1px solid #333; padding: 8px;'>$question1_score</td>";
                echo "<td style='border: 1px solid #333; padding: 8px;'>$question2_score</td>";
                echo "</tr>";

                //Calculate sum for average
                $question1_sum += $question1_score;
                $question2_sum += $question2_score;
                $count++;
            }

            //Calculate average
            $question1_avg = ($count > 0) ? $question1_sum / $count : 0;
            $question2_avg = ($count > 0) ? $question2_sum / $count : 0;

            //Display average row
            echo "<tr>";
            echo "<td style='border: 1px solid #333; padding: 8px;'>Average: $question1_avg</td>";
            echo "<td style='border: 1px solid #333; padding: 8px;'>Average: $question2_avg</td>";
            echo "</tr>";

            echo "</table>";
        } else {
            echo "No scores found for $teacher_name.";
        }
    }
} else {
    echo "No teacher names found.";
}

//Close connection
mysqli_close($conn);
?>
