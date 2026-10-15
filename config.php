<?php
// ADUHMS Configuration File
// Aliko Dangote University Hospital Management System

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '00000000');
define('DB_NAME', 'aduhmso');

// System Configuration
define('SYSTEM_NAME', 'Aliko Dangote University Hospital Management System');
define('SYSTEM_SHORT_NAME', 'ADUHMS');
define('SYSTEM_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/adu2/');

// Security Configuration
define('SECRET_KEY', 'aduhms_secret_key_2026');
define('SESSION_TIMEOUT', 3600); // 1 hour

// File Upload Configuration
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_EXTENSIONS', 'jpg,jpeg,png,pdf,doc,docx,xls,xlsx');

// Email Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', '');
define('SMTP_PASS', '');

// System Paths
define('UPLOAD_PATH', __DIR__ . '/uploads/');
define('LOG_PATH', __DIR__ . '/logs/');
define('ASSETS_PATH', BASE_URL . 'assets/');
define('PDF_PATH', __DIR__ . '/pdfs/');

// Color Theme Configuration
define('PRIMARY_COLOR', '#28a745'); // Medical green
define('SECONDARY_COLOR', '#ffffff'); // White
define('ACCENT_COLOR', '#1e7e34');

// Working Hours
define('HOSPITAL_OPEN_TIME', '08:00');
define('HOSPITAL_CLOSE_TIME', '20:00');

// Emergency Hotline
define('EMERGENCY_NUMBER', '0800-000-0000');

// Initialize session
session_start();
?>