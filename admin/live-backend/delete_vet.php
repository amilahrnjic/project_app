<?php

require_once __DIR__ . '/rest/services/VetService.class.php';

$vet_id = $_REQUEST['id'];
if($vet_id == NULL || $vet_id == '') {
    header('HTTP/1.1 500 Bad Request');
    die(json_encode(['error' => "You have to provide valid vet id!"]));
}

$vet_service = new VetService();
$vet_service->delete_vet_by_id($vet_id);
echo json_encode(['message' => 'You have successfully deleted the vet!']);

