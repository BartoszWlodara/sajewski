<?php

//header("Access-Control-Allow-Origin: *");
/*header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: content-type");*/

include_once './connect.php';
require "./vendor/autoload.php";
use \Firebase\JWT\JWT;

$email = '';
$password = '';

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;
$recaptchaToken = $data->recaptcha;

if (isset($recaptchaToken) &&! empty($recaptchaToken)) 
{   
    include_once './captchaKEY.php';

    $secret = $captchaKey;

    $replaceResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$recaptchaToken);
    $responseData = json_decode ($replaceResponse); 
    if (1==1) // TEST LOCALHOST -> $responseData-> success
    {
        $databaseService = new DatabaseService();
        $conn = $databaseService->getConnection();


        $table_name = 'Users';

        $query = "SELECT id, name, e_mail, role, password FROM " . $table_name . " WHERE e_mail = ? LIMIT 0,1";

        $stmt = $conn->prepare( $query );
        $stmt->bindParam(1, $email);
        $stmt->execute();
        $num = $stmt->rowCount();

        if($num > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $row['id'];
            $name = $row['name'];
            $role = $row['role'];
            $email_db = $row['e_mail'];
            $password2 = $row['password'];

            if((password_verify($password, $password2))&&($email == $email_db))
            {
                $secret_key = "oBa32KUB5nui7SEdUwMNdwm8XeskhvAz";
                $issuer_claim = "THE_ISSUER"; // this can be the servername
                $audience_claim = "THE_AUDIENCE";
                $issuedat_claim = time(); // issued at
                $notbefore_claim = $issuedat_claim; //not before in seconds
                $expire_claim = $issuedat_claim + 3600; // expire time in seconds  / 10h
                $token = array(
                    "iss" => $issuer_claim,
                    "aud" => $audience_claim,
                    "iat" => $issuedat_claim,
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $id,
                        "name" => $name,
                        "role" => $role,
                        "email" => $email
                ));

                http_response_code(200);

                $jwt = JWT::encode($token, $secret_key);
                echo json_encode(
                    array(
                        "message" => "Successful login.",
                        "jwt" => $jwt,
                        "status" => 200,
                        "email" => $email,
                        "name" => $name,
                        "role" => $role,
                        "expireAt" => $expire_claim
                    ));

                    $conn = null;
            }
            else{

                http_response_code(401);
                echo json_encode(array("message" => "Nieprawidłowy login lub hasło.", "status" => 401));
                $conn = null;
            }
        }  else{

            http_response_code(401);
            echo json_encode(array("message" => "Nieprawidłowy login lub hasło.", "status" => 401));
            $conn = null;
        }
    }
    else{

        http_response_code(401);
        echo json_encode(array("message" => "Błąd logowania. Brak połączenia z Captcha. Spróbuj za jakiś czas.", "status" => 401));
    }
}else{
    http_response_code(401);
    echo json_encode(array("message" => "Błąd logowania. Brak połączenia z Captcha. Spróbuj za jakiś czas.", "status" => 401));
}
?>