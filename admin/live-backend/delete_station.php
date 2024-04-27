<?php

require_once __DIR__ . '/rest/services/StationService.class.php';

$station_id = $_REQUEST['id'];
if($station_id == NULL || $station_id == '') {
    header('HTTP/1.1 500 Bad Request');
    die(json_encode(['error' => "You have to provide valid station id!"]));
}

$station_service = new StationService();
$station_service->delete_station_by_id($station_id);
echo json_encode(['message' => 'You have successfully deleted the station!']);

