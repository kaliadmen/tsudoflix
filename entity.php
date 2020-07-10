<?php
    require_once("includes/header.php");

    $preview = new PreviewProvider($db, $user_logged_in);

    if(!isset($_GET["id"])){
        ErrorMessage::show_error("No Id Passed In");
    }

    $entity_id = $_GET["id"];
    $entity = new Entity($db, $entity_id);

    $season_list = new SeasonProvider($db, $user_logged_in);
    $category_list = new CategoryContainer($db, $user_logged_in);
?>

<?=$preview->create_preview_video($entity)?>

<?=$season_list->create($entity)?>

<?=$category_list->show_category($entity->get_category_id(), "You might also like")?>


<?php require_once("includes/footer.php"); ?>