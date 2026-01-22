<?php
require 'session.php';
require 'db.php';

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Check login
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>

<h1>Welcome to my site</h1>

<?php if (isset($user)): ?>
    <p>
        Logged In User:
        <?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <form method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>

<?php else: ?>
    <a href="login.php">
        <button>Login</button>
    </a>
<?php endif; ?>

</body>
</html>