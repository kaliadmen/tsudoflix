<?php
    $hide_nav = true;
    require_once("includes/header.php");

    if(!isset($_GET["id"])){
        ErrorMessage::show_error("No Id Passed In");
    }

    $user = new User($db, $user_logged_in);

    if(!$user->get_is_subscribed()) {
        ErrorMessage::show_error("You must be subscribed to see this. <a href='profile.php#subscription'>Click here to subscribe</a>");
    }

    $id = $_GET["id"];

    $video = new Video($db, $id);
    $video->increment_view_count();

    $up_next_overlay = "";

    if(!$video->is_movie()) {
        $up_next_video = VideoProvider::get_up_next_video($db, $video);
        $video_id = $up_next_video->get_id();
        $video_title = $up_next_video->get_title();
        $video_season_and_episode = $up_next_video->get_season_and_episode();

        $up_next_overlay = "<div id='upNext' class='videoControls upNext' style='display: none'>
        <button onclick='restartVideo()'><i class='fas fa-redo'></i></button>

        <div class='upNextContainer'>
            <h2>Up next: </h2>
            <h3>$video_title</h3>
            <h3>$video_season_and_episode</h3>

            <button class='playNext' onclick='watchVideo($video_id)'>
                <i class='fas fa-play'></i> Play
            </button>
        </div>
    </div>";
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

    <video controls controlsList="nodownload" disablePictureInPicture>
        <source src="<?=$video->get_file_path()?>" type="video/mp4">
    </video>
</div>

<script>
    initVideo("<?=$video->get_id();?>", "<?=sha1($user_logged_in);?>");
</script>
<?php require_once("includes/footer.php"); ?>