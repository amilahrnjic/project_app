
<?php

//this route will be GET request
    //Insted of previuosly forntent in Service -> .js 
    //URL + stationes

    //we are trying to remove this files (get delete itd..) and replace them with the actual endpoints that we will have



// Include the stationService class
require_once __DIR__ . '/../services/StationService.class.php';

// Set up the station service
Flight::set('station_service', new StationService());

Flight::group ('/stations', function () {


/**
 * @OA\Get(
 *   path="/stations/all",
 *   tags = {"stations"},
 *   summary="Get all stations", 
 *  security={
     *          {"ApiKey": {}}   
     *      },
 *   @OA\Response(
 *     response=200,
 *     description="Array of the all stations in the database"
 *   )
 * 
 * )
 */

Flight::route('GET /all', function () {
  
   
    $data = Flight::get('station_service')->get_all_stations();
    Flight::json ($data,200);
});


/**
 * @OA\Get(
 *   path="/stations/station",
 *   tags = {"stations"},
 *   summary="Get station by id", 
 *  security={
     *          {"ApiKey": {}}   
     *      },
 *   @OA\Response(
 *     response=200,
 *     description="Station data or false if station does not exist"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="query", name="station_id", example="1", description="Station ID")

 * 
 * )
 */

 Flight::route('GET /station',function(){

    $params = Flight::request()->query;

    $station = Flight::get('station_service')->get_station_by_id($params['station_id']);
    Flight::json($station);
});

/**
 * @OA\Get(
 *   path="/stations/get/{station_id}",
 *   tags = {"stations"},
 *   summary="Get station by id", 
 *  security={
     *          {"ApiKey": {}}   
     *      },
 *   @OA\Response(
 *     response=200,
 *     description="Station data or false if station does not exist"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="path", name="station_id", example="1", description="Station ID")

 * 
 * )
 */

 Flight::route('GET /get/@station_id',function($station_id){

    $station = Flight::get('station_service')->get_station_by_id($station_id);
    Flight::json($station);
});


// Define a route for GET requests to /stations
Flight::route('GET /stations', function () {
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

    // Retrieve data using the station service
    $data = Flight::get('station_service')->get_stations_paginated(
        $params['start'],
        $params['limit'],
        $params['search'],
        $params['order_column'],
        $params['order_direction']
    );

    // Modify the data to include action buttons
    foreach ($data['data'] as $id => $station) {
        $data['data'][$id]['action'] = '<div class="d-flex gap-2">
                                            <button class="btn" onclick="StationService.open_edit_station_modal(' . $station['id'] . ')"><i class="fa fa-pencil"></i></button>
                                            <button class="btn" onclick="StationService.delete_station(' . $station['id'] . ')"><i class="fa fa-trash"></i></button>
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
 *   path="/stations/add",
 *   tags = {"stations"},
 *   summary="Add station data to the database", 
 *  security={
     *          {"ApiKey": {}}   
     *      },
 *   @OA\Response(
 *     response=200,
 *     description="Station data or exception if station is not addedd properly."
 *   ),
 *    @OA\RequestBody(
     *          description="Station data payload",
     *          @OA\JsonContent(
     *              required={"name","address","phone"},
     *              @OA\Property(property="id", type="string", example="1", description="Station ID"),
     *              @OA\Property(property="name", type="string", example="Some station name", description="Station name"),
     *              @OA\Property(property="address", type="string", example="Some address", description="Station address"),
     *              @OA\Property(property="phone", type="string", example="Some station phone", description="Station phone"),
     *            
     *              @OA\Property(property="description", type="string", example="Some description", description="Station description")
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
//$station_service = new stationService();

if($payload['id'] != NULL && $payload['id'] != ''){
    $station = Flight::get('station_service')->edit_station($payload);
} else {
    unset($payload['id']);
    $station = Flight::get('station_service')->add_station($payload);
}

//echo json_encode(['message' => "You have successfully added the station", 'data' => $station]);
Flight::json (['message' => "You have successfully added the station", 'data' => $station]);
});

//stations/delete/15 - this is route parameter
//station_id = 15

/**
 * @OA\Delete(
 *   path="/stations/delete/{station_id}",
 *   tags = {"stations"},
 *   summary="Delete station by id", 
 *  security={
     *          {"ApiKey": {}}   
     *      },
 *   @OA\Response(
 *     response=200,
 *     description="Deleted station data or 500 status code exception otherwise"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="path", name="station_id", example="1", description="Station ID")

 * 
 * )
 */
Flight::route ('DELETE /delete/@station_id',function($station_id){

    if($station_id == NULL || $station_id == '') {
        FLight::halt(500,"You have to provide valid station id!");
    }
    
   
    Flight::get('station_service')->delete_station_by_id($station_id);
    Flight::json(['message' => 'You have successfully deleted the station!'],200);
    
    

});

//route parameters and query parameters
//query parameters ?length=1 (where..)

Flight::route('GET /stations/@station_id', function($station_id) {  //promiejniti rutu 
    $station = Flight::get('station_service')->get_station_by_id($station_id);

    Flight::json($station, 200);
});
});