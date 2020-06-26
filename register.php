<?php
    require_once("includes/config.php");
    require_once("includes/classes/FormSanitizer.php");
    require_once("includes/classes/Constants.php");
    require_once("includes/classes/Account.php");

    $account = new Account($db);

    if(isset($_POST["submit"])) {
        $first_name = FormSanitizer::sanitize_string($_POST["first_name"]);
        $last_name = FormSanitizer::sanitize_string($_POST["last_name"]);
        $username = FormSanitizer::sanitize_username($_POST["username"]);
        $email = FormSanitizer::sanitize_email($_POST["email"]);
        $confirm_email = FormSanitizer::sanitize_email($_POST["confirm_email"]);
        $password = FormSanitizer::sanitize_password($_POST["password"]);
        $confirm_password = FormSanitizer::sanitize_password($_POST["confirm_password"]);

        $registered = $account->register($first_name, $last_name, $username, $email, $confirm_email, $password, $confirm_password);


        if($registered) {
            $_SESSION["user_logged_in"] = $username;
            header("Location: index.php"); //make redirect function
        }

    }

    function get_input_value(string $name) : string {
        if(isset($_POST[$name])) {
            return $_POST[$name];
        }
        return '';
    }

?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
        <title>Welcome to Tsudoflix</title>
    </head>
    <body>
        <div class="signInContainer">
            <div class="column">
                <div class="header">
                    <img src="assets/images/logo.png" title="Logo" alt="Site logo" />
                    <h3>Sign Up</h3>
                    <span>to continue to Tsudoflix</span>
                </div>
                <form method="POST">
                    <?=$account->get_error(Constants::$first_name_not_correct_length)?>
                    <input type="text" name="first_name" placeholder="First name" value="<?=get_input_value("first_name");?>" required>

                    <?=$account->get_error(Constants::$last_name_not_correct_length)?>
                    <input type="text" name="last_name" placeholder="Last name" value="<?=get_input_value("last_name");?>" required>

                    <?=$account->get_error(Constants::$username_not_correct_length)?>
                    <?=$account->get_error(Constants::$username_taken)?>
                    <input type="text" name="username" placeholder="Username" value="<?=get_input_value("username");?>" required>

                    <?=$account->get_error(Constants::$email_does_not_match)?>
                    <?=$account->get_error(Constants::$email_not_valid)?>
                    <?=$account->get_error(Constants::$email_used)?>
                    <input type="email" name="email" placeholder="Email" value="<?=get_input_value("email");?>" required>

                    <input type="email" name="confirm_email" placeholder="Confirm email" required>

                    <?=$account->get_error(Constants::$password_not_correct_length)?>
                    <?=$account->get_error(Constants::$password_has_invalid_characters)?>
                    <?=$account->get_error(Constants::$passwords_do_not_match)?>
                    <input type="password" name="password" placeholder="Password" required>

                    <input type="password" name="confirm_password" placeholder="Confirm password" required>

                    <input type="submit" name="submit" value="SUBMIT">
                </form>
                <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>
            </div>
        </div>
        <script>
            document.getElementsByClassName("errrorMessage")
        </script>
    </body>
</html>