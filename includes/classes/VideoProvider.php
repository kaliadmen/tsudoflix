<?php
    class VideoProvider {
        public static function get_up_next_video(PDO $connection, Video $current_video) : Video {
            $query = $connection->prepare("SELECT * FROM videos WHERE entity_id = :entityId
                       AND id != :videoId
                       AND ((season = :season AND episode > :episode) 
                           OR season > :season)
                       ORDER BY season, episode ASC LIMIT 1");

            $query->bindValue(":entityId", $current_video->get_entity_id());
            $query->bindValue(":season", $current_video->get_season_number());
            $query->bindValue(":episode", $current_video->get_episode_number());
            $query->bindValue(":videoId", $current_video->get_id());

            $query->execute();

            if($query->rowCount() == 0) {
                $query = $connection->prepare("SELECT * FROM videos WHERE season <= 1 AND episode <= 1 
                            AND id != :videoID ORDER BY views DESC LIMIT 1");

                $query->bindValue(":videoId", $current_video->get_id());

                $query->execute();
            }

            $row = $query->fetchColumn();
            
            return new Video($connection, $row);
        }
    }