<?php
include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $categoryName = '';
    $categoryNameENG = '';
    $categoryNameIT = ''; 
    $isFile;

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url_components = parse_url($url);

    $category = null; 

    if(isset($url_components['query'])){

        parse_str($url_components['query'], $params);

        //Page number

        if(isset($params['category'])){

            $category = $params['category'];

            if(($category != null)&&($category > 0)&&($category != 00)){
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

        $categoryName=$_POST['CategoryName'];
        $categoryNameENG = $_POST['CategoryNameENG'];
        $categoryNameIT = $_POST['CategoryNameIT'];

        if(!empty($_FILES['sendimage'])){
            $isFile = true;
            $fileName  =  time() . rand(11, 99) . basename ($_FILES['sendimage']['name']);
            $tempPath  =  $_FILES['sendimage']['tmp_name'];
            $fileSize  =  $_FILES['sendimage']['size'];
        }else{
            $isFile = false;
        }
    
        $table_name = $CategoryTable;
        $upload_path = 'upload/'; 
        $ulpoad_type = 'category';
        $Photo_path_DB = '';
        $Photo_path_updated = '';

        $query_search = "SELECT ID, CategoryImagePath FROM " . $table_name ." WHERE ID= " . $category . "";
            $stmt_search = $conn->prepare($query_search);
            $stmt_search->execute();

            $Photo_path;
    
            while($row=$stmt_search->fetch(PDO::FETCH_ASSOC)){
                $Photo_path = $row['CategoryImagePath'];
            }

            if($stmt_search->execute()){

                $Photo_path_DB = $Photo_path;
                $errorMSG;

                if($isFile){
                    include_once '../photoValidation.php';
        
                    $Photo_path_updated = $upload_path . $fileName;
        
                }else{
                    $Photo_path_updated = $Photo_path_DB;
                }

                if(!isset($errorMSG)){

                    $query_update = "UPDATE ". $table_name ." SET CategoryName = '". $categoryName ."', CategoryNameENG = '". $categoryNameENG ."', CategoryNameIT = '". $categoryNameIT ."', CategoryImagePath = '". $Photo_path_updated ."' WHERE ID = ". $category ."";
                    $stmt = $conn->prepare($query_update);
                    $stmt->execute();
                
                    if(($stmt->execute()) && (!isset($errorMSG))){
            
                        http_response_code(200);
                        echo json_encode(array("message" => "Category updated."));
                        if($isFile){
                            unlink($Photo_path_DB);
                        }
                        $conn = null;
                    }
                    else{
                        http_response_code(400);
                        echo json_encode(array("message" => "Błąd podczas próby aktualizacji kategorii."));
                        $conn = null;
                    }
                }else{
                    http_response_code(400);
                    $conn = null;
                }


            }else{
                http_response_code(400);
                echo json_encode(array("message" => "Błąd. Nie znaleziono obecnego zdjęcia w bazie danych."));
                $conn = null;
            }

       
    }else{
        http_response_code(400);
        echo json_encode(array("message" => "Błąd podczas próby aktualizacji kategorii. Niepoprawna kategoria.", "status" => 400));
        $conn = null;
    }

}else{
    http_response_code(401);
    echo json_encode(array("message" => "Błąd podczas próby aktualizacji kategorii. Brak dostępu."));
}
?>