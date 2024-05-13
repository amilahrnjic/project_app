
<?php

//this route will be GET request
    //Insted of previuosly forntent in Service -> .js 
    //URL + appointmentes

    //we are trying to remove this files (get delete itd..) and replace them with the actual endpoints that we will have



// Include the appointmentService class
require_once __DIR__ . '/../services/AppointmentService.class.php';

// Set up the appointment service
Flight::set('appointment_service', new AppointmentService());

//group
Flight::group ('/appointments', function () {

//get all appointmentss - swagger:
// tags to group our routes
/**
 * @OA\Get(
 *   path="/appointments/all",
 *   tags = {"appointments"},
 *   summary="Get all appointments", 
 *   @OA\Response(
 *     response=200,
 *     description="Array of the all appointments in the database"
 *   )
 * 
 * )
 */

 
Flight::route('GET /all', function () {
  
   
    $data = Flight::get('appointment_service')->get_all_appointments();
    Flight::json ($data,200);
});


/**
 * @OA\Get(
 *   path="/appointments/appointment",
 *   tags = {"appointments"},
 *   summary="Get appointment by id", 
 *   @OA\Response(
 *     response=200,
 *     description="Appointment data or false if appointment does not exist"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="query", name="appointment_id", example="1", description="Appointment ID")

 * 
 * )
 */

 Flight::route('GET /appointment',function(){

    $params = Flight::request()->query;

    $user = Flight::get('appointment_service')->get_appointment_by_id($params['appointment_id']);
    Flight::json($user);
});

/**
 * @OA\Get(
 *   path="/appointments/get/{appointment_id}",
 *   tags = {"appointments"},
 *   summary="Get appointment by id", 
 *   @OA\Response(
 *     response=200,
 *     description="Appointment data or false if appointment does not exist"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="path", name="appointment_id", example="1", description="Appointment ID")

 * 
 * )
 */

 Flight::route('GET /get/@user_id',function($user_id){

    $user = Flight::get('user_service')->get_user_by_id($user_id);
    Flight::json($user);
});


// Define a route for GET requests to /appointments
Flight::route('GET /appointments', function () {
    // Retrieve query parameters from the request
    $payload = Flight::request()->query;

    // Cast some parameters to integers if needed
    $params = [
        'start' => (int) $payload['start'],
        'search' => $payload['search']['value'],
        'draw' => $payload['draw'],
        'limit' => (int) $payload['length'],
        'order_column' => $payload['order'][0]['name'],
        'order_direction' => $payload['order'][0]['dir'],
    ];

    // Retrieve data using the appointment service
    $data = Flight::get('appointment_service')->get_appointments_paginated(
        $params['start'],
        $params['limit'],
        $params['search'],
        $params['order_column'],
        $params['order_direction']
    );

    // Modify the data to include action buttons
    foreach ($data['data'] as $id => $appointment) {
        $data['data'][$id]['action'] = '<div class="d-flex gap-2">
                                            <button class="btn" onclick="AppointmentService.open_edit_appointment_modal(' . $appointment['id'] . ')"><i class="fa fa-pencil"></i></button>
                                            <button class="btn" onclick="AppointmentService.delete_appointment(' . $appointment['id'] . ')"><i class="fa fa-trash"></i></button>
                                        </div>';
    }

    // Respond with JSON
    Flight::json([
        'draw' => $params['draw'],
        'data' => $data['data'],
        'recordsFiltered' => $data['count'],
        'recordsTotal' => $data['count'],
        'end' => $data['count']
    ], 200);
});



/**
 * @OA\Post(
 *   path="/appointments/add",
 *   tags = {"appointments"},
 *   summary="Add appointment data to the database", 
 *   @OA\Response(
 *     response=200,
 *     description="Appointment data or exception if appointment is not addedd properly."
 *   ),
 *    @OA\RequestBody(
     *          description="Patient data payload",
     *          @OA\JsonContent(
     *              required={"pet_id","doctor_id","date"},
     *              @OA\Property(property="id", type="string", example="1", description="Appointment ID"),
     *              @OA\Property(property="pet_id", type="string", example="1", description="Pet id"),
     *              @OA\Property(property="doctor_id", type="string", example="1", description="Doctor id"),
     *              @OA\Property(property="date", type="string", example="2024-20-17", description="Appointment date")
     *             
     *          )
 * )

 * 
 * )
 */


/* POST /appointments/add */

Flight:: route('POST /add', function(){

    
    //$payload = $_REQUEST;

    $payload = Flight::request()->data->getData(); // to get json data 

    // if($payload['name'] == NULL || $payload['name'] == '') {
    // // header('HTTP/1.1 500 Bad Request');
    //     //die(json_encode(['error' => "First name field is missing"]));
    //     Flight::halt(500, "First name field is missing"); //this method is used for exception
    // }

    //in set function we set global variable
    //$appointment_service = new appointmentService();

    if($payload['id'] != NULL && $payload['id'] != ''){
        $appointment = Flight::get('appointment_service')->edit_appointment($payload);
    } else {
        unset($payload['id']);
        $appointment = Flight::get('appointment_service')->add_appointment($payload);
    }

    //echo json_encode(['message' => "You have successfully added the appointment", 'data' => $appointment]);
    Flight::json (['message' => "You have successfully added the appointment", 'data' => $appointment]);
});

//appointments/delete/15 - this is route parameter
//appointment_id = 15

/**
 * @OA\Delete(
 *   path="/appointments/delete/{appointment_id}",
 *   tags = {"appointments"},
 *   summary="Delete user by id", 
 *   @OA\Response(
 *     response=200,
 *     description="Deleted appointment data or 500 status code exception otherwise"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="path", name="appointment_id", example="1", description="Appointment ID")

 * 
 * )
 */


Flight::route ('DELETE /delete/@appointment_id',function($appointment_id){

    if($appointment_id == NULL || $appointment_id == '') {
        FLight::halt(500,"You have to provide valid appointment id!");
    }
    
   
    Flight::get('appointment_service')->delete_appointment_by_id($appointment_id);
    Flight::json(['message' => 'You have successfully deleted the appointment!'],200);
    
    

});

//route parameters and query parameters
//query parameters ?length=1 (where..)

Flight::route('GET /appointments/@appointment_id', function($appointment_id) {  //promiejniti rutu 
    $appointment = Flight::get('appointment_service')->get_appointment_by_id($appointment_id);

    Flight::json($appointment, 200);
});

});