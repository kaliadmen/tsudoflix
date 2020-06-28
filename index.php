<?php
    require_once("includes/header.php");

    $preview = new PreviewProvider($db, $user_logged_in);
?>

    <?=$preview->create_preview_video(null)?>



        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
        <script src="assets/js/script.js"></script>
        <script src="https://kit.fontawesome.com/8e0c341b27.js" crossorigin="anonymous"></script>
    </body>
</html>