<?php
session_start();
include "db.php";

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $student_id = $_POST["student_id"];
    $name       = $_POST["name"];
    $password   = $_POST["password"];

    $hashed = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO students (student_id, name, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $student_id, $name, $hashed);

    if($stmt->execute()){
        header("Location: login.php");
        exit;
    } else {
        $message = "Registration failed (maybe student_id already exists)";
    }
}
?>

<h2>Register</h2>
<p><?php echo $message; ?></p>

<form method="post">
    Student ID: <input type="text" name="student_id" required><br><br>
    Name: <input type="text" name="name" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Register</button>
</form>

<a href="login.php">Already registered? Login</a>
