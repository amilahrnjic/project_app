<?php

require_once __DIR__ . '/BaseDao.class.php';

class AppointmentDao extends BaseDao {
    public function __construct() {
        parent::__construct('appointments');
    }
    public function add_appointment($appointment){
        /* 
        $query = "INSERT INTO users (name, surname, created_at, email)
                  VALUES(:name, :surname, :created_at, :email)";
        $statement = $this->connection->prepare($query);
        $statement->execute($user);
        $user['id'] = $this->connection->lastInsertId();
        return $user;
        */
        return $this->insert('appointments', $appointment);
    }

    public function count_appointments_paginated($search) {
        $query = "SELECT COUNT(*) AS count
                  FROM appointments
                  WHERE LOWER(pet_id) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(doctor_id) LIKE CONCAT('%', :search, '%') OR
                        LOWER(date) LIKE CONCAT('%', :search, '%');";
        return $this->query_unique($query, [
            'search' => $search
        ]);
    }

    public function get_appointments_paginated($offset, $limit, $search, $order_column, $order_direction) {
        $query = "SELECT *
                  FROM appointments
                  WHERE LOWER(pet_id) LIKE CONCAT('%', :search, '%') OR 
                        LOWER(doctor_id) LIKE CONCAT('%', :search, '%') OR
                        LOWER(date) LIKE CONCAT('%', :search, '%')
                  ORDER BY {$order_column} {$order_direction}
                  LIMIT {$offset}, {$limit}";
        return $this->query($query, [
            'search' => $search
        ]);
    }

    public function delete_appointment_by_id($id) {
        $query = "DELETE FROM appointments WHERE id = :id";
        $this->execute($query, [
            'id' => $id
        ]);
    }

    public function get_appointment_by_id($appointment_id){
        return $this->query_unique(
            "SELECT * FROM appointments WHERE id = :id", 
            [
                'id' => $appointment_id
            ]
        );
    }

    public function edit_appointment($id, $appointment) {
        $query = "UPDATE appointments SET doctor_id = :doctor_id, pet_id = :pet_id, date = :date
                  WHERE id = :id";
        $this->execute($query, [
            'pet_id' => $appointment['pet_id'],
            'doctor_id' => $appointment['doctor_id'],
            'date' => $appointment['date'],
            'id' => $id
        ]);
    }

      //swagger
      public function get_all_appointments(){
        $query = "SELECT *
                  FROM appointments;";
            return $this->query($query,[]);

    }
}