<?php
include "db.php";

$id = $_GET["id"];

$result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if (isset($_POST["update"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $course = $_POST["course"];

    $sql = "UPDATE students SET
            name='$name',
            email='$email',
            course='$course'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo "Update failed";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>

<h2>Edit Student</h2>

<form method="post">
    Name: <input type="text" name="name" value="<?= $data['name'] ?>"><br><br>
    Email: <input type="email" name="email" value="<?= $data['email'] ?>"><br><br>
    Course: <input type="text" name="course" value="<?= $data['course'] ?>"><br><br>
    <button type="submit" name="update">Update</button>
</form>

<br>
<a href="index.php">Back</a>

</body>
</html>
