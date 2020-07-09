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
            //get tv shows
        }
        else {
            //get movies
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
    
    
}