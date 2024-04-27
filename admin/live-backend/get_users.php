<?php
require_once __DIR__ . '/rest/services/UserService.class.php';

$payload = $_REQUEST;

$params = [
    'start' => (int)$payload['start'],
    'search' => $payload['search']['value'],
    'draw' => $payload['draw'],
    'limit' => (int)$payload['length'],
    'order_column' => $payload['order'][0]['name'],
    'order_direction' => $payload['order'][0]['dir'],
];

$user_service = new UserService();

$data = $user_service->get_users_paginated($params['start'], $params['limit'], $params['search'], $params['order_column'], $params['order_direction']);

foreach($data['data'] as $id => $user) {
    $data['data'][$id]['action'] = '<div class="d-flex gap-2">
                                        <button class="btn" onclick="UserService.open_edit_user_modal('. $user['id'] .')"><i class="fa fa-pencil"></i></button>
                                        <button class="btn" onclick="UserService.delete_user('. $user['id'] .')"><i class="fa fa-trash"></i></button>
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