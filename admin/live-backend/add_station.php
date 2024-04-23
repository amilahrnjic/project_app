<?php
require_once __DIR__ . '/rest/services/StationService.class.php';

$payload = $_REQUEST;

if($payload['name'] == NULL || $payload['name'] == '') {
    header('HTTP/1.1 500 Bad Request');
    die(json_encode(['error' => "name field is missing"]));
}

$station_service = new StationService();

if($payload['id'] != NULL && $payload['id'] != ''){
    $station = $station_service->edit_station($payload);
} else {
    unset($payload['id']);
    $station = $station_service->add_station($payload);
}

echo json_encode(['message' => "You have successfully added the user", 'data' => $station]);