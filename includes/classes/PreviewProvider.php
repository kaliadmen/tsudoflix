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

            $video_id = VideoProvider::get_entity_video_for_user($this->_connection, $id, sha1($this->_username));
            $video = new Video($this->_connection, $video_id);

            $in_progress = $video->is_in_progress($this->_username);
            $play_button_text = $in_progress ? "Continue Watching" : "Play";

            $season_episode = $video->get_season_and_episode();
            $subtitle = $video->is_movie() ? "" : "<h4>$season_episode</h4>";

            return "<div class='previewContainer'>
                    <img class='previewImage' src='$thumbnail' alt='' hidden>
                    <video autoplay muted class='previewVideo' src='$preview' type='video/mp4' onended='previewEnded()'></video>
                    <div class='previewOverlay'>
                        <div class='mainDetails'>
                            <h3>$name</h3>
                            $subtitle
                            <div class='buttons'>
                               <button onclick='watchVideo($video_id)'><i class='fas fa-play'></i> $play_button_text</button>
                               <button onclick='volumeToggle(this)'><i class='fas fa-volume-mute vol'></i></button>
                            </div>
                        </div>
                    </div>
                    </div>";
        }

        public function create_tv_show_preview_video() : string {
            $entities_array = EntityProvider::get_tv_show_entities($this->_connection, (int) NULL,1);

            if(sizeof($entities_array) == 0) {
                ErrorMessage::show_error("No TV shows to display");
            }

            return $this->create_preview_video($entities_array[0]);
        }

        public function create_movie_preview_video() : string {
            $entities_array = EntityProvider::get_movies_entities($this->_connection, (int) NULL,1);

            if(sizeof($entities_array) == 0) {
                ErrorMessage::show_error("No movies to display");
            }

            return $this->create_preview_video($entities_array[0]);
        }

        public function create_category_preview_video(int $category_id) : string {
            $entities_array = EntityProvider::get_entities($this->_connection, $category_id ,1);

            if(sizeof($entities_array) == 0) {
                ErrorMessage::show_error("No shows to display");
            }

            return $this->create_preview_video($entities_array[0]);
        }

        public function create_entity_preview_container($entity) : string {
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