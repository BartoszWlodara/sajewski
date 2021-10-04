<?php
//header("Access-Control-Allow-Origin: *");   
   
include_once '../connect.php';
include_once '../SQL_Tables.php'; 

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $table_name = $ArrangementTable;

    // Send query
    $query = "SELECT ID, ImagePath, ImagePathMin FROM " . $table_name ." ORDER BY ID DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $importArray = array();

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $importArray['Arrangements'][] = $row;
    }

    if($stmt->execute()){

        http_response_code(200);
        echo json_encode($importArray);
        $conn = null;
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Can't download arrangements.", "status" => 400));
        $conn = null;
    }


?>