<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        getServices();
        break;
    case 'POST':
        createService();
        break;
    case 'PUT':
        updateService();
        break;
    case 'DELETE':
        deleteService();
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
}

function getServices() {
    global $db;
    
    $query = "SELECT * FROM services WHERE is_published = 1 ORDER BY service_date ASC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $services = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $services[] = $row;
    }
    
    echo json_encode($services);
}

function createService() {
    global $db;
    session_start();
    
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        return;
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $query = "INSERT INTO services SET name=:name, service_date=:service_date, location=:location, description=:description, livestream_url=:livestream_url, condolences_url=:condolences_url";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':service_date', $data['service_date']);
    $stmt->bindParam(':location', $data['location']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':livestream_url', $data['livestream_url']);
    $stmt->bindParam(':condolences_url', $data['condolences_url']);
    
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Service created successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to create service']);
    }
}

function updateService() {
    global $db;
    session_start();
    
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        return;
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $query = "UPDATE services SET name=:name, service_date=:service_date, location=:location, description=:description, livestream_url=:livestream_url, condolences_url=:condolences_url WHERE id=:id";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':id', $data['id']);
    $stmt->bindParam(':name', $data['name']);
    $stmt->bindParam(':service_date', $data['service_date']);
    $stmt->bindParam(':location', $data['location']);
    $stmt->bindParam(':description', $data['description']);
    $stmt->bindParam(':livestream_url', $data['livestream_url']);
    $stmt->bindParam(':condolences_url', $data['condolences_url']);
    
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Service updated successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to update service']);
    }
}

function deleteService() {
    global $db;
    session_start();
    
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        return;
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $query = "DELETE FROM services WHERE id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $data['id']);
    
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Service deleted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to delete service']);
    }
}
?>