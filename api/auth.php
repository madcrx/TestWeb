<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        login();
        break;
    case 'DELETE':
        logout();
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
}

function login() {
    global $db;
    session_start();
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $query = "SELECT id, username, password_hash FROM admin_users WHERE username = :username AND is_active = 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $data['username']);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($data['password'], $row['password_hash'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            
            // Update last login
            $updateQuery = "UPDATE admin_users SET last_login = NOW() WHERE id = :id";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->bindParam(':id', $row['id']);
            $updateStmt->execute();
            
            echo json_encode(['message' => 'Login successful', 'user' => ['username' => $row['username']]]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid credentials']);
        }
    } else {
        http_response_code(401);
        echo json_encode(['message' => 'Invalid credentials']);
    }
}

function logout() {
    session_start();
    session_destroy();
    echo json_encode(['message' => 'Logout successful']);
}
?>