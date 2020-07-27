<?php
    include_once("includes/header.php");
?>


<div class="textboxContainer">
    <input class="searchInput" type="text" placeholder="Search for something">
</div>

<div class="results">
    <script>
        $(function() {
            let username = "<?=$user_logged_in?>";
            let timer;

            $(".searchInput").keyup(function() {
                clearTimeout(timer);

                timer = setTimeout(function() {
                    let search = $(".searchInput").val();

                    if(search !== "") {
                        $.post("ajax/get_search_results.php", {search, username}, function(data) {
                            $(".results").html(data);
                        })
                    }
                    else {
                        $(".results").html("");
                    }
                }, 400)
            })
        })
    </script>
</div>