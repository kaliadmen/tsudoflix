<?php
    class Video {

        private PDO $_connection;
        private array $_data;
        private int $_data_id;
        private Entity $_entity;

        public function __construct(PDO $connection, $data) {
            $this->_connection = $connection;

            is_array($data) ? $this->_data = $data : $this->_data_id = $data;

            if(isset($this->_data_id)) {
                $query = $this->_connection->prepare("SELECT * FROM videos WHERE id= :id");
                $query->bindValue(":id", $data);
                $query->execute();
                $this->_data = $query->fetch(PDO::FETCH_ASSOC);
            }
            $this->_entity = new Entity($connection, $this->_data["entity_id"]);
        }

        public function increment_view_count() {
            $query = $this->_connection->prepare("UPDATE videos SET views = views + 1 WHERE id = :id");
            $query->bindValue(":id", $this->get_id());
            $query->execute();
        }

        public function get_id() : string {
            return $this->_data["id"];
        }

        public function get_title() : string {
            return $this->_data["title"];
        }

        public function get_description() : string {
            return $this->_data["description"];
        }

        public function get_file_path() : string {
            return $this->_data["file_path"];
        }

        public function get_thumbnail() : string {
            return $this->_entity->get_thumbnail();
        }

        public function get_episode_number() : string {
            return $this->_data["episode"];
        }

        public function get_entity_id() : string {
            return $this->_data["entity_id"];
        }

        public function get_season_number() : string  {
            return $this->_data["season"];
        }
    }