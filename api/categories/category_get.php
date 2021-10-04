<?php
//header("Access-Control-Allow-Origin: *");      

include_once '../connect.php';
include_once '../SQL_Tables.php'; 

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $table_name = $CategoryTable;

    // Send query
    $query = "SELECT ID, CategoryName, CategoryImagePath, CategoryNameENG, CategoryNameIT FROM " . $table_name ." ORDER BY ID DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $categoryArray = array();

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $categoryArray['Categories'][] = $row;
    }

    if($stmt->execute()){

        http_response_code(200);
        echo json_encode($categoryArray);
        $conn = null;
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Can't download categories.", "status" => 400));
        $conn = null;
    }


?>