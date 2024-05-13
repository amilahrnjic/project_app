<?php

require_once __DIR__ . '/BaseDao.class.php';

class StationDao extends BaseDao {
    public function __construct() {
        parent::__construct('stations');
    }
    public function add_station($station){
        /* 
        $query = "INSERT INTO users (name, surname, created_at, email)
                  VALUES(:name, :surname, :created_at, :email)";
        $statement = $this->connection->prepare($query);
        $statement->execute($user);
        $user['id'] = $this->connection->lastInsertId();
        return $user;
        */
        return $this->insert('stations', $station);
    }

    public function count_stations_paginated($search) {
        $query = "SELECT COUNT(*) AS count
                  FROM stations
                  WHERE LOWER(name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(address) LIKE CONCAT('%', :search, '%');"; // ovdje ne znam koji da stavim ima address umjesto email
        return $this->query_unique($query, [
            'search' => $search
        ]);
    }

    public function get_stations_paginated($offset, $limit, $search, $order_column, $order_direction) {
        $query = "SELECT *
                  FROM stations
                  WHERE LOWER(name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(address) LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit}";
        return $this->query($query, [
            'search' => $search
        ]);
    }

    public function delete_station_by_id($id) {
        $query = "DELETE FROM stations WHERE id = :id";
        $this->execute($query, [
            'id' => $id
        ]);
    }

    public function get_station_by_id($station_id){
        return $this->query_unique(
            "SELECT * FROM stations WHERE id = :id", 
            [
                'id' => $station_id
            ]
        );
    }

    public function edit_station($id, $station) {
        $query = "UPDATE stations SET name = :name, address = :address, phone = :phone, description = :description
                  WHERE id = :id";
        $this->execute($query, [
            'name' => $station['name'],
            'address' => $station['address'],
            'phone' => $station['phone'],
            'description' => $station['description'],
            'id' => $id
        ]);
    }

      //swagger
      public function get_all_stations(){
        $query = "SELECT *
                  FROM stations;";
            return $this->query($query,[]);

    }
}