<?php
// ADUHMS General Dashboard - Redirects to role-specific dashboard
require_once 'includes/auth.php';

// Check if user is logged in
if (!is_logged_in()) {
    header('Location: login.php');
    exit();
}

// Check session timeout
check_session_timeout();

// Get user role and redirect to appropriate dashboard
$user_role = $_SESSION['role'];

// Redirect user based on role
redirect_user($user_role);
?>