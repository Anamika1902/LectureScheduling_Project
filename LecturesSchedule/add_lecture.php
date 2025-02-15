<?php
session_start();
include('db.php');

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $instructor_id = $_POST['instructor_id'];
    $lecture_date = $_POST['lecture_date'];
    $batch_number = $_POST['batch_number'];

    // Check if the instructor is already assigned to a course on the same date
    $check_instructor_sql = "SELECT * FROM lectures 
                             WHERE instructor_id = '$instructor_id' 
                             AND lecture_date = '$lecture_date'";
    $check_instructor_result = mysqli_query($conn, $check_instructor_sql);

    if (mysqli_num_rows($check_instructor_result) > 0) {
        echo "<script>alert('The instructor is already assigned to a course on this date.');window.location.href = 'admin_dashboard.php';</script>";
        exit();
    }

    // Check if the course is already assigned to another instructor on the same date
    $check_course_sql = "SELECT * FROM lectures 
                         WHERE course_id = '$course_id' 
                         AND lecture_date = '$lecture_date'";
    $check_course_result = mysqli_query($conn, $check_course_sql);

    if (mysqli_num_rows($check_course_result) > 0) {
        echo "<script>alert('This course is already assigned to another instructor on this date.');window.location.href = 'admin_dashboard.php';</script>";
        exit();
    }

    // If no conflicts, insert the new lecture assignment
    $insert_sql = "INSERT INTO lectures (course_id, instructor_id, lecture_date, batch_number) 
                   VALUES ('$course_id', '$instructor_id', '$lecture_date', '$batch_number')";
    if (mysqli_query($conn, $insert_sql)) {
        echo "<script>alert('Lecture added successfully.');window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>
