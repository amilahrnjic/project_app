<?php

require_once __DIR__ . '/BaseDao.class.php';

class UserDao extends BaseDao {
    public function __construct() {
        parent::__construct('users');
    }
    public function add_user($user){
        /* 
        $query = "INSERT INTO users (name, surname, created_at, email)
                  VALUES(:name, :surname, :created_at, :email)";
        $statement = $this->connection->prepare($query);
        $statement->execute($user);
        $user['id'] = $this->connection->lastInsertId();
        return $user;
        */
        return $this->insert('users', $user);
    }

    public function count_users_paginated($search) {
        $query = "SELECT COUNT(*) AS count
                  FROM users
                  WHERE LOWER(name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(surname) LIKE CONCAT('%', :search, '%') OR
                        LOWER(email) LIKE CONCAT('%', :search, '%');";
        return $this->query_unique($query, [
            'search' => $search
        ]);
    }

    public function get_users_paginated($offset, $limit, $search, $order_column, $order_direction) {
        $query = "SELECT *
                  FROM users
                  WHERE LOWER(name) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(surname) LIKE CONCAT('%', :search, '%') OR
                        LOWER(email) LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit}";
        return $this->query($query, [
            'search' => $search
        ]);
    }

    public function delete_user_by_id($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $this->execute($query, [
            'id' => $id
        ]);
    }

    public function get_user_by_id($user_id){
        return $this->query_unique(
            "SELECT * FROM users WHERE id = :id", 
            [
                'id' => $user_id
            ]
        );
    }

    public function edit_user($id, $user) {
        $query = "UPDATE users SET name = :name, surname = :surname, email = :email, phone = :phone, username = :username, password = :password
                  WHERE id = :id";
        $this->execute($query, [
            'name' => $user['name'],
            'surname' => $user['surname'],
            'email' => $user['email'],
            'phone' => $user['phone'],
            'username' => $user['username'],
            'password' => $user['password'],
            'id' => $id
        ]);
    }

     //swagger
    public function get_all_users(){
        $query = "SELECT *
                  FROM users;";
            return $this->query($query,[]);

    }

   
}
