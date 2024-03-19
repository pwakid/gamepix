<?php
function sanitizeInput($data)
{
  $data = trim($data);

    if (filter_var($data, FILTER_VALIDATE_EMAIL))
    {
        $data = filter_var($data, FILTER_SANITIZE_EMAIL);
    }
    if (filter_var($data, FILTER_VALIDATE_URL))
    {
        $data = filter_var($data, FILTER_SANITIZE_URL);
    }

      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $data = iconv("UTF-8", "ASCII//IGNORE", $data);
return $data;
}

// Create connection
$conn = new mysqli("localhost", "arcade", "arcade", "arcade");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$url = "https://games.gamepix.com/games?sid=E78D4&limit=10"; // Adjusted for games
// Use cURL to send the request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
// Decode the JSON response
$data = json_decode($response, true);

foreach ($data['data'] as $game) {
  // Assuming 'sanitizeInput' has been defined as shown previously
  $id = isset($game['id']) ? sanitizeInput($game['id']) : 0; // Casting to int, assuming IDs are integers
  $title = sanitizeInput($game['title']);
  $description = isset($game['description']) ? sanitizeInput($game['description']) : "N/A"; // Providing a default description and sanitizing
  $slug_url = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title))); // Slug based on the title, no need for HTML sanitization
  $category = isset($game['category']) ? sanitizeInput($game['category']) : ''; // Assuming 'category' might be provided
  $author = isset($game['author']) ? sanitizeInput($game['author']) : ''; // Assuming 'author' might be provided
  $thumbnailUrl100 = isset($game['thumbnailUrl100']) ? sanitizeInput($game['thumbnailUrl100']) : ''; // Assuming an alternative thumbnail URL might be provided
  $gurl = $game['url']; // Game URL
  $rkScore = isset($game['rkScore']) ? (int)$game['rkScore'] : 0; // Ensuring it's numeric
  $height = isset($game['height']) ? (int)$game['height'] : 0;
  $width = isset($game['width']) ? (int)$game['width'] : 0;
  $orientation = isset($game['orientation']) ? sanitizeInput($game['orientation']) : '';
  $responsive = isset($game['responsive']) ? (int)$game['responsive'] : 0; // Assuming true/false converted to 1/0
  $touch = isset($game['touch']) ? (int)$game['touch'] : 0;
  $hwcontrols = isset($game['hwcontrols']) ? (int)$game['hwcontrols'] : 0;
  $featured = isset($game['featured']) ? (int)$game['featured'] : 0;
  $creation = isset($game['creation']) ? sanitizeInput($game['creation']) : ''; // Date or text about creation, sanitize if textual
  $lastUpdate = isset($game['lastUpdate']) ? sanitizeInput($game['lastUpdate']) : ''; // Date or text about the last update, sanitize if textual
  $size = isset($game['size']) ? sanitizeInput($game['size']) : '';
  $min_android_version = isset($game['min_android_version']) ? sanitizeInput($game['min_android_version']) : '';
  $min_ios_version = isset($game['min_ios_version']) ? sanitizeInput($game['min_ios_version']) : '';
  $min_wp_version = isset($game['min_wp_version']) ? sanitizeInput($game['min_wp_version']) : '';
  $visibility = isset($game['visibility']) ? (int)$game['visibility'] : 1; // Default to visible
  $game_plays = isset($game['game_plays']) ? (int)$game['game_plays'] : 0;
  $sort_order = isset($game['sort_order']) ? (int)$game['sort_order'] : 0;

// Placeholder

    // Check if the game already exists
    $stmt = $conn->prepare("SELECT id FROM games WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert the new game
        $insertStmt = $conn->prepare("INSERT INTO games (id, title, description, thumbnailUrl, category, author, thumbnailUrl100, url, rkScore, height, width, orientation, responsive, touch, hwcontrols, featured, creation, lastUpdate, size, min_android_version, min_ios_version, min_wp_version, visibility, game_plays, sort_order, slugUrl) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $insertStmt->bind_param("ssssssssssssssssssssssssss",
                          $id, $title, $description, $thumbnailUrl, $category, $author, $thumbnailUrl100, $gurl,
                          $rkScore, $height, $width, $orientation, $responsive, $touch, $hwcontrols, $featured,
                          $creation, $lastUpdate, $size, $min_android_version, $min_ios_version, $min_wp_version,
                          $visibility, $game_plays, $sort_order, $slug_url);
$insertStmt->execute();

        echo "Inserted new game: " . $title . "\n";
    } else {
        echo "Game already exists: " . $title . "\n";
    }
    $stmt->close();
}

$conn->close();
?>
