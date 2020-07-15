<?php
require_once("../includes/config.php");
require_once("../includes/classes/ErrorMessage.php");

if(isset($_POST["videoId"]) && isset($_POST["username"])) {
    $video_id = $_POST["videoId"];
    $username = $_POST["username"];

    $query = $db->prepare("SELECT progress FROM video_progress WHERE username = :username AND video_id = :videoId");
    $query->bindValue(":username", $username);
    $query->bindValue(":videoId", $video_id);
    $query->execute();

    echo ($query->fetchColumn());
}
else {
    ErrorMessage::show_error("No video id or username used");
}
?>