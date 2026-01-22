<?php
require 'session.php';
require 'db.php';

$error = '';

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF validation
    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die("Invalid request");
    }

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Invalid email or password";
    } else {

        $stmt = $pdo->prepare(
            "SELECT id, password FROM users WHERE email = ?"
        );
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];

            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<?php if ($error): ?>
    <p style="color:red;">
        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
    </p>
<?php endif; ?>

<form method="POST">

    <input type="hidden" name="csrf_token"
           value="<?php echo $_SESSION['csrf_token']; ?>">

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

<br>
<a href="signup.php">Go to Signup</a>

</body>
</html>
