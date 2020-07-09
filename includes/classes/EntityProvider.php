<?php
    class EntityProvider {

        public static function get_entities(PDO $connection, int $cat_id, int $limit) : array {
            $sql = "SELECT * FROM entities ";

            if(!empty($cat_id)) {
                $sql.= "WHERE category_id = :cat_id ";
            }

            $sql .= "ORDER BY RAND() LIMIT :limit";

            $query = $connection->prepare($sql);

            if(!empty($cat_id)) {
                $query->bindValue(":cat_id", $cat_id);
            }

            $query->bindValue(":limit", $limit, PDO::PARAM_INT);

            $query->execute();

            $result = [];

            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $result[] = new Entity($connection, $row);
            }

            return $result;
        }
    }