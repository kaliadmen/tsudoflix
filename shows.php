<?php
require_once("includes/header.php");


$preview = new PreviewProvider($db, $user_logged_in);
$containers = new CategoryContainer($db, $user_logged_in);
?>

<?=$preview->create_tv_show_preview_video()?>
<?=$containers->show_tv_shows_categories()?>

<?php require_once("includes/footer.php"); ?>


