<?php
session_start();
include('db.php');

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; 

    if (strlen($password) < 8) {
        $error_message = 'Password must be at least 8 characters.';
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error_message = 'Password must contain at least one uppercase letter.';
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error_message = 'Password must contain at least one number.';
    } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $error_message = 'Password must contain at least one special character.';
    }

    if (!empty($error_message)) {
    } 
    else {
       
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM users WHERE email='$email' OR name='$name'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $error_message = 'Email or Name already exists. Please try another one.';
        } else {
          
            $sql = "INSERT INTO users (name, email, password, role) 
                    VALUES ('$name', '$email', '$hashed_password', '$role')";

            if (mysqli_query($conn, $sql)) {
                $success_message = 'Registration successful. Please login.';
               
                echo "<script>window.location.href = 'login.php';</script>";
                exit();
            } else {
                $error_message = 'Error: ' . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h2>Registration</h2>

    <?php if ($success_message): ?>
        <p style="color: green;"><?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <p style="color: red;"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <form action="index.php" method="POST">
        <div class="form-group">
            Name: <input type="text" name="name" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required><br>
        </div>
        <div class="form-group">
            Email: <input type="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required><br>
        </div>
        <div class="form-group">
            Password: <input type="password" name="password" required><br>
        </div>

        <div class="form-group">
            Role: 
            <select name="role" required>
                <option value="instructor" <?= isset($role) && $role == 'instructor' ? 'selected' : '' ?>>Instructor</option>
                <option value="admin" <?= isset($role) && $role == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select><br>
        </div>

        <button type="submit">Register</button>
    </form>

   <a href="login.php"> Already have an account? Login here.</a>
</div>
</body>
</html>
