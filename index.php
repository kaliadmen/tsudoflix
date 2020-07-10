<?php
    require_once("includes/header.php");


    $preview = new PreviewProvider($db, $user_logged_in);
    $containers = new CategoryContainer($db, $user_logged_in);
?>

    <?=$preview->create_preview_video(null)?>
    <?=$containers->show_all_categories()?>

<?php require_once("includes/footer.php"); ?>


