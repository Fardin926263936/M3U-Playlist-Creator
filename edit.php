<?php
// Load the playlist
$playlist = file("playlist.m3u", FILE_IGNORE_NEW_LINES);

// Get the channel line to edit
$lineIndex = isset($_GET['line']) ? (int)$_GET['line'] : -1;

if ($lineIndex !== -1 && isset($playlist[$lineIndex])) {
    // Extract the existing channel data
    $channelLine = $playlist[$lineIndex];
    preg_match('/group-title="([^"]+)"/', $channelLine, $groupTitleMatches);
    preg_match('/tvg-logo="([^"]+)"/', $channelLine, $logoUrlMatches);
    preg_match('/, (.+)\n/', $channelLine, $channelNameMatches);
    $groupTitle = $groupTitleMatches[1] ?? '';
    $logoUrl = $logoUrlMatches[1] ?? '';
    $channelName = $channelNameMatches[1] ?? '';
    $channelUrl = $playlist[$lineIndex + 1] ?? '';
} else {
    die("Channel not found.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle form submission for editing
    $newGroupTitle = htmlspecialchars($_POST['group_title']);
    $newLogoUrl = htmlspecialchars($_POST['logo_url']);
    $newChannelName = htmlspecialchars($_POST['channel_name']);
    $newChannelUrl = htmlspecialchars($_POST['channel_url']);

    // Update the channel line
    $playlist[$lineIndex] = "#EXTINF:-1 tvg-logo=\"$newLogoUrl\" group-title=\"$newGroupTitle\", $newChannelName\n$newChannelUrl\n";

    // Save the updated playlist back to the file
    file_put_contents("playlist.m3u", implode("\n", $playlist));

    // Redirect back to the main page
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Channel</title>
  <style>
    body {
      background-color: #121212;
      color: #e0e0e0;
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 90%;
      max-width: 800px;
      margin: 20px auto;
      background-color: #1e1e1e;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.7);
    }
    h1 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 2.5rem;
      color: #f1c40f;
    }
    .input-group {
      margin-bottom: 20px;
    }
    .input-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 8px;
      font-size: 1.1rem;
    }
    .input-group input {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 6px;
      background-color: #333;
      color: #fff;
      font-size: 1rem;
    }
    .btn {
      padding: 12px 18px;
      background-color: #0078d7;
      color: #fff;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.3s ease;
    }
    .btn:hover {
      background-color: #005bb5;
    }
    footer {
      text-align: center;
      padding: 15px;
      background-color: #1e1e1e;
      color: #fff;
      margin-top: 30px;
    }
    footer a {
      color: #f1c40f;
      text-decoration: none;
    }
    footer a:hover {
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      .container {
        padding: 20px;
      }
      h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Edit Channel</h1>
    
    <form method="POST">
      <div class="input-group">
        <label for="group_title">Group Title</label>
        <input type="text" id="group_title" name="group_title" value="<?= htmlspecialchars($groupTitle) ?>" required>
      </div>
      <div class="input-group">
        <label for="logo_url">Channel Logo URL</label>
        <input type="url" id="logo_url" name="logo_url" value="<?= htmlspecialchars($logoUrl) ?>" required>
      </div>
      <div class="input-group">
        <label for="channel_name">Channel Name</label>
        <input type="text" id="channel_name" name="channel_name" value="<?= htmlspecialchars($channelName) ?>" required>
      </div>
      <div class="input-group">
        <label for="channel_url">Channel URL</label>
        <input type="url" id="channel_url" name="channel_url" value="<?= htmlspecialchars($channelUrl) ?>" required>
      </div>
      <button type="submit" class="btn">Save Changes</button>
    </form>
  </div>

  <footer>
    <p>Created by <a href="https://t.me/professor906" target="_blank">Professor</a></p>
    <p>&copy; 2024 All rights reserved.</p>
  </footer>
</body>
</html>
