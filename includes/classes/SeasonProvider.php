<?php
    class SeasonProvider {

        private PDO $_connection;
        private string $_username;

        public function __construct($connection, $username) {
            $this->_connection = $connection;
            $this->_username = $username;
        }

        private function _create_video_container(Video $video) : string {
            $id = $video->get_id();
            $thumbnail = $video->get_thumbnail();
            $description = $video->get_description();
            $episode_number = $video->get_episode_number();
            $title = $video->get_title();
            $has_seen = $video->have_seen($this->_username) ? "<i class='fas fa-check-circle seen'></i>" : "";

            return "<a href='watch.php?id=$id'>
                        <div class='episodeContainer'>
                            <div class='contents'>
                                <img src='$thumbnail' alt='episode image'>
                                <div class='videoInfo'>
                                    <h4>$episode_number. $title</h4>
                                    <span>$description</span>
                                </div>
                                $has_seen
                            </div>
                        </div>
                    </a>";
        }

        public function create(Entity $entity) : string {
            $seasons = $entity->get_seasons();

            if(empty($seasons)) {
                return "";
            }

            $season_html = "";

            foreach($seasons as $season) {
                $season_number = $season->get_season_number();

                $videos_html = "";
                foreach($season->get_videos() as $video) {
                    $videos_html .= $this->_create_video_container($video);
                }

                $season_html .= "<div class='season'>
                                    <h3>Season $season_number</h3>
                                    <div class='videos'>
                                        $videos_html
                                    </div>
                                </div>";
            }

            return $season_html;
        }

    }