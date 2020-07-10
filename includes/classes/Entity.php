<?php
class Entity {

    private PDO $_connection;
    private array $_data;
    private int $_data_id;

    public function __construct(PDO $connection, $data) {
        $this->_connection = $connection;

        is_array($data) ? $this->_data = $data : $this->_data_id = $data;

        if(isset($this->_data_id)) {
            $query = $this->_connection->prepare("SELECT * FROM entities WHERE id= :id");
            $query->bindValue(":id", $data);
            $query->execute();
            $this->_data = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function get_id() : int {
        return $this->_data["id"];
    }

    public function get_name() : string {
        return $this->_data["name"];
    }

    public function get_thumbnail() : string {
        return $this->_data["thumbnail"];
    }

    public function get_preview() : string {
        return $this->_data["preview"];
    }

    public function get_category_id() : string {
        return $this->_data["category_id"];
    }

    public function get_seasons() : array {
        $seasons = [];
        $videos = [];
        $current_season = null;

        $query = $this->_connection->
        prepare("SELECT * FROM videos WHERE entity_id = :id AND is_movie = 0 ORDER BY season, episode ASC");

        $query->bindValue(":id", $this->get_id());

        $query->execute();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            if($current_season != null && $current_season != $row["season"]) {
                $seasons[] = new Season($current_season, $videos);
                $videos = [];
            }

            $current_season = $row["season"];
            $videos[] = new Video($this->_connection, $row);

        }

        if(!empty($videos)) {
            $seasons[] = new Season($current_season, $videos);
        }

        return $seasons;
    }
}