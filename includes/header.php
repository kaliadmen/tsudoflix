<?php
    require_once("includes/config.php");
    require_once("includes/classes/User.php");
    require_once("includes/classes/PreviewProvider.php");
    require_once("includes/classes/EntityProvider.php");
    require_once("includes/classes/SeasonProvider.php");
    require_once("includes/classes/VideoProvider.php");
    require_once("includes/classes/CategoryContainer.php");
    require_once("includes/classes/Entity.php");
    require_once("includes/classes/Video.php");
    require_once("includes/classes/Season.php");
    require_once("includes/classes/ErrorMessage.php");

    if(!isset($_SESSION["user_logged_in"])) {
        header("Location: register.php");
    }

    $user_logged_in = $_SESSION["user_logged_in"];
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
        <title>Welcome to Tsudoflix</title>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"
                integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
                crossorigin="anonymous"></script>
        <script src="assets/js/script.js"></script>
    </head>
    <body>
        <div class="wrapper">
            <?php
                if(!isset($hide_nav)) {
                    include_once("includes/navbar.php");
                }
            ?>

