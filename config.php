<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'beautiful_funerals');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');

// Site configuration
define('SITE_URL', 'https://beautifulfunerals.au');
define('SITE_NAME', 'Beautiful Funerals');

// Email configuration
define('EMAIL_FROM', 'noreply@beautifulfunerals.au');
define('EMAIL_ADMIN', 'admin@beautifulfunerals.au');

// File upload configuration
define('UPLOAD_PATH', __DIR__ . '/../assets/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Timezone
date_default_timezone_set('Australia/Melbourne');

// Error reporting
if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>