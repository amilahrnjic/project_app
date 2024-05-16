<?php

require_once __DIR__ . '/../dao/AppointmentDao.class.php';

class AppointmentService {
    private $appointment_dao;
    public function __construct() {
        $this->appointment_dao = new AppointmentDao();
    }
    public function add_appointment($appointment){
        return $this->appointment_dao->add_appointment($appointment);
    }
    public function get_appointments_paginated($offset, $limit, $search, $order_column, $order_direction){
        $count = $this->appointment_dao->count_appointments_paginated($search)['count'];
        $rows = $this->appointment_dao->get_appointments_paginated($offset, $limit, $search, $order_column, $order_direction);

        return [
            'count' => $count,
            'data' => $rows
        ];
    }
    public function delete_appointment_by_id($appointment_id) {
        $this->appointment_dao->delete_appointment_by_id($appointment_id);
    }

    public function get_appointment_by_id($appointment_id) {
        return $this->appointment_dao->get_appointment_by_id($appointment_id);
    }

    public function edit_appointment($appointment) {
        $id = $appointment['id'];
        unset($appointment['id']);

        $this->appointment_dao->edit_appointment($id, $appointment);
    }
    //swagger
    public function get_all_appointments(){
        return $this->appointment_dao->get_all_appointments();
     }
}