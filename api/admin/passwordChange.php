<?php

//header("Access-Control-Allow-Origin: *");
/*header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: content-type");*/

include_once '../protected.php';
include_once '../SQL_Tables.php'; 

$email = '';
$password = '';

if($isAuth){

$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;
$newPassword = $data->newPassword;

$table_name = $UserTable;

$query = "SELECT id, e_mail, password FROM " . $table_name . " WHERE e_mail = ? LIMIT 0,1";

$stmt = $conn->prepare( $query );
$stmt->bindParam(1, $email);
$stmt->execute();
$num = $stmt->rowCount();

if($num > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $row['id'];
    $email_db = $row['e_mail'];
    $passwordDB = $row['password'];

    if((password_verify($password, $passwordDB))&&($email == $email_db))
    {
        $password_hash = password_hash($newPassword, PASSWORD_BCRYPT);

        $query_update = "UPDATE ". $table_name ." SET password = '". $password_hash ."' WHERE id = ". $id ."";
        $stmt_x = $conn->prepare($query_update);
        $stmt_x->execute();

        if($stmt_x->execute()){
            
            http_response_code(200);

            echo json_encode(array("message" => "Hasło zmienione.", "status" => 200));

        }else{
            http_response_code(200);
            $arr = $stmt_x->errorInfo();
            print_r($arr);
            echo json_encode(array("message" => "Hasło nie zostało zmienione.", "status" => 400));
        }

            $conn = null;
    }
    else{

        http_response_code(200);
        echo json_encode(array("message" => "Stare hasło nie jest poprawne.", "status" => 400));
        $conn = null;
    }
    
} else{

    http_response_code(200);
    echo json_encode(array("message" => "Nie znaleziono adresu email.", "status" => 400));
    $conn = null;
}

}else{

    http_response_code(401);
    echo json_encode(array("message" => "Unauthorized.", "status" => 401));

}


?>