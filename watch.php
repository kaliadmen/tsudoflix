<?php
    $hide_nav = true;
    require_once("includes/header.php");

    if(!isset($_GET["id"])){
        ErrorMessage::show_error("No Id Passed In");
    }

    $id = $_GET["id"];

    $video = new Video($db, $id);
    $video->increment_view_count();

    if(!$video->is_movie()) {
        $up_next_video = VideoProvider::get_up_next_video($db, $video);

        $up_next_overlay = '<div id="upNext" class="videoControls upNext" style="display: none">
        <button onclick="restartVideo()"><i class="fas fa-redo"></i></button>

        <div class="upNextContainer">
            <h2>Up next: </h2>
            <h3><?=$up_next_video->get_title()?></h3>
            <h3><?=$up_next_video->get_season_and_episode()?></h3>

            <button class="playNext" onclick="watchVideo(<?=$up_next_video->get_id()?>)">
                <i class="fas fa-play"></i> Play
            </button>
        </div>
    </div>';
    }
?>

<div class="watchContainer">
    <div class="videoControls watchNav">
        <button onclick="goBack()">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h1><?=$video->get_title()?></h1>
    </div>


    <?=$up_next_overlay?>

    <video controls  autoplay controlsList="nodownload" disablePictureInPicture>
        <source src="<?=$video->get_file_path()?>" type="video/mp4">
    </video>
</div>

<script>
    initVideo("<?=$video->get_id();?>", "<?=sha1($user_logged_in);?>");
</script>
<?php require_once("includes/footer.php"); ?>