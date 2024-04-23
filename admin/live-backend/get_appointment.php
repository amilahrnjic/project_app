<?php
require_once __DIR__ . '/rest/services/AppointmentService.class.php';

$appointment_id = $_REQUEST['id'];

$appointment_service = new AppointmentService();
$appointment = $appointment_service->get_appointment_by_id($appointment_id);

header('Content-Type: application/json');
echo json_encode($appointment);