<?php
session_start();
include('db.php');

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $level = $_POST['level'];
    $description = $_POST['description'];
    $image = $_FILES['image']['name'];
       
    move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $image);
    
    $sql = "INSERT INTO courses (name, level, description, image) VALUES ('$name', '$level', '$description', '$image')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Course added successfully.');window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');window.location.href = 'admin_dashboard.php';</script>";
    }
}
?>
