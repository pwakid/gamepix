<?php
// Create connection
$conn = new mysqli("localhost", "arcade", "arcade", "arcade");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$url = "https://games.gamepix.com/games?sid=E78D4"; // Adjusted for games
// Use cURL to send the request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
// Decode the JSON response
$data = json_decode($response, true);

foreach ($data['data'] as $game) {
    $id = $game['id']; // Assuming 'id' is provided and is an integer
    $title = $game['title'];
    $description = $game['description'] ?? "N/A"; // Providing a default description
    $thumbnailUrl = $game['thumbnailUrl'] ?? "N/A"; // Providing a default thumbnail URL
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title))); // Generating a slug based on the title

    // Additional placeholders for missing data in this context
    // You need to adjust these variables based on the actual data structure you receive from the API
    $category = ''; // Placeholder: You might need to process categories if available
    $author = ''; // Placeholder
    $thumbnailUrl100 = ''; // Placeholder
    $url = ''; // Placeholder for the game URL
    $rkScore = 0; // Placeholder: Assuming rkScore is an integer
    $height = 0; // Placeholder
    $width = 0; // Placeholder
    $orientation = ''; // Placeholder
    $responsive = 0; // Placeholder: Assuming it's a boolean represented as an integer (0 or 1)
    $touch = 0; // Placeholder
    $hwcontrols = 0; // Placeholder
    $featured = 0; // Placeholder
    $creation = ''; // Placeholder
    $lastUpdate = ''; // Placeholder
    $size = ''; // Placeholder
    $min_android_version = ''; // Placeholder
    $min_ios_version = ''; // Placeholder
    $min_wp_version = ''; // Placeholder
    $visibility = 1; // Assuming visible by default
    $game_plays = 0; // Placeholder
    $sort_order = 0; // Placeholder

    // Check if the game already exists
    $stmt = $conn->prepare("SELECT id FROM games WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert the new game
        $insertStmt = $conn->prepare("INSERT INTO games (id, title, description, category, author, thumbnailUrl, thumbnailUrl100, url, rkScore, height, width, orientation, responsive, touch, hwcontrols, featured, creation, lastUpdate, size, min_android_version, min_ios_version, min_wp_version, visibility, game_plays, sort_order, slug_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertStmt->bind_param("ssssssssiiisiiiiissssssiiis", $id, $title, $description, $category, $author, $thumbnailUrl, $thumbnailUrl100, $url, $rkScore, $height, $width, $orientation, $responsive, $touch, $hwcontrols, $featured, $creation, $lastUpdate, $size, $min_android_version, $min_ios_version, $min_wp_version, $visibility, $game_plays, $sort_order, $slug);
        $insertStmt->execute();

        echo "Inserted new game: " . $title . "\n";
    } else {
        echo "Game already exists: " . $title . "\n";
    }
    $stmt->close();
}

$conn->close();
?>
