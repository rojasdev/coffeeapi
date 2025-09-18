<?php
header("Content-Type: application/json");
require "config.php";

try {
    // Retrieve all inquiries
    $stmt = $pdo->prepare("SELECT inquiry_id, coffee_name, name, email, inquiry, created_at
                           FROM tbl_inquiry
                           ORDER BY created_at DESC");
    $stmt->execute();
    $inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "message" => "Inquiry list retrieved successfully",
        "data" => $inquiries
    ], JSON_PRETTY_PRINT);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Server error: " . $e->getMessage()
    ]);
}
