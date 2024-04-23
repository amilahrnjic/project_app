<?php
require_once __DIR__ . '/rest/services/VetService.class.php';

$vet_id = $_REQUEST['id'];

$vet_service = new VetService();
$vet = $vet_service->get_vet_by_id($vet_id);

header('Content-Type: application/json');
echo json_encode($vet);