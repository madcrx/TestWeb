<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        getArrangements();
        break;
    case 'POST':
        createArrangement();
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
}

function getArrangements() {
    global $db;
    session_start();
    
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        return;
    }
    
    $query = "SELECT * FROM arrangements ORDER BY created_at DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $arrangements = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $arrangements[] = $row;
    }
    
    echo json_encode($arrangements);
}

function createArrangement() {
    global $db;
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $query = "INSERT INTO arrangements SET first_name=:first_name, last_name=:last_name, email=:email, phone=:phone, service_type=:service_type, message=:message";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':first_name', sanitizeInput($data['first_name']));
    $stmt->bindParam(':last_name', sanitizeInput($data['last_name']));
    $stmt->bindParam(':email', sanitizeInput($data['email']));
    $stmt->bindParam(':phone', sanitizeInput($data['phone']));
    $stmt->bindParam(':service_type', sanitizeInput($data['service_type']));
    $stmt->bindParam(':message', sanitizeInput($data['message']));
    
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Arrangement request submitted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to submit arrangement request']);
    }
}
?>