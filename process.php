<?php
// Enable error reporting for debugging (you can disable it later)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted via POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve and sanitize form data
    $groupTitle = isset($_POST['group_title']) ? htmlspecialchars($_POST['group_title']) : '';
    $logoURL = isset($_POST['logo_url']) ? htmlspecialchars($_POST['logo_url']) : '';
    $channelName = isset($_POST['channel_name']) ? htmlspecialchars($_POST['channel_name']) : '';
    $channelURL = isset($_POST['channel_url']) ? htmlspecialchars($_POST['channel_url']) : '';

    // Check if all required fields are filled
    if (!empty($groupTitle) && !empty($logoURL) && !empty($channelName) && !empty($channelURL)) {
        // Construct the M3U line to add to the playlist
        $playlistLine = "#EXTINF:-1 tvg-logo=\"$logoURL\" group-title=\"$groupTitle\", $channelName\n$channelURL\n";

        // Append the new line to the playlist.m3u file
        $file = "playlist.m3u";
        file_put_contents($file, $playlistLine, FILE_APPEND);

        // Redirect to index.php after adding the channel
        header("Location: index.php");
        exit();
    } else {
        // Error handling if any of the required fields are missing
        echo "All fields are required. Please go back and fill in the missing fields.";
    }
} else {
    // If the form was not submitted via POST, display an error
    echo "Invalid request.";
}
?>
