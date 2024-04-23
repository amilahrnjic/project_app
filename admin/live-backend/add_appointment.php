<?php
require_once __DIR__ . '/rest/services/AppointmentService.class.php';

$payload = $_REQUEST;

if($payload['date'] == NULL || $payload['date'] == '') {
    header('HTTP/1.1 500 Bad Request');
    die(json_encode(['error' => "Date field is missing"]));
}

$appointment_service = new AppointmentService();

if(isset($payload['id']) && $payload['id'] != NULL && $payload['id'] != ''){
    $appointment = $appointment_service->edit_appointment($payload);
} else {
    unset($payload['id']);
    $appointment = $appointment_service->add_appointment($payload);
}

echo json_encode(['message' => "You have successfully added the appointment", 'data' => $appointment]);