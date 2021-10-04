<?php
include_once '../connect.php';
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

/*header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");*/


$secret_key = "oBa32KUB5nui7SEdUwMNdwm8XeskhvAz";
$jwt = null;
$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();


$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

$arr = explode(" ", $authHeader);


/*echo json_encode(array(
    "message" => "sd" .$arr[1]
));*/


$jwt = $arr[1];


$isAuth = false;

if($jwt){

    try {

        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        $isAuth = true;
        // Access is granted. Add code of the operation here 
       // http_response_code(200);
        $email = $decoded->data->email;

        /*echo json_encode(array(

                "message" => "Access granted:",
                "jwt" => $email
           
        )); */

    }catch (Exception $e){

        $isAuth = false;

        //http_response_code(401);
/*
        echo json_encode(array(
            "message" => "Access denied."
        )); */
    }

}else{
    
    $isAuth = false;

   // http_response_code(401);
/*
    echo json_encode(array(
        "message" => "Access denied. No token"
    )); */
}
?>