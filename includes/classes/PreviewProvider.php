<?php
    class PreviewProvider {

        private PDO $_connection;
        private string $_username;

        public function __construct($connection, $username) {
            $this->_connection = $connection;
            $this->_username = $username;
        }

        public function create_preview_video($entity) : string {
            if($entity == null) {
                $entity = $this->_get_random_entity();
            }

            $id = $entity->get_id();
            $name = $entity->get_name();
            $preview = $entity->get_preview();
            $thumbnail = $entity->get_thumbnail();

            //TODO: Add subtitle data

            return "<div class='previewContainer'>
                    <img class='previewImage' src='$thumbnail' alt='' hidden>
                    <video autoplay muted class='previewVideo' src='$preview' type='video/mp4' onended='previewEnded()'></video>
                    <div class='previewOverlay'>
                        <div class='mainDetails'>
                            <h3>$name</h3>
                
                            <div class='buttons'>
                               <button><i class='fas fa-play'></i> Play</button>
                               <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute'></i></button>
                            </div>
                        </div>
                    </div>
                    </div>";
        }

        private function _get_random_entity() : Entity {
            $query = $this->_connection->prepare("SELECT * FROM entities ORDER BY RAND() LIMIT 1");
            $query->execute();

            $data = $query->fetch(PDO::FETCH_ASSOC);

            return new Entity($this->_connection, $data);

        }
    }