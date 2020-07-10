<?php
    class Season {

        private int $_season_number;
        private array $_videos;

        public function __construct(int $season_number, array $videos) {
            $this->_season_number = $season_number;
            $this->_videos = $videos;
        }


        public function get_season_number(): int {
            return $this->_season_number;
        }


        public function get_videos(): array {
            return $this->_videos;
        }
    }