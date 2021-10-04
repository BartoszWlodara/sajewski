<?php
include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $categoryName = '';
    $categoryNameENG = '';
    $categoryNameIT = ''; 

    $categoryName=$_POST['CategoryName'];
    $categoryNameENG = $_POST['CategoryNameENG'];
    $categoryNameIT = $_POST['CategoryNameIT'];
    $fileName  =  time() . rand(11, 99) . basename ($_FILES['sendimage']['name']);
    $tempPath  =  $_FILES['sendimage']['tmp_name'];
    $fileSize  =  $_FILES['sendimage']['size'];
            		
	$upload_path = 'upload/'; 
    $ulpoad_type = 'category';
	include_once '../photoValidation.php';

    $filePath = $upload_path . $fileName;

    $table_name = $CategoryTable;

    // Send query
    
    if(!isset($errorMSG)){
        
        $query = "INSERT INTO " . $table_name . "
        SET CategoryName = :CategoryName,
            CategoryImagePath = :CategoryImagePath,
            CategoryNameENG = :CategoryNameENG,
            CategoryNameIT = :CategoryNameIT";
    
        $stmt = $conn->prepare($query);
    
        $stmt->bindParam(':CategoryName', $categoryName);
        $stmt->bindParam(':CategoryImagePath', $filePath);
        $stmt->bindParam(':CategoryNameENG', $categoryNameENG);
        $stmt->bindParam(':CategoryNameIT', $categoryNameIT);
                
        if($stmt->execute()){
    
            http_response_code(200);
            echo json_encode(array("message" => "Category created."));
            $conn = null;
        }
        else{
            http_response_code(400);
            echo json_encode(array("message" => "Błąd podczas próby dodawania kategorii."));
            $conn = null;
        }    
    }else{
        http_response_code(400);
        $conn = null;
    }

}else{
    http_response_code(401);
    echo json_encode(array("message" => "Błąd podczas próby dodawania kategorii. Brak dostępu."));
}
?>