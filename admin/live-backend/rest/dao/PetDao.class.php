<?php

require_once __DIR__ . '/BaseDao.class.php';

class PetDao extends BaseDao {
    public function __construct() {
        parent::__construct('pets');
    }
    public function add_pet($pet){
        /* 
        $query = "INSERT INTO users (name, surname, created_at, email)
                  VALUES(:name, :surname, :created_at, :email)";
        $statement = $this->connection->prepare($query);
        $statement->execute($user);
        $user['id'] = $this->connection->lastInsertId();
        return $user;
        */
        return $this->insert('pets', $pet);
    }

    public function count_pets_paginated($search) {
        $query = "SELECT COUNT(*) AS count
                  FROM pets
                  WHERE LOWER(name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(species) LIKE CONCAT('%', :search, '%') OR
                        LOWER(breed) LIKE CONCAT('%', :search, '%');";
        return $this->query_unique($query, [
            'search' => $search
        ]);
    }

    public function get_pets_paginated($offset, $limit, $search, $order_column, $order_direction) {
        $query = "SELECT *
                  FROM pets
                  WHERE LOWER(name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(species) LIKE CONCAT('%', :search, '%') OR
                        LOWER(breed) LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit}";
        return $this->query($query, [
            'search' => $search
        ]);
    }

    public function delete_pet_by_id($id) {
        $query = "DELETE FROM pets WHERE id = :id";
        $this->execute($query, [
            'id' => $id
        ]);
    }

    public function get_pet_by_id($pet_id){
        return $this->query_unique(
            "SELECT * FROM pets WHERE id = :id", 
            [
                'id' => $pet_id
            ]
        );
    }

    public function edit_pet($id, $pet) {
        $query = "UPDATE pets SET user_id = :user_id, name = :name, species = :species, breed = :breed, age = :age, disease = :disease
                  WHERE id = :id";
        $this->execute($query, [
            'user_id' => $pet['user_id'],
            'name' => $pet['name'],
            'species' => $pet['species'],
            'breed' => $pet['breed'],
            'age' => $pet['age'],
            'disease' => $pet['disease'],
            'id' => $id
        ]);
    }

      //swagger
      public function get_all_pets(){
        $query = "SELECT *
                  FROM pets;";
            return $this->query($query,[]);

    }
}