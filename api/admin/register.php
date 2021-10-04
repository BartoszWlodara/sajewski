<?php
include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

$name = '';
$email = '';
$role = '';
$password = '';
$conn = null;

if($isAuth){

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $data = json_decode(file_get_contents("php://input"));

    $name = $data->name;
    $email = $data->email;
    $role = $data->role;
    $password = $data->password;

    $table_name = $UserTable;

    $query_search = "SELECT id FROM " . $table_name . " WHERE e_mail = ? LIMIT 0,1";

    $stmt = $conn->prepare( $query_search );
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $num = $stmt->rowCount();

    if($num == 0){

            $query = "INSERT INTO " . $table_name . "
            SET name = :name,
            e_mail = :email,
            role = :role,
            password = :password";

            $stmt = $conn->prepare($query);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);

            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $stmt->bindParam(':password', $password_hash);


            if($stmt->execute()){

            http_response_code(200);
            echo json_encode(array("message" => "User was successfully registered."));
            $conn = null;
            }
            else{
            http_response_code(400);
            echo json_encode(array("message" => "Wystąpił błąd podczas rejestracji użytkownika.", "status" => 400));
            $conn = null;
            }
    }else{

        http_response_code(400);
        echo json_encode(array("message" => "Wprowadzony email istnieje już w systemie. Wprowadź inny.", "status" => 400));
        $conn = null;
    }

}else{

	http_response_code(401);
    echo json_encode(array("message" => "Wystąpił błąd podczas rejestracji użytkownika. Brak dostępu.", "status" => 401));
}

?>