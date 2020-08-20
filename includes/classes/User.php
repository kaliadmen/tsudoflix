<?php
    class User {

        private PDO $_connection;
        private array $_sql_data;

        public function __construct(PDO $connection, string $username) {
            $this->_connection = $connection;

            $query = $this->_connection->prepare("SELECT * FROM users WHERE username = :username");
            $query->bindValue(":username", $username);
            $query->execute();

            $this->_sql_data = $query->fetch(PDO::FETCH_ASSOC);
        }

        public function set_is_subscribed(int $value) : bool {
            $query = $this->_connection->prepare("UPDATE users SET is_subscribed = :isSubscribed 
                WHERE username = :uname");

            $query->bindValue(":isSubscribed", $value);
            $query->bindValue(":uname", $this->get_username());

            if($query->execute()) {
                $this->_sql_data["is_subscribed"] = $value;
                return true;
            }

            return false;
        }

        public function get_first_name() : string {
           return $this->_sql_data["first_name"];
        }

        public function get_last_name() : string {
            return $this->_sql_data["last_name"];
        }

        public function get_username() : string {
            return $this->_sql_data["username"];
        }

        public function get_is_subscribed() : bool {
            return $this->_sql_data["is_subscribed"];
        }

        public function get_email() : string {
            return $this->_sql_data["email"];
        }
    }

?>