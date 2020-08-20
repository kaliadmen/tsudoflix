<?php
    require_once("PayPal-PHP-SDK/autoload.php");

    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AfvgRcCfkEUtsEMwBuSTd3a-mwQTEFqxN0KXjJ2Lp5Of6AqAkNiPRbgsecsv9bz4pnQtLRiuGRO7vIof',
            'EGhVKaA898wogqT206_aWFHsZ7XSgstvT5QB31Sq_9BqQfp0HcHFjFtld1sA-IgdhNyCni542J_nYQT2'
        )
    );
?>