<?php
    require_once("includes/header.php");

    if(!isset($_GET["id"])){
        ErrorMessage::show_error("No Id Passed In");
    }

    $id = $_GET["id"];

    $video = new Video($db, $id);
    $video->increment_view_count();

    $up_next_video = VideoProvider::get_up_next_video($db, $video);
?>

<div class="watchContainer">
    <div class="videoControls watchNav">
        <button onclick="goBack()">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h1><?=$video->get_title()?></h1>
    </div>

    <div class="videoControls upNext">
        <button><i class="fas fa-redo"></i></button>

        <div class="upNextContainer">
            <h2>Up next: </h2>
            <h3><?=$up_next_video->get_title() ?></h3>
        </div>
    </div>

    <video controls  autoplay controlsList="nodownload" disablePictureInPicture>
        <source src="<?=$video->get_file_path()?>" type="video/mp4">
    </video>
</div>

<script>
    initVideo("<?=$video->get_id();?>", "<?=sha1($user_logged_in);?>");
</script>
<?php require_once("includes/footer.php"); ?>