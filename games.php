<?php
// Create connection
$conn = new mysqli("localhost", "arcade", "arcade", "arcade");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$url = "https://games.gamepix.com/games?sid=E78D4";

// Use cURL to send the request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
// Decode the JSON response

$data = json_decode($response, true);

print_r($data);
foreach ($data['data'] as $game) {

    $game_id = $game['id'];
    $name = $game['name'];
    $slug = strtolower(str_replace(' ', '-', $name)); // Simple slug creation; adjust as needed
    $description = $game['description'] ?? "N/A"; // Placeholder, adjust as needed
    $thumbnailUrl = $game['thumbnailUrl']; // Placeholder, adjust as needed

    // Check if the category exists
    $stmt = $conn->prepare("SELECT * FROM games WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {

      $sort_order = 0; // Example sort order value
      $visibility = 1; // 1 for visible, 0 for invisible
        // Insert the new category
        $insertStmt = $conn->prepare("INSERT INTO games (id, title, description, category, author, thumbnailUrl, thumbnailUrl100, url, rkScore, height, width, orientation, responsive, touch, hwcontrols, featured, creation, lastUpdate, size, min_android_version, min_ios_version, min_wp_version, visibility, game_plays, sort_order, slug_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insertStmt->bind_param("ssssssssiiisiiiiissssssiiis", $id, $title, $description, $category, $author, $thumbnailUrl, $thumbnailUrl100, $url, $rkScore, $height, $width, $orientation, $responsive, $touch, $hwcontrols, $featured, $creation, $lastUpdate, $size, $min_android_version, $min_ios_version, $min_wp_version, $visibility, $game_plays, $sort_order, $slug_url);
        $insertStmt->execute();

        echo "Inserted new game: " . $name . "\n";
    } else {
        echo "Category already exists: " . $name . "\n";
    }
    $stmt->close();
    $game = array();
}

$conn->close();
?>
