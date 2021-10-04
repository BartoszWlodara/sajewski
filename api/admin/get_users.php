<?php

include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $table_name = $UserTable;

    // Send query
    $query = "SELECT id, name, e_mail, role FROM " . $table_name ."";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $importArray = array();

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $importArray['Users'][] = $row;
    }

    if($stmt->execute()){

        http_response_code(200);
        echo json_encode($importArray);
        $conn = null;
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Can't download users.", "status" => 400));
        $conn = null;
    }

}else{

	http_response_code(401);
    echo json_encode(array("message" => "Unable to get users. No access.", "status" => 401));
}


?>