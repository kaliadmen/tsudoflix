<?php
    require_once("includes/header.php");

    if(!isset($_GET["id"])){
        ErrorMessage::show_error("No Id Passed In");
    }

    $id = $_GET["id"];

    $video = new Video($db, $id);
    $video->increment_view_count();
?>