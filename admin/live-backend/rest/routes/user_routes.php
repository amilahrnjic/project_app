
<?php

//this route will be GET request
    //Insted of previuosly forntent in Service -> .js 
    //URL + useres

    //we are trying to remove this files (get delete itd..) and replace them with the actual endpoints that we will have



// Include the UserService class
require_once __DIR__ . '/../services/UserService.class.php';

// Set up the user service
Flight::set('user_service', new UserService());

//dodala ovaj dio kao kod prof - zatvara se na kraju

Flight::group ('/users', function () {

//get all users - swagger:
// tags to group our routes
/**
 * @OA\Get(
 *   path="/users/all",
 *   tags = {"users"},
 *   summary="Get all users", 
 *   @OA\Response(
 *     response=200,
 *     description="Array of the all users in the database"
 *   )
 * 
 * )
 */

Flight::route('GET /all', function () {
  
   
    $data = Flight::get('user_service')->get_all_users();
    Flight::json ($data,200);
});

/**
 * @OA\Get(
 *   path="/users/user",
 *   tags = {"users"},
 *   summary="Get user by id", 
 *   @OA\Response(
 *     response=200,
 *     description="User data or false if user does not exist"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="query", name="user_id", example="1", description="User ID")

 * 
 * )
 */

Flight::route('GET /user',function(){

    $params = Flight::request()->query;

    $user = Flight::get('user_service')->get_user_by_id($params['user_id']);
    Flight::json($user);
});


/**
 * @OA\Get(
 *   path="/users/get/{user_id}",
 *   tags = {"users"},
 *   summary="Get user by id", 
 *   @OA\Response(
 *     response=200,
 *     description="User data or false if user does not exist"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="path", name="user_id", example="1", description="User ID")

 * 
 * )
 */

 Flight::route('GET /get/@user_id',function($user_id){

    $user = Flight::get('user_service')->get_user_by_id($user_id);
    Flight::json($user);
});




// Define a route for GET requests to /users
Flight::route('GET /users', function () {
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

    // Retrieve data using the user service
    $data = Flight::get('user_service')->get_users_paginated(
        $params['start'],
        $params['limit'],
        $params['search'],
        $params['order_column'],
        $params['order_direction']
    );

    // Modify the data to include action buttons
    foreach ($data['data'] as $id => $user) {
        $data['data'][$id]['action'] = '<div class="d-flex gap-2">
                                            <button class="btn" onclick="UserService.open_edit_user_modal(' . $user['id'] . ')"><i class="fa fa-pencil"></i></button>
                                            <button class="btn" onclick="UserService.delete_user(' . $user['id'] . ')"><i class="fa fa-trash"></i></button>
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
 *   path="/users/add",
 *   tags = {"users"},
 *   summary="Add user data to the database", 
 *   @OA\Response(
 *     response=200,
 *     description="User data or exception if user is not addedd properly."
 *   ),
 *    @OA\RequestBody(
     *          description="User data payload",
     *          @OA\JsonContent(
     *              required={"name","surname"},
     *              @OA\Property(property="id", type="string", example="1", description="User ID"),
     *              @OA\Property(property="name", type="string", example="Some first name", description="User first name"),
     *              @OA\Property(property="surname", type="string", example="Some last name", description="User last name"),
     *              @OA\Property(property="email", type="string", example="example@example.com", description="User email address"),
     *              @OA\Property(property="phone", type="string", example="Some phone", description="User phone number"),
     *              @OA\Property(property="username", type="string", example="some_username", description="User username"),
     *              @OA\Property(property="password", type="string", example="some_secret_password", description="User password")
     *          )
 * )

 * 
 * )
 */


 /* POST /users/add */

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
    $user = Flight::get('user_service')->edit_user($payload);
} else {
    unset($payload['id']);
    $user = Flight::get('user_service')->add_user($payload);
}

//echo json_encode(['message' => "You have successfully added the user", 'data' => $user]);
Flight::json (['message' => "You have successfully added the user", 'data' => $user]);
});

//users/delete/15 - this is route parameter
//user_id = 15

/**
 * @OA\Delete(
 *   path="/users/delete/{user_id}",
 *   tags = {"users"},
 *   summary="Delete user by id", 
 *   @OA\Response(
 *     response=200,
 *     description="Deleted user data or 500 status code exception otherwise"
 *   ),
 *    @OA\Parameter(@OA\Schema(type="number"), in="path", name="user_id", example="1", description="User ID")

 * 
 * )
 */

Flight::route ('DELETE /delete/@user_id',function($user_id){

    if($user_id == NULL || $user_id == '') {
        FLight::halt(500,"You have to provide valid user id!");
    }
    
   
    Flight::get('user_service')->delete_user_by_id($user_id);
    Flight::json(['message' => 'You have successfully deleted the user!'],200);
    
    

});

//route parameters and query parameters
//query parameters ?length=1 (where..)

Flight::route('GET /users/@user_id', function($user_id) {  //promiejniti rutu 
    $user = Flight::get('user_service')->get_user_by_id($user_id);

    Flight::json($user, 200);
});

});