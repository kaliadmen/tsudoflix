<?php
    require_once("includes/header.php");

    if(!isset($_GET["id"])){
        ErrorMessage::show_error("No Id Passed In");
    }

    $id = $_GET["id"];

    $video = new Video($db, $id);
    $video->increment_view_count();
?>

<div class="watchContainer">
    <div class="videoControls watchNav">
        <button onclick="goBack()">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h1><?=$video->get_title()?></h1>
    </div>
    <video controls  autoplay src="<?=$video->get_file_path()?>" type="video/mp4" controlsList="nodownload" disablePictureInPicture>

    </video>
</div>

<script>
    initVideo("<?=$video->get_id();?>", "<?=sha1($user_logged_in);?>");
</script>
<?php require_once("includes/footer.php"); ?>