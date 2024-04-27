<?php
require_once __DIR__ . '/rest/services/PetService.class.php';

$payload = $_REQUEST;

if($payload['name'] == NULL || $payload['name'] == '') {
    header('HTTP/1.1 500 Bad Request');
    die(json_encode(['error' => "First name field is missing"]));
}

$pet_service = new PetService();

if($payload['id'] != NULL && $payload['id'] != ''){
    $pet = $pet_service->edit_pet($payload);
} else {
    unset($payload['id']);
    $pet = $pet_service->add_pet($payload);
}

echo json_encode(['message' => "You have successfully added the pet", 'data' => $pet]);