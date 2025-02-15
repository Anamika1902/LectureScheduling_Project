<?php
session_start();
include('db.php');

if ($_SESSION['user_role'] !== 'instructor') {
    header("Location: login.php");
    exit();
}

$instructor_name = $_SESSION['user_name'];
$instructor_id = $_SESSION['user_id'];

$sql = "SELECT lectures.*, courses.name AS course_name, lectures.batch_number 
        FROM lectures 
        INNER JOIN courses ON lectures.course_id = courses.id
        WHERE lectures.instructor_id = '$instructor_id' 
        ORDER BY lectures.lecture_date, lectures.batch_number";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard</title>
    <link rel="stylesheet" href="instructor_dashboard.css">
</head>
<body>
<header class="header">
    <div class="header-left">
        <h1>Instructor Dashboard</h1>
    </div>
    <div class="header-right">
        <span class="welcome-message">Welcome, Instructor: <?php echo $instructor_name; ?></span>
        <form action="logout.php" method="POST" class="logout-form">
            <button type="submit">Logout</button>
        </form>
    </div>
</header>

<div class="container">
    <div class="lecture-info">
        <h2>Your Assigned Lectures</h2>
        <?php
        // Check if there are any assigned lectures
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='lectures-table'>
                    <tr>
                        <th>Course Name</th>
                        <th>Lecture Date</th>
                        <th>Batch Number</th>
                    </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['course_name'] . "</td>
                        <td>" . $row['lecture_date'] . "</td>
                        <td>" . $row['batch_number'] . "</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No lectures assigned.</p>";
        }
        ?>
    </div>
</div>
</body>
</html>
