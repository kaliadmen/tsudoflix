<?php
    require_once("includes/header.php");

    $preview = new PreviewProvider($db, $user_logged_in);
?>

    <?=$preview->create_preview_video(null)?>


        </div>
    </body>
</html>