<?php

require_once __DIR__ . '/../dao/VetDao.class.php';

class VetService {
    private $vet_dao;
    public function __construct() {
        $this->vet_dao = new VetDao();
    }
    public function add_vet($vet){
        return $this->vet_dao->add_vet($vet);
    }
    public function get_vets_paginated($offset, $limit, $search, $order_column, $order_direction){
        $count = $this->vet_dao->count_vets_paginated($search)['count'];
        $rows = $this->vet_dao->get_vets_paginated($offset, $limit, $search, $order_column, $order_direction);

        return [
            'count' => $count,
            'data' => $rows
        ];
    }
    public function delete_vet_by_id($vet_id) {
        $this->vet_dao->delete_vet_by_id($vet_id);
    }

    public function get_vet_by_id($vet_id) {
        return $this->vet_dao->get_vet_by_id($vet_id);
    }

    public function edit_vet($vet) {
        $id = $vet['id'];
        unset($vet['id']);

        $this->vet_dao->edit_vet($id, $vet);
    }
}