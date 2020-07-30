<?php
    require_once("includes/header.php");
    require_once("includes/paypal_config.php");
    require_once("includes/classes/Account.php");
    require_once("includes/classes/Constants.php");
    require_once("includes/classes/FormSanitizer.php");

    $user = new User($db, $user_logged_in);

    $user_first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : $user->get_first_name();
    $user_last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : $user->get_last_name();
    $user_email = isset($_POST["email"]) ? $_POST["email"] : $user->get_email();

    $details_message = "";
    $password_message = "";

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

    if(isset($_POST["save_password"])) {
        $account = new Account($db);

        $current_password = FormSanitizer::sanitize_password($_POST["current_password"]);
        $new_password = FormSanitizer::sanitize_password($_POST["new_password"]);
        $confirm_password = FormSanitizer::sanitize_password($_POST["confirm_password"]);

        if($account->update_password($current_password, $new_password, $confirm_password, $user_logged_in)) {
            $password_message = "<div class='alertSuccess'>Password updated successfully!</div>";
        }
        else {
            $password_error_message = $account->get_first_error();

            $password_message = "<div class='alertError'>$password_error_message</div>";
        }

    }

    if (isset($_GET['success']) && $_GET['success'] == 'true') {
        $token = $_GET['token'];
        $agreement = new \PayPal\Api\Agreement();

        try {
            // Execute agreement
            $agreement->execute($token, $apiContext);

            // Update user's account data

        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    } else if (isset($_GET['success']) && $_GET['success'] == 'false') {
        // Give error message
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

            <div class="message">
                <?=$password_message?>
            </div>

            <input type="submit" name="save_password" value="Save">
        </form>
    </div>

    <div class="formSection">
            <h2>Subscription</h2>
            <?php
                if($user->get_is_subscribed()) {
                    echo "<h3>You are subscribed! Go to PayPal to cancel.</h3>";
                }
                else {
                    echo "<a href='billing.php'>Subscribe to Tsudoflix</a>";
                }
            ?>
    </div>
</div>

<?php require_once("includes/footer.php"); ?>