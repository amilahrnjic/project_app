<?php
require_once __DIR__ . '/rest/services/VetService.class.php';

$payload = $_REQUEST;

if($payload['name'] == NULL || $payload['name'] == '') {
    header('HTTP/1.1 500 Bad Request');
    die(json_encode(['error' => "First name field is missing"]));
}

$vet_service = new VetService();

if($payload['id'] != NULL && $payload['id'] != ''){
    $vet = $vet_service->edit_vet($payload);
} else {
    unset($payload['id']);
    $vet = $vet_service->add_vet($payload);
}

echo json_encode(['message' => "You have successfully added the vet", 'data' => $vet]);