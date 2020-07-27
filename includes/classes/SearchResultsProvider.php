<?php
    class SearchResultsProvider {

        private PDO $_connection;
        private string $_username;

        public function __construct($connection, $username) {
            $this->_connection = $connection;
            $this->_username = $username;
        }

        private function get_results_html($entities) : string {
            if(empty($entities)) {
                return "";
            }

            $entities_html = "";
            $previewProvider = new PreviewProvider($this->_connection, $this->_username);

            foreach($entities as $entity) {
                $entities_html .= $previewProvider->create_entity_preview_container($entity);
            }

            return "<div class='category'>
                    <div class='entities'>
                        $entities_html
                    </div>
                </div>";
        }

        public function get_results(string $search_text) : string {
            $entities = EntityProvider::get_search_entities($this->_connection,$search_text);

            $html = "<div class='previewCategories noScroll'>";
            $html .= $this->get_results_html($entities);

            return $html."</div>";
        }
    }