<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        getMessages();
        break;
    case 'POST':
        createMessage();
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
}

function getMessages() {
    global $db;
    session_start();
    
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        return;
    }
    
    $query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $messages = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $messages[] = $row;
    }
    
    echo json_encode($messages);
}

function createMessage() {
    global $db;
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $query = "INSERT INTO contact_messages SET name=:name, email=:email, subject=:subject, message=:message";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':name', sanitizeInput($data['name']));
    $stmt->bindParam(':email', sanitizeInput($data['email']));
    $stmt->bindParam(':subject', sanitizeInput($data['subject']));
    $stmt->bindParam(':message', sanitizeInput($data['message']));
    
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Message sent successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to send message']);
    }
}
?>