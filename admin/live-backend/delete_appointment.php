<?php

require_once __DIR__ . '/rest/services/AppointmentService.class.php';

$appointment_id = $_REQUEST['id'];
if($appointment_id == NULL || $appointment_id == '') {
    header('HTTP/1.1 500 Bad Request');
    die(json_encode(['error' => "You have to provide valid appointment id!"]));
}

$appointment_service = new AppointmentService();
$appointment_service->delete_appointment_by_id($appointment_id);
echo json_encode(['message' => 'You have successfully deleted the appointment!']);

