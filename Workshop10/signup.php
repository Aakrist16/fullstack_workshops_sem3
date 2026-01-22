<?php
require 'session.php';
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format";
    } elseif (empty($password)) {
        $message = "Password cannot be empty";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters";
    } else {

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Secure insert
        $stmt = $pdo->prepare(
            "INSERT INTO users (email, password) VALUES (?, ?)"
        );
        $stmt->execute([$email, $hashedPassword]);

        $message = "User registered successfully";
        header("refresh:2; url=login.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
</head>
<body>

<h2>Signup</h2>

<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Signup</button>
</form>

<br>
<a href="login.php">Go to Login</a>

</body>
</html>
