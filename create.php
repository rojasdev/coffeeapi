<?php
include 'config.php';  // Database connection

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (
    !isset($data['coffee_name']) ||
    !isset($data['coffee_description']) ||
    !isset($data['coffee_origin']) ||
    !isset($data['coffee_roast'])
) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Use default image if not provided
$coffee_image_url = isset($data['coffee_image_url']) && !empty($data['coffee_image_url']) 
    ? $data['coffee_image_url'] 
    : 'https://raw.githubusercontent.com/rojasdev/images/refs/heads/main/coffee.jpg';

try {
    // Insert new coffee into database
    $stmt = $pdo->prepare("INSERT INTO tbl_coffee (coffee_name, coffee_description, coffee_image_url, coffee_origin, coffee_roast) VALUES (:name, :description, :image, :origin, :roast)");
    
    $stmt->execute([
        ':name' => $data['coffee_name'],
        ':description' => $data['coffee_description'],
        ':image' => $coffee_image_url,
        ':origin' => $data['coffee_origin'],
        ':roast' => $data['coffee_roast']
    ]);

    // Return success response
    echo json_encode(['success' => true, 'message' => 'Coffee added successfully']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>