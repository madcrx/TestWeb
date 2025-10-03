<?php
// Set headers for API
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: ' . ($_SERVER['HTTP_ORIGIN'] ?? '*'));
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

// Include required files
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

// Global error handler for API
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    error_log("API Error: $errstr in $errfile on line $errline");
    if (ENVIRONMENT === 'development') {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Server error: ' . $errstr
        ]);
        exit;
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'An internal server error occurred'
        ]);
        exit;
    }
});

// Global exception handler
set_exception_handler(function($exception) {
    error_log("API Exception: " . $exception->getMessage());
    if (ENVIRONMENT === 'development') {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Server exception: ' . $exception->getMessage()
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'An internal server error occurred'
        ]);
    }
    exit;
});

// Get database connection
try {
    $database = new Database();
    $db = $database->getConnection();
} catch (Exception $e) {
    http_response_code(503);
    echo json_encode([
        'success' => false,
        'message' => 'Service temporarily unavailable'
    ]);
    exit;
}
?>