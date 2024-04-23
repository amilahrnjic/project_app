<?php

require_once __DIR__ . '/../dao/PetDao.class.php';

class PetService {
    private $pet_dao;
    public function __construct() {
        $this->pet_dao = new PetDao();
    }
    public function add_pet($pet){
        return $this->pet_dao->add_pet($pet);
    }
    public function get_pets_paginated($offset, $limit, $search, $order_column, $order_direction){
        $count = $this->pet_dao->count_pets_paginated($search)['count'];
        $rows = $this->pet_dao->get_pets_paginated($offset, $limit, $search, $order_column, $order_direction);

        return [
            'count' => $count,
            'data' => $rows
        ];
    }
    public function delete_pet_by_id($pet_id) {
        $this->pet_dao->delete_pet_by_id($pet_id);
    }

    public function get_pet_by_id($pet_id) {
        return $this->pet_dao->get_pet_by_id($pet_id);
    }

    public function edit_pet($pet) {
        $id = $pet['id'];
        unset($pet['id']);

        $this->pet_dao->edit_pet($id, $pet);
    }
}