<?php
include 'config.php';  // Database connection

// Retrieve item created
$stmt = $pdo->prepare("SELECT coffee_id, coffee_name, coffee_description, coffee_image_url, coffee_origin, coffee_roast FROM tbl_coffee");
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output the result in JSON format
echo json_encode([
    'message' => 'Product list retrieved successfully',
    'items' => $items
]);
?>
