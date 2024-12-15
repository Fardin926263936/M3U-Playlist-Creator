<?php
$file = "playlist.m3u";

// Ask user for a custom filename
if (isset($_POST['filename']) && !empty($_POST['filename'])) {
    $filename = $_POST['filename'] . ".m3u";
} else {
    $filename = "playlist.m3u";
}

if (file_exists($file)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit();
} else {
    echo "Playlist file not found!";
}
?>
