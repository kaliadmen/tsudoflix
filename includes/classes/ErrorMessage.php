<?php
    class ErrorMessage {

        public static function show_error(string $msg) : string {
            exit("<span class='errorBanner'>$msg</span>");
        }
    }