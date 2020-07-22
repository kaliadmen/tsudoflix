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

        public static function get_entity_video_for_user(PDO $connection, int $entity_id, string $username)  {
            $query = $connection->prepare(
                "SELECT video_id FROM video_progress 
                        INNER JOIN videos 
                        ON video_progress.video_id = videos.id 
                        WHERE videos.entity_id = :entityId 
                        AND video_progress.username = :username 
                        ORDER BY video_progress.date_modified DESC 
                        LIMIT 1");

            $query->bindValue(":entityId", $entity_id);
            $query->bindValue(":username", $username);
            $query->execute();

            if(empty($query->rowCount())) {
                $query = $connection->
                prepare("SELECT id FROM videos WHERE entity_id = :entityId ORDER BY season, episode LIMIT 1");
                $query->bindValue(":entityId", $entity_id);
                $query->execute();
            }

            return $query->fetchColumn();
        }
    }