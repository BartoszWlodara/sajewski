<?php

include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

	$databaseService = new DatabaseService();
	$conn = $databaseService->getConnection();

	$data = json_decode(file_get_contents("php://input"));  // collect input parameters and convert into readable format

	$fileName  =  time() . rand(11, 99) . basename ($_FILES['sendimage']['name']);
	$tempPath  =  $_FILES['sendimage']['tmp_name'];
	$fileSize  =  $_FILES['sendimage']['size'];
			
	$upload_path = 'upload/'; 
	$ulpoad_type = 'arrangement';
	include_once '../photoValidation.php';

	$filePath = $upload_path . $fileName;

	$table_name = $ArrangementTable;

	// Send query

	if(empty($minimized_file))
	{
		$errorMSG_min = true;
	}
	else
	{

		$image_destination = $minimized_file;

		$sendMiniature = true;

		$compress_images = compressImage($minimized_file, $image_destination, $sendMiniature);	

	}

	if((!isset($errorMSG))&&(!isset($errorMSG_min))){

		$query = "INSERT INTO " . $table_name . "
		SET 
			ImagePath = :ArrangementImage,
			ImagePathMin = :ArrangementImageMin";

		$stmt = $conn->prepare($query);

		$stmt->bindParam(':ArrangementImage', $filePath);
		$stmt->bindParam(':ArrangementImageMin', $minimized_file);
				
		if(($stmt->execute()) && (!isset($errorMSG))){
			
			http_response_code(200);
			echo json_encode(array("message" => "Arrangement added."));
			$conn = null;
		}
		else{

			http_response_code(400);
			echo json_encode(array("message" => "Błąd podczas dodawania aranżacji."));
			$conn = null;
		}

	}else{
		http_response_code(400);
		$conn = null;
	}

}else{
	http_response_code(401);
    echo json_encode(array("message" => "Błąd podczas dodawania aranżacji. Brak dostępu."));
}


?>