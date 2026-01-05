<?php
$name = $email = $password = $confirm_password = "";
$nameErr = $emailErr = $passwordErr = $confirmPasswordErr = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ------------ VALIDATION -------------

    // Name validation
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = trim($_POST["name"]);
    }

    // Email validation
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Password validation
    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters long";
        }
    }

    // Confirm password validation
    if (empty($_POST["confirm_password"])) {
        $confirmPasswordErr = "Please confirm password";
    } else {
        $confirm_password = $_POST["confirm_password"];
        if ($password !== $confirm_password) {
            $confirmPasswordErr = "Passwords do not match";
        }
    }

    // If no errors → Save user
    if ($nameErr == "" && $emailErr == "" && $passwordErr == "" && $confirmPasswordErr == "") {

        $file = "users.json";

        // Read JSON file
        if (file_exists($file)) {
            $jsonData = file_get_contents($file);
            $users = json_decode($jsonData, true);
        } else {
            $users = [];
        }

        if (!is_array($users)) {
            $users = [];
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // New user array
        $newUser = [
            "name" => $name,
            "email" => $email,
            "password" => $hashedPassword
        ];

        // Add new user to array
        $users[] = $newUser;

        // Write back to JSON file
        if (file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT))) {
            $successMsg = "Registration successful!";
        } else {
            $successMsg = "Error saving user data!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <style>
        .error { color: red; }
        .success { color: green; margin-bottom: 10px; }
        label { display: block; margin-top: 10px; }
        input { padding: 6px; width: 250px; }
    </style>
</head>
<body>

<h2>User Registration Form</h2>

<?php if ($successMsg) echo "<div class='success'>$successMsg</div>"; ?>

<form method="post" action="">
    
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo $name; ?>">
    <span class="error"><?php echo $nameErr; ?></span>

    <label>Email:</label>
    <input type="text" name="email" value="<?php echo $email; ?>">
    <span class="error"><?php echo $emailErr; ?></span>

    <label>Password:</label>
    <input type="password" name="password">
    <span class="error"><?php echo $passwordErr; ?></span>

    <label>Confirm Password:</label>
    <input type="password" name="confirm_password">
    <span class="error"><?php echo $confirmPasswordErr; ?></span>

    <br><br>
    <input type="submit" value="Register">

</form>

</body>
</html>
