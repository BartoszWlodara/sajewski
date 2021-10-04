<?php

include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    $role = $data->role;

    $table_name = $ArrangementTable;

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url_components = parse_url($url);

    $arrangement = null; 

    if(isset($url_components['query'])){

        parse_str($url_components['query'], $params);

        //Page number

        if(isset($params['arrangement'])){

            $arrangement = $params['arrangement'];

            if(($arrangement != null)&&($arrangement > 0)&&($role=='Administrator')){
                $arrangement = $params['arrangement'];
            }else{
                $arrangement = null;
            }

        }else{
            $arrangement = null;
        }
        

    }else{
        $arrangement = null;
    }


    if($arrangement != null){

        $query = "SELECT ID, ImagePath, ImagePathMin FROM " . $table_name ." WHERE ID= " . $arrangement . "";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $Photo_path = '';
        $Photo_path_min = '';

        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $Photo_path = $row['ImagePath'];
            $Photo_path_min = $row['ImagePathMin'];
        }
    
        if($stmt->execute()){

            $query_delete = "DELETE FROM ". $table_name ." WHERE ID = ". $arrangement ."";
            $stmt_x = $conn->prepare($query_delete);
            $stmt_x->execute();

            if($stmt_x->execute()){
                http_response_code(200);
                echo json_encode(array("message" => "Arrangement deleted.", "status" => 200));
                unlink($Photo_path);
                unlink($Photo_path_min);
                $conn = null;
            }else{
                http_response_code(200);
                echo json_encode(array("message" => "Arrangement not deleted but arrangement id detected!", "status" => 200));
                $conn = null;
            } 
            
        }
        else{
            http_response_code(400);
            echo json_encode(array("message" => "Can't delete arrangement.", "status" => 400));
            $conn = null;
        }
    }else{
        http_response_code(400);
        echo json_encode(array("message" => "Can't delete arrangement. Incorrect arrangement to delete.", "status" => 400));
        $conn = null;
    }

   

}else{

	http_response_code(401);
    echo json_encode(array("message" => "Unable to delete arrangement. No access.", "status" => 401));
}


?>