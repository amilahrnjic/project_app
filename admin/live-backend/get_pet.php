<?php
require_once __DIR__ . '/rest/services/PetService.class.php';

$pet_id = $_REQUEST['id'];

$pet_service = new PetService();
$pet = $pet_service->get_pet_by_id($pet_id);

header('Content-Type: application/json');
echo json_encode($pet);