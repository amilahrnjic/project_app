<?php

require_once __DIR__ . '/rest/services/PetService.class.php';

$pet_id = $_REQUEST['id'];
if($pet_id == NULL || $pet_id == '') {
    header('HTTP/1.1 500 Bad Request');
    die(json_encode(['error' => "You have to provide valid pet id!"]));
}

$pet_service = new PetService();
$pet_service->delete_pet_by_id($pet_id);
echo json_encode(['message' => 'You have successfully deleted the pet!']);

