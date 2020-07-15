<?php
    require_once("../includes/config.php");

    if(isset($_POST["videoId"]) && isset($_POST["username"])) {
        $video_id = $_POST["videoId"];
        $username = $_POST["username"];

        $query = $db->prepare("SELECT * FROM video_progress WHERE username = :username AND video_id = :videoId");
        $query->bindValue(":username", $username);
        $query->bindValue(":videoId", $video_id);

        $query->execute();

        if($query->rowCount() == 0) {
            $query = $db->prepare("INSERT INTO video_progress (username, video_id) VALUES (:username, :videoId)");
            $query->bindValue(":username", $username);
            $query->bindValue(":videoId", $video_id);

            $query->execute();
        }
    }
    else {
        ErrorMessage::show_error("No video id or username used");
    }
?>