<?php
require_once("../includes/config.php");
include_once("../includes/classes/EntityProvider.php");
include_once("../includes/classes/PreviewProvider.php");
include_once("../includes/classes/Entity.php");
include_once("../includes/classes/SearchResultsProvider.php");
require_once("../includes/classes/ErrorMessage.php");

if(isset($_POST["search"]) && isset($_POST["username"])) {
    $username = $_POST["username"];
    $search = $_POST["search"];

    $search_provider = new SearchResultsProvider($db, $username);

    echo $search_provider->get_results($search);

}
else {
    ErrorMessage::show_error("Nothing matched your search");
}
?>