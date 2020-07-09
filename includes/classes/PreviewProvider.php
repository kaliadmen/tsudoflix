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

        public function create_entity_preview_container($entity) {
            $id = $entity->get_id();
            $name = $entity->get_name();
            $thumbnail =$entity->get_thumbnail();

            return "<a href='entity.php?id=$id'>
                    <div class='previewContainer small'>
                        <img src=\"$thumbnail\" alt='\"show image\" 'title='$name'>
                    </div>
                    </a>";
        }

        private function _get_random_entity() : Entity {
            $entity = EntityProvider::get_entities($this->_connection, (int) NULL,1);

            return $entity[0];
        }
    }