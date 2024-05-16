<?php

require_once __DIR__ . '/../services/VetService.class.php';

Flight::set('vet_service', new VetService()); //jendom postaivmo i mozemo dalje koristiti u ostlaim rutama

Flight::group ('/vets', function () {


    /**
 * @OA\Get(
 *   path="/vets/all",
 *   tags = {"vets"},
 *   summary="Get all vets", 
 *   @OA\Response(
 *     response=200,
 *     description="Array of the all vets in the database"
 *   )
 * 
 * )
 */

Flight::route('GET /all', function () {
  
   
    $data = Flight::get('vet_service')->get_all_vets();
    Flight::json ($data,200);
});



/**
 * @OA\Get(
 *   path="/vets/vet",
 *   tags = {"vets"},
 *   summary="Get vet by id", 
 *   @OA\Response(
 *     response=200,
 *     description="Vet data or false if vet does not exist"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="query", name="vet_id", example="1", description="Vet ID")

 * 
 * )
 */

 Flight::route('GET /vet',function(){

    $params = Flight::request()->query;

    $vet = Flight::get('vet_service')->get_vet_by_id($params['vet_id']);
    Flight::json($vet);
});


/**
 * @OA\Get(
 *   path="/vets/get/{vet_id}",
 *   tags = {"vets"},
 *   summary="Get vet by id", 
 *   @OA\Response(
 *     response=200,
 *     description="Vet data or false if vet does not exist"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="path", name="vet_id", example="1", description="Vet ID")

 * 
 * )
 */

 Flight::route('GET /get/@vet_id',function($vet_id){

    $vet = Flight::get('vet_service')->get_vet_by_id($vet_id);
    Flight::json($vet);
});



Flight::route('GET /vets', function () {
    // Retrieve query parameters from the request
    $payload = Flight::request()->query;  //to get all the query parameters that are send from our frontend

    // Cast some parameters to integers if needed
    $params = [
        'start' => (int) $payload['start'],
        'search' => $payload['search']['value'],
        'draw' => $payload['draw'],
        'limit' => (int) $payload['length'],
        'order_column' => $payload['order'][0]['name'],
        'order_direction' => $payload['order'][0]['dir'],
    ];

        // Retrieve data using the user service
        $data = Flight::get('vet_service')->get_vets_paginated(
            $params['start'],
            $params['limit'],
            $params['search'],
            $params['order_column'],
            $params['order_direction']
        );
    
        // Modify the data to include action buttons
        foreach ($data['data'] as $id => $vet) {
            $data['data'][$id]['action'] = '<div class="d-flex gap-2">
                                                <button class="btn" onclick="VetService.open_edit_vet_modal(' . $vet['id'] . ')"><i class="fa fa-pencil"></i></button>
                                                <button class="btn" onclick="VetService.delete_vet(' . $vet['id'] . ')"><i class="fa fa-trash"></i></button>
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
 *   path="/vets/add",
 *   tags = {"vets"},
 *   summary="Add vet data to the database", 
 *   @OA\Response(
 *     response=200,
 *     description="Vet data or exception if vet is not addedd properly."
 *   ),
 *    @OA\RequestBody(
     *          description="Vet data payload",
     *          @OA\JsonContent(
     *              required={"name","surname","email"},
     *              @OA\Property(property="id", type="string", example="1", description="Vet ID"),
     *              @OA\Property(property="name", type="string", example="Some first name", description="Vet first name"),
     *              @OA\Property(property="surname", type="string", example="Some surname", description="Vet surname"),
     *              @OA\Property(property="email", type="string", example="example@example.com", description="Vet email address"),
     *              @OA\Property(property="address", type="string", example="Some address", description="Vet address"),
     *              
     *              @OA\Property(property="username", type="string", example="some_username", description="Vet username"),
     *              @OA\Property(property="password", type="string", example="some_secret_password", description="Vet password"),
     *              @OA\Property(property="approved", type="string", example="true/false", description="Vet approved"),
     *              @OA\Property(property="station_id", type="string", example="1", description="Station ID")
     *          )
 * )

 * 
 * )
 */

    
Flight:: route('POST /add', function(){

    
    //$payload = $_REQUEST;
    
    $payload = Flight::request()->data->getData(); // to get json data 
    
    if($payload['name'] == NULL || $payload['name'] == '') {
       // header('HTTP/1.1 500 Bad Request');
        //die(json_encode(['error' => "First name field is missing"]));
        Flight::halt(500, "First name field is missing"); //this method is used for exception
    }
    
    //in set function we set global variable
    //$user_service = new UserService();
    
    if($payload['id'] != NULL && $payload['id'] != ''){
        $vet = Flight::get('vet_service')->edit_vet($payload);
    } else {
        unset($payload['id']);
        $vet= Flight::get('vet_service')->add_vet($payload);
    }
    
    //echo json_encode(['message' => "You have successfully added the user", 'data' => $user]);
    Flight::json (['message' => "You have successfully added the vet", 'data' => $vet]);
    });
    
    //users/delete/15 - this is route parameter
    //user_id = 15


/**
 * @OA\Delete(
 *   path="/vets/delete/{vet_id}",
 *   tags = {"vets"},
 *   summary="Delete vet by id", 
 *   @OA\Response(
 *     response=200,
 *     description="Deleted vet data or 500 status code exception otherwise"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="path", name="vet_id", example="1", description="Vet ID")

 * 
 * )
 */


    Flight::route ('DELETE /delete/@vet_id',function($vet_id){
    
        if($vet_id == NULL || $vet_id == '') {
            FLight::halt(500,"You have to provide valid vet id!");
        }
        
       
        Flight::get('vet_service')->delete_vet_by_id($vet_id);
        Flight::json(['message' => 'You have successfully deleted the vet!'],200);
        
        
    
    });
    
    //route parameters and query parameters
    //query parameters ?length=1 (where..)
    
    Flight::route('GET /vets/@vet_id', function($vet_id) {  //promiejniti rutu 
        $vet = Flight::get('vet_service')->get_vet_by_id($vet_id);
    
        Flight::json($vet, 200);
    });
    
});