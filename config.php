<?php
// Database configuration
$config = [
    'db_host' => 'localhost',
    'db_name' => 'beautiful_funerals',
    'db_user' => 'your_username',
    'db_pass' => 'your_password'
];

// Site configuration
define('SITE_URL', 'https://beautifulfunerals.au');
define('SITE_NAME', 'Beautiful Funerals');
define('SITE_EMAIL', 'info@beautifulfunerals.au');
define('ADMIN_EMAIL', 'admin@beautifulfunerals.au');

// File upload configuration
define('UPLOAD_PATH', __DIR__ . '/assets/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_FILE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

// Timezone
date_default_timezone_set('Australia/Melbourne');

// Error reporting
define('ENVIRONMENT', 'production'); // Change to 'development' for debugging

if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

return $config;
?>