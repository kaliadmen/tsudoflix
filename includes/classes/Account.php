<?php
    class Account {

        private PDO $_connection;
        private array $_error_array = [];

        public function __construct(PDO $connection) {
            $this->_connection = $connection;
        }

        public function login($username, $password) : bool {
            $query = $this->_connection->prepare("SELECT * FROM users WHERE username = ?");
            $query->execute([$username]);

            if ($query->rowCount() == 1) {
                $results = $query->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $results['password'])) {
                    return true;
                }
            }
            array_push($this->_error_array, Constants::$login_failed);
            return false;
        }

        public function register(string $first_name, string $last_name, string $username, string $email, string $confirmed_email, string $password, string $confirmed_password) : bool {
            $this->_validate_firstname($first_name);
            $this->_validate_lastname($last_name);
            $this->_validate_username($username);
            $this->_validate_emails($email, $confirmed_email);
            $this->_validate_passwords($password, $confirmed_password);

            if(empty($this->_error_array))
                return $this->_insert_user_data($first_name, $last_name, $username, $email, $password);

            return false;
        }

        public function update_details(string $first_name, string $last_name, string $email, string $username) : bool {
            $this->_validate_firstname($first_name);
            $this->_validate_lastname($last_name);
            $this->_validate_new_email($email, $username);

            if(empty($this->_error_array)) {
                $query = $this->_connection->prepare("UPDATE users 
                    SET first_name = :fname, last_name = :lname, email = :eaddress 
                    WHERE username = :uname");

                $query->bindValue(":fname", $first_name);
                $query->bindValue(":lname", $last_name);
                $query->bindValue(":eaddress", $email);
                $query->bindValue(":uname", $username);

                return $query->execute();
            }

            return false;

        }

        public function update_password(string $current_password, string $new_password, string $confirm_password, string $username) : bool {
            $this->_validate_current_password($current_password, $username);
            $this->_validate_passwords($new_password, $confirm_password);

            if(empty($this->_error_array)) {
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT, array(
                    'cost' => '12'));

                $query = $this->_connection->prepare("UPDATE users SET password = :pw WHERE username = :uname");

                $query->bindValue(":pw", $hashed_password);
                $query->bindValue(":uname", $username);

                return $query->execute();
            }

            return false;
        }

        public function get_error(string $error) : string{
            if(!in_array($error, $this->_error_array)){
                $error = "";
            }

            return "<span class='errorMessage'>$error</span>";
        }

        public function get_first_error() : string {
            if(!empty($this->_error_array)) {
                return $this->_error_array[0];
            }
        }

        private function _validate_username(string $username) : void {
            if(strlen($username) > 25 || strlen($username) < 5){
                array_push($this->_error_array, Constants::$username_not_correct_length);
                return;
            }

            $query = $this->_connection->prepare("SELECT * FROM users WHERE username= :uname");
            $query->bindValue(":uname", $username);
            $query->execute();
            if($query->rowCount() != 0) {
                array_push($this->_error_array, Constants::$username_taken);
                return;
            }
        }

        private function _validate_firstname(string $first_name) : void {
            if(strlen($first_name) > 25 || strlen($first_name) < 2){
                array_push($this->_error_array, Constants::$first_name_not_correct_length);
                return;
            }
        }

        private function _validate_lastname(string $last_name) : void {
            if(strlen($last_name) > 25 || strlen($last_name) < 2){
                array_push($this->_error_array, Constants::$last_name_not_correct_length);
                return;
            }
        }

        private function _validate_emails(string $email_1,  string $email_2) : void {
            if($email_1 !== $email_2){
                array_push($this->_error_array, Constants::$email_does_not_match);
                return;
            }

            if(!filter_var($email_1, FILTER_VALIDATE_EMAIL)){
                array_push($this->_error_array, Constants::$email_not_valid);
                return;
            }

            $query = $this->_connection->prepare("SELECT * FROM users WHERE email= :eaddress");
            $query->bindValue(":eaddress", $email_1);
            $query->execute();

            if($query->rowCount() != 0){
                array_push($this->_error_array, Constants::$email_used);
                return;
            }


        }

        private function _validate_new_email(string $email,  string $username) : void {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($this->_error_array, Constants::$email_not_valid);
                return;
            }

            $query = $this->_connection->prepare("SELECT * FROM users WHERE email= :eaddress AND username != :uname");
            $query->bindValue(":eaddress", $email);
            $query->bindValue(":uname", $username);
            $query->execute();

            if($query->rowCount() != 0){
                array_push($this->_error_array, Constants::$email_used);
                return;
            }


        }

        private function _validate_passwords(string $password_1,  string $password_2) : void {
            if($password_1 !== $password_2){
                array_push($this->_error_array, Constants::$passwords_do_not_match);
                return;
            }

            if(strlen($password_1) > 30|| strlen($password_1) < 8){
                array_push($this->_error_array, Constants::$password_not_correct_length);
                return;
            }

            if(preg_match('/[^A-Za-z0-9]/', $password_1)){
                array_push($this->_error_array, Constants::$password_has_invalid_characters);
                return;
            }
        }

        private function _validate_current_password(string $current_password, string $username) : void {
            $query = $this->_connection->prepare("SELECT * FROM users WHERE username = ?");
            $query->execute([$username]);

            if ($query->rowCount() == 1) {
                $results = $query->fetch(PDO::FETCH_ASSOC);
                if (!password_verify($current_password, $results['password'])) {
                    array_push($this->_error_array, Constants::$password_incorrect);
                }
            }
        }

        private function _insert_user_data($first_name, $last_name, $username, $email, $password) : bool {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT, array(
                'cost' => '12'));

            $query = $this->_connection->prepare(
                "INSERT INTO users (username, password, email, last_name, first_name)
                          VALUES (:fname, :lname, :uname, :eaddress, :pw)");

            $query->bindValue(":uname", $username);
            $query->bindValue(":pw", $hashed_password);
            $query->bindValue(":eaddress", $email);
            $query->bindValue(":lname", $last_name);
            $query->bindValue(":fname", $first_name);




            return $query->execute();
        }
    }