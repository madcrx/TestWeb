<?php
require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        getBlogPosts();
        break;
    case 'POST':
        createBlogPost();
        break;
    case 'PUT':
        updateBlogPost();
        break;
    case 'DELETE':
        deleteBlogPost();
        break;
    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
}

function getBlogPosts() {
    global $db;
    
    $query = "SELECT bp.*, au.full_name as author_name 
              FROM blog_posts bp 
              LEFT JOIN admin_users au ON bp.author_id = au.id 
              WHERE bp.is_published = 1 
              ORDER BY bp.created_at DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $posts = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $posts[] = $row;
    }
    
    echo json_encode($posts);
}

function createBlogPost() {
    global $db;
    session_start();
    
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        return;
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $query = "INSERT INTO blog_posts SET title=:title, excerpt=:excerpt, content=:content, author_id=:author_id";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':excerpt', $data['excerpt']);
    $stmt->bindParam(':content', $data['content']);
    $stmt->bindParam(':author_id', $_SESSION['admin_id']);
    
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Blog post created successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to create blog post']);
    }
}

function updateBlogPost() {
    global $db;
    session_start();
    
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        return;
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $query = "UPDATE blog_posts SET title=:title, excerpt=:excerpt, content=:content WHERE id=:id";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(':id', $data['id']);
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':excerpt', $data['excerpt']);
    $stmt->bindParam(':content', $data['content']);
    
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Blog post updated successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to update blog post']);
    }
}

function deleteBlogPost() {
    global $db;
    session_start();
    
    if (!isLoggedIn()) {
        http_response_code(401);
        echo json_encode(['message' => 'Unauthorized']);
        return;
    }
    
    $data = json_decode(file_get_contents("php://input"), true);
    
    $query = "DELETE FROM blog_posts WHERE id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $data['id']);
    
    if ($stmt->execute()) {
        echo json_encode(['message' => 'Blog post deleted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Unable to delete blog post']);
    }
}
?>