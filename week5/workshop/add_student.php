<?php
function NewName($name){
    return trim($name);
}

function ValidEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function MainSkills($skills){
    return (explode(",", $skills));
}

function SaveStudents($name, $email, $skillsArray){
    $skillsString = implode(",", $skillsArray);
    $data = $name . "||" . $email . "||" . $skillsString . PHP_EOL;
    file_put_contents("students.txt", $data, FILE_APPEND);
}

$message = "";

try{
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $name = NewName($_POST["name"]);
        $email = $_POST["email"];
        $skills = MainSkills($_POST["skills"]);

        if (empty($name) || empty($email)){
            throw new Exception("Name and Email are required");
        }

        if (!ValidEmail($email)){
            throw new Exception("Invalid Email format");
        }

        SaveStudents($name, $email, $skills);
        $message = "Student saved successfully";
    }
}catch(Exception $e){
    $message = $e->getMessage();
}
?>




<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
<?php include "header.php"; ?>
<h2>Add Student Info</h2>

<p><?php echo $message; ?></p>

<form method="post">
    <h4>Name:</h4> <input type="text" name="name"><br><br>
    <h4>Email:</h4> <input type="text" name="email"><br><br>
    <h4>Skills:</h4> <input type="text" name="skills"><br><br>
    <button type="submit">Save Student</button>
</form>

<br>

<a href="index.php">Back to Home</a>

<?php include "footer.php"; ?>

</body>
</html>