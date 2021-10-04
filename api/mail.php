<?php

$from= '';
$topic = '';
$content = '';
$recaptchaToken = '';

$data = json_decode(file_get_contents("php://input"));  // collect input parameters and convert into readable format

$from= $data->email_from;
$topic = $data->topic;
$content = $data->content;
$recaptchaToken = $data->recaptcha;

if ((isset($recaptchaToken)) && (!empty($recaptchaToken)))
{   
    include_once './captchaKEY.php';

    $secret = $captchaKey;

    $ch = curl_init("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$recaptchaToken}");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $verify = curl_exec($ch);

$responseData = json_decode($verify);

    if ($responseData->success === true) 
    { 

        //$topic = preg_replace("/[^a-zA-Z0-9]+/", "", $topic);
        //content = preg_replace("/[^a-zA-Z0-9]+/", "", $content);

        $from_str = trim($from);
        $topic_str = trim($topic);
        $content_str = trim($content);

        if((strlen($from_str) >= 5)&&((strlen($topic_str) >= 10)&&((strlen($content_str) >= 20))))
        {

            $to = "bartek007.99@o2.pl";
            //$to = "umberto770@op.pl";

                $headers .= "Reply-To: <". $from .">\r\n"; 
                $headers .= "Return-Path: <". $from .">\r\n"; 
                $headers .= "From: andrzejsajewski.pl Formularz Kontaktowy <kontakt@andrzejsajewski.pl>\r\n" .
                $headers .= "Organization: Andrzej Sajewski\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=utf-8\r\n";
                $headers .= "X-Priority: 3\r\n";
                $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;

                $message = '
                <html>
                <head>
                <title>Wiadomość od: '.$from.'</title>
                </head>
                <body>
                <h3>Wiadomość od: '.$from.'</h3>
                <h4>Temat: '.$topic.'</h4>
                <p>'.$content.'</p>
                </body>
                </html>
                ';
            
            try{

                $retval = mail ($to,$topic,$message,$headers);

                http_response_code(200);
                echo json_encode(array("message" => "Wiadomość została wysłana.", "message_code" => "sent"));

            }catch (Extension $e){
                http_response_code(400);
                echo json_encode(array("message" => "Wystąpił problem podczas wysyłania wiadomości.", "message_code" => "error_mail"));
            }


        }else{
            http_response_code(400);
            echo json_encode(array("message" => "Wystąpił problem podczas wysyłania wiadomości.", "message_code" => "error_mail"));
        }


    }else 
    {
        http_response_code(400);
        echo json_encode(array("message" => "Wystąpił problem podczas wysyłania wiadomości. Spróbuj ponownie później, lub wyślij tradycyjnego E-maila.", 
        "message_code" => "error_mail_captcha"));
    }

}else{
    http_response_code(400);
        echo json_encode(array("message" => "Wystąpił problem podczas wysyłania wiadomości. Spróbuj ponownie później, lub wyślij tradycyjnego E-maila.", "message_code" => "error_mail_captcha"));
}

?>