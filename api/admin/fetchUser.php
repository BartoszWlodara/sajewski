<?php
include_once '../protected.php';

if($isAuth){

    include_once '../SQL_Tables.php';

    $table_name = $UserTable;

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $table_name = 'Users';

    $query = "SELECT id FROM " . $table_name . " WHERE e_mail = ? LIMIT 0,1";

    $stmt = $conn->prepare( $query );
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $num = $stmt->rowCount();

    if($num > 0){
        
        http_response_code(200);
        echo json_encode(array(
    
            "message" => "Access granted:",
            "jwt" => $jwt
       
        ));
        $conn = null;

    }else{

        http_response_code(401);
        echo json_encode(array("message" => "Login failed. No user.", "status" => 401));
        $conn = null;
    }

}else{
    http_response_code(401);
    
    echo json_encode(array(
        "message" => "Access denied."
    ));
}

?>