
<?php

//this route will be GET request
    //Insted of previuosly forntent in Service -> .js 
    //URL + petes

    //we are trying to remove this files (get delete itd..) and replace them with the actual endpoints that we will have



// Include the petService class
require_once __DIR__ . '/../services/PetService.class.php';

// Set up the pet service
Flight::set('pet_service', new PetService());

Flight::group ('/pets', function () {

/**
 * @OA\Get(
 *   path="/pets/all",
 *   tags = {"pets"},
 *   summary="Get all pets", 
 *  security={
     *          {"ApiKey": {}}   
     *      },
 *   @OA\Response(
 *     response=200,
 *     description="Array of the all pets in the database"
 *   )
 * 
 * )
 */

 Flight::route('GET /all', function () {
  
   
    $data = Flight::get('pet_service')->get_all_pets();
    Flight::json ($data,200);
});



/**
 * @OA\Get(
 *   path="/pets/pet",
 *   tags = {"pets"},
 *   summary="Get pet by id", 
 *  security={
     *          {"ApiKey": {}}   
     *      },
 *   @OA\Response(
 *     response=200,
 *     description="Pet data or false if pet does not exist"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="query", name="pet_id", example="1", description="Pet ID")

 * 
 * )
 */

 Flight::route('GET /pet',function(){

    $params = Flight::request()->query;

    $pet = Flight::get('pet_service')->get_pet_by_id($params['pet_id']);
    Flight::json($pet);
});


/**
 * @OA\Get(
 *   path="/pets/get/{pet_id}",
 *   tags = {"pets"},
 *   summary="Get pet by id",
 *  security={
     *          {"ApiKey": {}}   
     *      }, 
 *   @OA\Response(
 *     response=200,
 *     description="Pet data or false if pet does not exist"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="path", name="pet_id", example="1", description="Pet ID")

 * 
 * )
 */

 Flight::route('GET /get/@pet_id',function($pet_id){

    $pet= Flight::get('pet_service')->get_pet_by_id($pet_id);
    Flight::json($pet);
});





// Define a route for GET requests to /pets
Flight::route('GET /pets', function () {
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

    // Retrieve data using the pet service
    $data = Flight::get('pet_service')->get_pets_paginated(
        $params['start'],
        $params['limit'],
        $params['search'],
        $params['order_column'],
        $params['order_direction']
    );

    // Modify the data to include action buttons
    foreach ($data['data'] as $id => $pet) {
        $data['data'][$id]['action'] = '<div class="d-flex gap-2">
                                            <button class="btn" onclick="PetService.open_edit_pet_modal(' . $pet['id'] . ')"><i class="fa fa-pencil"></i></button>
                                            <button class="btn" onclick="PetService.delete_pet(' . $pet['id'] . ')"><i class="fa fa-trash"></i></button>
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
 *   path="/pets/add",
 *   tags = {"pets"},
 *   summary="Add pet data to the database", 
 *  security={
     *          {"ApiKey": {}}   
     *      },
 *   @OA\Response(
 *     response=200,
 *     description="Pet data or exception if pet is not addedd properly."
 *   ),
 *    @OA\RequestBody(
     *          description="Pet data payload",
     *          @OA\JsonContent(
     *              required={"name","species","breed"},
     *              @OA\Property(property="id", type="string", example="1", description="Pet ID"),
     *              @OA\Property(property="user_id", type="string", example="1", description="User ID"),
     *              @OA\Property(property="name", type="string", example="Some pet name", description="Pet name"),
     *              @OA\Property(property="species", type="string", example="Some species", description="Pet species"),
     *              @OA\Property(property="breed", type="string", example="Some breed", description="Pet breed"),
     *              @OA\Property(property="age", type="string", example="Some age", description="Pet age"),
     *              @OA\Property(property="disease", type="string", example="Some disease", description="Pet disease")
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
//$pet_service = new petService();

if($payload['id'] != NULL && $payload['id'] != ''){
    $pet = Flight::get('pet_service')->edit_pet($payload);
} else {
    unset($payload['id']);
    $pet = Flight::get('pet_service')->add_pet($payload);
}

//echo json_encode(['message' => "You have successfully added the pet", 'data' => $pet]);
Flight::json (['message' => "You have successfully added the pet", 'data' => $pet]);
});

//pets/delete/15 - this is route parameter
//pet_id = 15


/**
 * @OA\Delete(
 *   path="/pets/delete/{pet_id}",
 *   tags = {"pets"},
 *   summary="Delete pet by id", 
 *  security={
     *          {"ApiKey": {}}   
     *      },
 *   @OA\Response(
 *     response=200,
 *     description="Deleted pet data or 500 status code exception otherwise"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="path", name="pet_id", example="1", description="Pet ID")

 * 
 * )
 */


Flight::route ('DELETE /delete/@pet_id',function($pet_id){

    if($pet_id == NULL || $pet_id == '') {
        FLight::halt(500,"You have to provide valid pet id!");
    }
    
   
    Flight::get('pet_service')->delete_pet_by_id($pet_id);
    Flight::json(['message' => 'You have successfully deleted the pet!'],200);
    
    

});

//route parameters and query parameters
//query parameters ?length=1 (where..)

Flight::route('GET /pets/@pet_id', function($pet_id) {  //promiejniti rutu 
    $pet = Flight::get('pet_service')->get_pet_by_id($pet_id);

    Flight::json($pet, 200);
});
});