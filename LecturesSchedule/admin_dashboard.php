<?php
session_start();
include('db.php');

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>

<header class="header">
    <div class="header-left">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="header-right">
        <span class="welcome-message">Welcome, Admin: <?php echo $_SESSION['user_name']; ?></span>
        <form action="logout.php" method="POST" class="logout-form">
            <button type="submit">Logout</button>
        </form>
    </div>
</header>

<div class="container">
    <div class="form-container">
        <div class="form-card">
            <h2>Add Course</h2>
            <form action="add_course.php" method="POST" enctype="multipart/form-data">
                <label for="name">Course Name:</label>
                <input type="text" name="name" required><br>
                <label for="level">Level:</label>
                <input type="text" name="level" required><br>
                <label for="description">Description:</label>
                <textarea name="description" required></textarea><br>
                <label for="image">Image:</label>
                <input type="file" name="image" required><br>
                <button type="submit">Add Course</button>
            </form>
        </div>

        <div class="form-card">
            <h2>Add Lecture</h2>
            <form action="add_lecture.php" method="POST">
                <label for="course_id">Course:</label>
                <select name="course_id" required>
                    <?php
                    $courses_result = mysqli_query($conn, "SELECT * FROM courses");
                    while ($course = mysqli_fetch_assoc($courses_result)) {
                        echo "<option value='{$course['id']}'>{$course['name']}</option>";
                    }
                    ?>
                </select><br>

                <label for="instructor_id">Instructor:</label>
                <select name="instructor_id" required>
                    <?php
                    $instructors_result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'instructor'");
                    while ($instructor = mysqli_fetch_assoc($instructors_result)) {
                        echo "<option value='{$instructor['id']}'>{$instructor['name']}</option>";
                    }
                    ?>
                </select><br>

                <label for="lecture_date">Date:</label>
                <input type="date" name="lecture_date" required min="<?php echo date('Y-m-d'); ?>"><br>


                <label for="batch_number">Batch Number:</label>
                <input type="number" name="batch_number" required min="1"><br>

                <button type="submit">Add Lecture Batch</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
