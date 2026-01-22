<?php
require 'session.php';

// Destroy session and logout user
session_unset();    // clear all session variables
session_destroy();  // destroy the session

// Redirect to login page
header("Location: login.php");
exit;
