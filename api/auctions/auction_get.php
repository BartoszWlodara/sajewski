<?php
//header("Access-Control-Allow-Origin: *");      

include_once '../connect.php';
include_once '../SQL_Tables.php'; 

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $table_name = $AuctionTable;

    // Send query
    $query = "SELECT ID, Title, TitleANG, TitleIT, Link, Date, ImagePath, ImagePathMin FROM " . $table_name ." ORDER BY ID DESC";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $importArray = array();

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $importArray['Auctions'][] = $row;
    }

    if($stmt->execute()){

        http_response_code(200);
        echo json_encode($importArray);
        $conn = null;
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Can't download auctions.", "status" => 400));
        $conn = null;
    }


?>