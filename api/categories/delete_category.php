<?php

include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    $role = $data->role;

    $table_name = $CategoryTable;
    $table_name_pictures = $PictureTable;

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url_components = parse_url($url);

    $category = null; 

    if(isset($url_components['query'])){

        parse_str($url_components['query'], $params);

        //Page number

        if(isset($params['category'])){

            $category = $params['category'];

            if(($category != null)&&($category > 0)&&($role=='Administrator')&&($category != 00)){
                $category = $params['category'];
            }else{
                $category = null;
            }

        }else{
            $category = null;
        }
        

    }else{
        $category = null;
    }


    if($category != null){

        $query_search = "SELECT ID, CategoryImagePath FROM " . $table_name ." WHERE ID= " . $category . "";
        $stmt = $conn->prepare($query_search);
        $stmt->execute();

        $Photo_path = '';

        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $Photo_path = $row['CategoryImagePath'];
        }
    
        if($stmt->execute()){

            $query = "DELETE FROM " . $table_name ." WHERE id= " . $category . "";
            $stmt = $conn->prepare($query);
            $stmt->execute();
        
            if($stmt->execute()){
                
                unlink($Photo_path);
                // change category to '00' in pictures with deleted category

                $query_update = "UPDATE ". $table_name_pictures ." SET Category_ID = 00 WHERE Category_ID = ". $category ."";
                $stmt_x = $conn->prepare($query_update);
                $stmt_x->execute();

                if($stmt_x->execute()){
                    http_response_code(200);
                    echo json_encode(array("message" => "Category deleted.", "status" => 200));
                    $conn = null;
                }else{
                    http_response_code(200);
                    echo json_encode(array("message" => "Category deleted but pictures categories not changed!", "status" => 200));
                    $conn = null;
                }
                
            }
            else{
                http_response_code(400);
                echo json_encode(array("message" => "Can't delete category.", "status" => 400));
                $conn = null;
            }

        }else{
            http_response_code(400);
            echo json_encode(array("message" => "Can't delete category. No image to delete.", "status" => 400));
            $conn = null;
        }

    }else{
        http_response_code(400);
        echo json_encode(array("message" => "Can't delete category. Incorrect category to delete.", "status" => 400));
        $conn = null;
    }

   

}else{

	http_response_code(401);
    echo json_encode(array("message" => "Unable to delete category. No access.", "status" => 401));
}


?>