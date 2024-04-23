<?php

require_once __DIR__ . '/../dao/StationDao.class.php';

class StationService {
    private $station_dao;
    public function __construct() {
        $this->station_dao = new StationDao();
    }
    public function add_station($station){
        return $this->station_dao->add_station($station);
    }
    public function get_stations_paginated($offset, $limit, $search, $order_column, $order_direction){
        $count = $this->station_dao->count_stations_paginated($search)['count'];
        $rows = $this->station_dao->get_stations_paginated($offset, $limit, $search, $order_column, $order_direction);

        return [
            'count' => $count,
            'data' => $rows
        ];
    }
    public function delete_station_by_id($station_id) {
        $this->station_dao->delete_station_by_id($station_id);
    }

    public function get_station_by_id($station_id) {
        return $this->station_dao->get_station_by_id($station_id);
    }

    public function edit_station($station) {
        $id = $station['id'];
        unset($station['id']);

        $this->station_dao->edit_station($id, $station);
    }
}