<?php

include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    $role = $data->role;

    $table_name = $ExhibitionTable;

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url_components = parse_url($url);

    $exhibition = null; 

    if(isset($url_components['query'])){

        parse_str($url_components['query'], $params);

        //Page number

        if(isset($params['exhibition'])){

            $exhibition = $params['exhibition'];

            if(($exhibition != null)&&($exhibition > 0)&&($role=='Administrator')){
                $exhibition = $params['exhibition'];
            }else{
                $exhibition = null;
            }

        }else{
            $exhibition = null;
        }
        

    }else{
        $exhibition = null;
    }


    if($exhibition != null){

        $query = "SELECT ID, ImagePath FROM " . $table_name ." WHERE ID= " . $exhibition . "";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $Photo_path = '';

        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $Photo_path = $row['ImagePath'];
        }
    
        if($stmt->execute()){

            $query_delete = "DELETE FROM ". $table_name ." WHERE ID = ". $exhibition ."";
            $stmt_x = $conn->prepare($query_delete);
            $stmt_x->execute();

            if($stmt_x->execute()){
                http_response_code(200);
                echo json_encode(array("message" => "Exhibition deleted.", "status" => 200));
                unlink($Photo_path);
                $conn = null;
            }else{
                http_response_code(200);
                echo json_encode(array("message" => "Exhibition not deleted but exhibition id detected!", "status" => 200));
                $conn = null;
            } 
            
        }
        else{
            http_response_code(400);
            echo json_encode(array("message" => "Can't delete exhibition.", "status" => 400));
            $conn = null;
        }
    }else{
        http_response_code(400);
        echo json_encode(array("message" => "Can't delete exhibition. Incorrect exhibition to delete.", "status" => 400));
        $conn = null;
    }

   

}else{

	http_response_code(401);
    echo json_encode(array("message" => "Unable to delete exhibition. No access.", "status" => 401));
}


?>