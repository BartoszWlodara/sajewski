<?php

include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    $role = $data->role;

    $table_name = $UserTable;

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url_components = parse_url($url);

    $user = null; 

    if(isset($url_components['query'])){

        parse_str($url_components['query'], $params);

        //Page number

        if(isset($params['user'])){

            $user = $params['user'];

            if(($user != null)&&($user > 0)&&($role!='Administrator')){
                $user = $params['user'];
            }else{
                $user = null;
            }

        }else{
            $user = null;
        }
        

    }else{
        $user = null;
    }


    if($user != null){

        $query = "DELETE FROM " . $table_name ." WHERE id= " . $user . "";
        $stmt = $conn->prepare($query);
        $stmt->execute();
    
        if($stmt->execute()){

            http_response_code(200);
            echo json_encode(array("message" => "User deleted.", "status" => 200));
            $conn = null;
        }
        else{
            http_response_code(400);
            echo json_encode(array("message" => "Can't delete user.", "status" => 400));
            $conn = null;
        }
    }else{
        http_response_code(400);
        echo json_encode(array("message" => "Can't delete user. Incorrect user to delete.", "status" => 400));
        $conn = null;
    }

   

}else{

	http_response_code(401);
    echo json_encode(array("message" => "Unable to delete user. No access.", "status" => 401));
}


?>