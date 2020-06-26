<?php
    ob_start();
    session_start();

    date_default_timezone_set("America/New_York");

    $db['db_driver'] = 'mysql';
    $db['db_host'] = 'localhost';
    $db['db_user'] = 'root' ;
    $db['db_password'] = '1qaz@WSX3edc$RFV';
    $db['db_name'] = 'tsudoflix';


    foreach($db as $key => $value){
        define(strtoupper($key), $value);
    }

    try {
        $db = new PDO(DB_DRIVER.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }catch(PDOException $e) {
        exit("Connection Failed: ".$e->getMessage());
    }

?>