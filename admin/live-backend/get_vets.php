<?php
require_once __DIR__ . '/rest/services/VetService.class.php';

$payload = $_REQUEST;

$params = [
    'start' => (int)$payload['start'],
    'search' => $payload['search']['value'],
    'draw' => $payload['draw'],
    'limit' => (int)$payload['length'],
    'order_column' => $payload['order'][0]['name'],
    'order_direction' => $payload['order'][0]['dir'],
];

$vet_service = new VetService();

$data = $vet_service->get_vets_paginated($params['start'], $params['limit'], $params['search'], $params['order_column'], $params['order_direction']);

foreach($data['data'] as $id => $vet) {
    $data['data'][$id]['action'] = '<div class="d-flex gap-2">
                                        <button class="btn" onclick="VetService.open_edit_vet_modal('. $vet['id'] .')"><i class="fa fa-pencil"></i></button>
                                        <button class="btn" onclick="VetService.delete_vet('. $vet['id'] .')"><i class="fa fa-trash"></i></button>
                                    </div>';
}

// Response
echo json_encode([
    'draw' => $params['draw'],
    'data' => $data['data'],
    'recordsFiltered' => $data['count'],
    'recordsTotal' => $data['count'],
    'end' => $data['count']
]);