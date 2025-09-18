<?php
include 'config.php';

header("Content-Type: application/json; charset=UTF-8");

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($data['name'], $data['email'], $data['inquiry'])) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Name, email, and inquiry are required."
    ]);
    exit;
}

$name = trim($data['name']);
$email = trim($data['email']);
$inquiry = trim($data['inquiry']);
$coffee_name = isset($data['coffee_name']) ? trim($data['coffee_name']) : null;

try {
    $stmt = $pdo->prepare("INSERT INTO tbl_inquiry (coffee_name, name, email, inquiry) VALUES (:coffee_name, :name, :email, :inquiry)");
    $stmt->execute([
        ':coffee_name' => $coffee_name,
        ':name' => $name,
        ':email' => $email,
        ':inquiry' => $inquiry
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Inquiry submitted successfully."
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error saving inquiry.",
        "error" => $e->getMessage()
    ]);
}
?>
