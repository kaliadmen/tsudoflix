<?php
    require_once("includes/header.php");
    require_once("includes/classes/Account.php");
    require_once("includes/classes/Constants.php");
    require_once("includes/classes/FormSanitizer.php");

    $user = new User($db, $user_logged_in);

    $user_first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : $user->get_first_name();
    $user_last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : $user->get_last_name();
    $user_email = isset($_POST["email"]) ? $_POST["email"] : $user->get_email();

    $details_message = "";

    if(isset($_POST["save_details"])) {
        $account = new Account($db);

        $first_name = FormSanitizer::sanitize_string($_POST["first_name"]);
        $last_name = FormSanitizer::sanitize_string($_POST["last_name"]);
        $email = FormSanitizer::sanitize_email($_POST["email"]);

        if($account->update_details($first_name, $last_name, $email, $user_logged_in)) {
            $details_message = "<div class='alertSuccess'>Details updated successfully!</div>";
        }
        else {
            $error_message = $account->get_first_error();

            $details_message = "<div class='alertError'>$error_message</div>";
        }

    }
?>

<div class="settingsContainer column">
    <div class="formSection">
        <form method="POST">
            <h2>User details</h2>
            <input type="text" name="first_name" placeholder="First name" value="<?=$user_first_name?>">
            <input type="text" name="last_name" placeholder="Last name" value="<?=$user_last_name?>">
            <input type="email" name="email" placeholder="Email" value="<?=$user_email?>">

            <div class="message">
                <?=$details_message?>
            </div>
            <input type="submit" name="save_details" value="Save">
        </form>
    </div>

    <div class="formSection">
        <form method="POST">
            <h2>Update password</h2>
            <input type="password" name="current_password" placeholder="Current password">
            <input type="password" name="new_password" placeholder="New password">
            <input type="password" name="confirm_password" placeholder="Confirm new password">

            <input type="submit" name="save_password" value="Save">
        </form>
    </div>
</div>

<?php require_once("includes/footer.php"); ?>