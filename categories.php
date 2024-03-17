<?php
// Create connection
$conn = new mysqli("localhost", "arcade", "arcade", "arcade");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$url = "https://games.gamepix.com/categories";
// Use cURL to send the request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
// Decode the JSON response

$data = json_decode($response, true);
foreach ($data['data'] as $category) {
  
    $cat_id = $category['id'];
    $name = $category['name'];
    $slug = strtolower(str_replace(' ', '-', $name)); // Simple slug creation; adjust as needed
    $description = $category['description'] ?? "N/A"; // Placeholder, adjust as needed
    $thumbnailUrl = $category['thumbnailUrl']; // Placeholder, adjust as needed

    // Check if the category exists
    $stmt = $conn->prepare("SELECT * FROM categories WHERE cat_id = ?");
    $stmt->bind_param("i", $cat_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert the new category
        $insertStmt = $conn->prepare("INSERT INTO categories (cat_id, name, slug, description, thumbnailUrl) VALUES (?, ?, ?, ?, ?)");
        $insertStmt->bind_param("issss", $cat_id, $name, $slug, $description, $thumbnailUrl);
        $insertStmt->execute();
        
        echo "Inserted new category: " . $name . "\n";
    } else {
        echo "Category already exists: " . $name . "\n";
    }
    $stmt->close();
}

$conn->close();
?>
