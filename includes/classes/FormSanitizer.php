<?php
    class FormSanitizer {

        public static function sanitize_string(string $string, bool $trim = true) : string {
            //remove html tags
            $string = strip_tags($string);

            $trim ?
                //remove all white space
                $string = str_replace(" ", "", $string) :
                //remove white space at start and end of string
                $string = trim($string);

            //lowercase string
            $string = strtolower($string);
            //capitalize first character
            $string = ucwords($string);

            return $string;
        }

        public static function sanitize_username(string $username) : string {
            //remove html tags
            $username = strip_tags($username);

            //remove all white space
            $username = str_replace(" ", "", $username);

            return $username;
        }

        public static function sanitize_password(string $password) : string {
            $password = strip_tags($password);

            return $password;
        }

        public static function sanitize_email(string $email) : string {
            //remove html tags
            $email = strip_tags($email);

            //remove all white space
            $email = str_replace(" ", "", $email);

            return $email;
        }
    }