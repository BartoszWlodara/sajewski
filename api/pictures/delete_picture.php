<?php

include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    $role = $data->role;

    $table_name = $PictureTable;

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url_components = parse_url($url);

    $picture = null; 

    if(isset($url_components['query'])){

        parse_str($url_components['query'], $params);

        //Page number

        if(isset($params['picture'])){

            $picture = $params['picture'];

            if(($picture != null)&&($picture > 0)&&($role=='Administrator')){
                $picture = $params['picture'];
            }else{
                $picture = null;
            }

        }else{
            $picture = null;
        }
        

    }else{
        $picture = null;
    }


    if($picture != null){

        $query = "SELECT ID, PhotoImg, PhotoImg_min FROM " . $table_name ." WHERE ID= " . $picture . "";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $Photo_path = '';
        $Photo_path_min = '';

        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $Photo_path = $row['PhotoImg'];
            $Photo_path_min = $row['PhotoImg_min'];
        }
    
        if($stmt->execute()){

            $query_delete = "DELETE FROM ". $table_name ." WHERE ID = ". $picture ."";
            $stmt_x = $conn->prepare($query_delete);
            $stmt_x->execute();

            if($stmt_x->execute()){
                http_response_code(200);
                echo json_encode(array("message" => "Picture deleted.", "status" => 200));
                unlink($Photo_path);
                unlink($Photo_path_min);
                $conn = null;
            }else{
                http_response_code(200);
                echo json_encode(array("message" => "Picture not deleted but picture id detected!", "status" => 200));
                $conn = null;
            } 
            
        }
        else{
            http_response_code(400);
            echo json_encode(array("message" => "Can't delete picture.", "status" => 400));
            $conn = null;
        }
    }else{
        http_response_code(400);
        echo json_encode(array("message" => "Can't delete picture. Incorrect picture to delete.", "status" => 400));
        $conn = null;
    }

   

}else{

	http_response_code(401);
    echo json_encode(array("message" => "Unable to delete picture. No access.", "status" => 401));
}


?>