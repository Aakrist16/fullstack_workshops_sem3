<!DOCTYPE html>
<html>
<body>

<?php include "header.php"; ?>

<h2>Saved Students</h2>

<?php
if (file_exists("students.txt")) {
    $students = file("students.txt");

    foreach ($students as $student) {
        list($name, $email, $skills) = explode("||", $student);
        $skillsArray = explode(",", $skills);

        echo "<strong>Name:</strong> $name <br>";
        echo "<strong>Email:</strong> $email <br>";
        echo "<strong>Skills: $skills </strong> <br> <br>";
    }
} else {
    echo "No student data found!";
}
?>

<a href="index.php">Back to Home</a>


<?php include "footer.php"; ?>
</body>
</html>
