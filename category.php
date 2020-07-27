<?php
require_once("includes/header.php");

if(!isset($_GET["id"])) {
    ErrorMessage::show_error("No id given");
}

$cat_id = $_GET["id"];

$preview = new PreviewProvider($db, $user_logged_in);
$containers = new CategoryContainer($db, $user_logged_in);
?>

<?=$preview->create_category_preview_video($cat_id)?>
<?=$containers->show_category($cat_id)?>

<?php require_once("includes/footer.php"); ?>


