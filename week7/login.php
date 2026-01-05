<?php
session_start();
include "db.php";

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $student_id = $_POST["student_id"];
    $password   = $_POST["password"];

    $sql = "SELECT * FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){

        $row = $result->fetch_assoc();

        if(password_verify($password, $row["password"])){

            $_SESSION["logged_in"] = true;
            $_SESSION["name"] = $row["name"];

            header("Location: dashboard.php");
            exit;

        } else {
            $message = "Wrong password";
        }

    } else {
        $message = "Student ID not found";
    }
}
?>

<h2>Login</h2>
<p><?php echo $message; ?></p>

<form method="post">
    Student ID: <input type="text" name="student_id" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>

<a href="register.php">Register</a>
