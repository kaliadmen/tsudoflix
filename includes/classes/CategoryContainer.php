<?php
    class CategoryContainer {

    private PDO $_connection;
    private string $_username;

    public function __construct($connection, $username) {
        $this->_connection = $connection;
        $this->_username = $username;
    }

    private function _get_category_html(array $sql_data, string $title, bool $tv_shows, bool $movies) : string {
        $cat_id = $sql_data["id"];
        $title = empty($title) ? $sql_data["name"] : $title;


        if($tv_shows && $movies) {
            $entites = EntityProvider::get_entities($this->_connection, $cat_id, 20);
        }
        else if($tv_shows) {
            $entites = EntityProvider::get_tv_show_entities($this->_connection, $cat_id, 20);
        }
        else {
            $entites = EntityProvider::get_movies_entities($this->_connection, $cat_id, 20);
        }

        if(empty($entites)) {
            return "";
        }

        $entities_html = "";
        $previewProvider = new PreviewProvider($this->_connection, $this->_username);

        foreach($entites as $entity) {
            $entities_html .= $previewProvider->create_entity_preview_container($entity);
        }

        return "<div class='category'>
                    <a href='category.php?id=$cat_id'>
                        <h3>$title</h3>
                    </a>
                    <div class='entities'>
                        $entities_html
                    </div>
                </div>";

    }

    public function show_all_categories() : string {
        $query = $this->_connection->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->_get_category_html($row, "", true, true);

        }

        return $html."</div>";
    }

    public function show_tv_shows_categories() : string {
        $query = $this->_connection->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='previewCategories'>
                    <h1>TV Shows</h1>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->_get_category_html($row, "", true, false);

        }

        return $html."</div>";
    }

        public function show_movies_categories() : string {
            $query = $this->_connection->prepare("SELECT * FROM categories");
            $query->execute();

            $html = "<div class='previewCategories'>
                    <h1>Movies</h1>";

            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $html .= $this->_get_category_html($row, "", false, true);

            }

            return $html."</div>";
        }

    public function show_category(int $cat_id, string $title = "") : string {
            $query = $this->_connection->prepare("SELECT * FROM categories WHERE id = :id");
            $query->bindValue(":id", $cat_id);
            $query->execute();

            $html = "<div class='previewCategories noScroll'>";

            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $html .= $this->_get_category_html($row, $title, true, true);

            }

            return $html."</div>";
    }
}