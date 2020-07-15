<?php
require_once("../includes/config.php");

if(isset($_POST["videoId"]) && isset($_POST["username"]) && isset($_POST["progress"])) {
    $video_id = $_POST["videoId"];
    $username = $_POST["username"];
    $progress = $_POST["progress"];

    $query = $db->prepare("UPDATE video_progress SET progress = :progress,
                          date_modified = NOW(), finished = 0 WHERE username = :username AND video_id = :videoId");
    $query->bindValue(":username", $username);
    $query->bindValue(":videoId", $video_id);
    $query->bindValue(":progress", $progress);

    $query->execute();
}
else {
    ErrorMessage::show_error("No video id or username used");
}
?>