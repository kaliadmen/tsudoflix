<?php
    require_once("includes/classes/FormSanitizer.php");

    if(isset($_POST["submit"])) {
        $first_name = FormSanitizer::sanitize_string($_POST["first_name"]);
        $last_name = FormSanitizer::sanitize_string($_POST["last_name"]);
        $username = FormSanitizer::sanitize_username($_POST["username"]);
        $email = FormSanitizer::sanitize_email($_POST["email"]);
        $confirm_email = FormSanitizer::sanitize_email($_POST["confirm_email"]);
        $password = FormSanitizer::sanitize_password($_POST["password"]);
        $confirm_password = FormSanitizer::sanitize_password($_POST["confirm_password"]);
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
                    <input type="text" name="first_name" placeholder="First name" required>
                    <input type="text" name="last_name" placeholder="Last name" required>
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="email" name="confirm_email" placeholder="Confirm email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm password" required>
                    <input type="submit" name="submit" value="SUBMIT">
                </form>
                <a href="login.php" class="signInMessage">Already have an account? Sign in here!</a>
            </div>
        </div>
    </body>
</html>