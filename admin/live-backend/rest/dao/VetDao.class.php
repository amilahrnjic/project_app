<?php

require_once __DIR__ . '/BaseDao.class.php';

class VetDao extends BaseDao {
    public function __construct() {
        parent::__construct('vets');
    }
    public function add_vet($vet){
        /* 
        $query = "INSERT INTO users (name, surname, created_at, email)
                  VALUES(:name, :surname, :created_at, :email)";
        $statement = $this->connection->prepare($query);
        $statement->execute($user);
        $user['id'] = $this->connection->lastInsertId();
        return $user;
        */
        return $this->insert('vets', $vet);
    }

    public function count_vets_paginated($search) {
        $query = "SELECT COUNT(*) AS count
                  FROM vets
                  WHERE LOWER(name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(surname) LIKE CONCAT('%', :search, '%') OR
                        LOWER(email) LIKE CONCAT('%', :search, '%');";
        return $this->query_unique($query, [
            'search' => $search
        ]);
    }

    public function get_vets_paginated($offset, $limit, $search, $order_column, $order_direction) {
        $query = "SELECT *
                  FROM vets
                  WHERE LOWER(name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(surname) LIKE CONCAT('%', :search, '%') OR
                        LOWER(email) LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit}";
        return $this->query($query, [
            'search' => $search
        ]);
    }

    public function delete_vet_by_id($id) {
        $query = "DELETE FROM vets WHERE id = :id";
        $this->execute($query, [
            'id' => $id
        ]);
    }

    public function get_vet_by_id($vet_id){
        return $this->query_unique(
            "SELECT * FROM vets WHERE id = :id", 
            [
                'id' => $vet_id
            ]
        );
    }

    public function edit_vet($id, $vet) {
        $query = "UPDATE vets SET name = :name, surname = :surname, email = :email, address = :address, username = :username, password = :password, approved = :approved, station_id = :station_id
                  WHERE id = :id";
        $this->execute($query, [
         //   'id' => $vet['id'],
            'name' => $vet['name'],
            'surname' => $vet['surname'],
            'email' => $vet['email'],
            'address' => $vet['address'],
            'username' => $vet['username'],
            'password' => $vet['password'],
            'approved' => $vet['approved'],
            'station_id' => $vet['station_id'],
            'id' => $id
        ]);
    }
}