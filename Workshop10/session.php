<?php
// Secure session settings
session_set_cookie_params([
    'lifetime' => 0,        // session expires when browser closes
    'path' => '/',
    'domain' => '',
    'secure' => false,      // true if using HTTPS
    'httponly' => true,     // prevent JS access
    'samesite' => 'Lax'     // prevent CSRF
]);

session_start();
