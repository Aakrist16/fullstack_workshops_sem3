<?php
session_start();

if(!isset($_SESSION["logged_in"])){
    header("Location: login.php");
    exit;
}

$theme = isset($_COOKIE["theme"]) ? $_COOKIE["theme"] : "light";

$bg   = $theme === "dark" ? "#000" : "#fff";
$font = $theme === "dark" ? "#fff" : "#000";
?>

<body style="background: <?php echo $bg; ?>; color: <?php echo $font; ?>;">

<h2>Welcome, <?php echo $_SESSION["name"]; ?> 🎉</h2>

<ul>
    <li><a href="preference.php">Change Theme</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

</body>
