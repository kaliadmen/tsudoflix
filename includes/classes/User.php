<?php
    class User {

        private PDO $_connection;
        private array $sql_data;

        public function __construct(PDO $connection, string $username) {
            $this->_connection = $connection;

            $query = $this->_connection->prepare("SELECT * FROM users WHERE username = :username");
            $query->bindValue(":username", $username);
            $query->execute();

            $this->sql_data = $query->fetch(PDO::FETCH_ASSOC);
        }

        public function get_first_name() : string {
           return $this->sql_data["first_name"];
        }

        public function get_last_name() : string {
            return $this->sql_data["last_name"];
        }

        public function get_username() : string {
            return $this->sql_data["username"];
        }

        public function get_email() : string {
            return $this->sql_data["email"];
        }
    }

?>