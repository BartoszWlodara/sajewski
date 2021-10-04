<?php

include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

	$databaseService = new DatabaseService();
	$conn = $databaseService->getConnection();

	$Title = '';
	$TitleANG = '';
	$TitleIT = ''; 
	$Link = ''; 
	$Date = '';

	$data = json_decode(file_get_contents("php://input"));  // collect input parameters and convert into readable format


	$Title=$_POST['Title'];
	$TitleANG=$_POST['TitleANG'];
	$TitleIT=$_POST['TitleIT'];
	$Link=$_POST['Link'];
	$Date=$_POST['Date'];
	$fileName  =  time() . rand(11, 99) . basename ($_FILES['sendimage']['name']);
	$tempPath  =  $_FILES['sendimage']['tmp_name'];
	$fileSize  =  $_FILES['sendimage']['size'];
			
	$upload_path = 'upload/'; 
	$ulpoad_type = 'auction';
	include_once '../photoValidation.php';

	$filePath = $upload_path . $fileName;

	$table_name = $AuctionTable;

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
		// Send query

		$query = "INSERT INTO " . $table_name . "
		SET Title = :Title,
			TitleANG = :TitleANG,
			TitleIT = :TitleIT,
			Link = :Link,
			Date = :Date,
			ImagePath = :AuctionImage,
			ImagePathMin = :AuctionImageMin";

		$stmt = $conn->prepare($query);

		$stmt->bindParam(':Title', $Title);
		$stmt->bindParam(':TitleANG', $TitleANG);
		$stmt->bindParam(':TitleIT', $TitleIT);
		$stmt->bindParam(':Link', $Link);
		$stmt->bindParam(':Date', $Date);
		$stmt->bindParam(':AuctionImage', $filePath);
		$stmt->bindParam(':AuctionImageMin', $minimized_file);
				
		if($stmt->execute()){
			
			http_response_code(200);
			echo json_encode(array("message" => "Auction added."));
			$conn = null;
		}
		else{

			http_response_code(400);
			echo json_encode(array("message" => "Błąd podczas dodawania aukcji."));
			$conn = null;
		}


	}else{
		http_response_code(400);
		$conn = null;
	}


}else{
	http_response_code(401);
    echo json_encode(array("message" => "Błąd podczas dodawania aukcji. Brak dostępu."));
}


?>