<?php
session_start();

if(!isset($_SESSION["logged_in"])){
    header("Location: login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $theme = $_POST["theme"];
    setcookie("theme", $theme, time() + (86400 * 30));
    header("Location: dashboard.php");
    exit;
}
?>

<h2>Choose Theme</h2>

<form method="post">
    <select name="theme">
        <option value="light">Light Mode</option>
        <option value="dark">Dark Mode</option>
    </select>

    <button type="submit">Save</button>
</form>

<a href="dashboard.php">Back</a>
