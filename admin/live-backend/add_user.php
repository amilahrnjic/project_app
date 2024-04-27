<?php
require_once __DIR__ . '/rest/services/UserService.class.php';

$payload = $_REQUEST;

if($payload['name'] == NULL || $payload['name'] == '') {
    header('HTTP/1.1 500 Bad Request');
    die(json_encode(['error' => "First name field is missing"]));
}

$user_service = new UserService();

if($payload['id'] != NULL && $payload['id'] != ''){
    $user = $user_service->edit_user($payload);
} else {
    unset($payload['id']);
    $user = $user_service->add_user($payload);
}

echo json_encode(['message' => "You have successfully added the user", 'data' => $user]);