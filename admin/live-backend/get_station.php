<?php
require_once __DIR__ . '/rest/services/StationService.class.php';

$station_id = $_REQUEST['id'];

$station_service = new StationService();
$station = $station_service->get_station_by_id($station_id);

header('Content-Type: application/json');
echo json_encode($station);