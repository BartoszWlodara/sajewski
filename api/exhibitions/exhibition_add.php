<?php

include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

	$databaseService = new DatabaseService();
	$conn = $databaseService->getConnection();

	$Title = '';
	$TitleANG = '';
	$TitleIT = ''; 
	$Description = ''; 
	$DescriptionANG = ''; 
	$DescriptionIT = ''; 
	$Date = '';

	$Title=$_POST['Title'];
	$TitleANG=$_POST['TitleANG'];
	$TitleIT=$_POST['TitleIT'];
	$Description=$_POST['Description'];
	$DescriptionANG=$_POST['DescriptionANG'];
	$DescriptionIT=$_POST['DescriptionIT'];
	$Date=$_POST['Date'];
	$fileName  =  time() . rand(11, 99) . basename ($_FILES['sendimage']['name']);
	$tempPath  =  $_FILES['sendimage']['tmp_name'];
	$fileSize  =  $_FILES['sendimage']['size'];
					
	$upload_path = 'upload/'; 
	$ulpoad_type = 'exhibition';
	include_once '../photoValidation.php';

	$filePath = $upload_path . $fileName;

	$table_name = $ExhibitionTable;

	// Send query
	if(!isset($errorMSG)){
		
		$query = "INSERT INTO " . $table_name . "
		SET Title = :Title,
			TitleANG = :TitleANG,
			TitleIT = :TitleIT,
			Description = :Description,
			DescriptionANG = :DescriptionANG,
			DescriptionIT = :DescriptionIT,
			Date = :Date,
			ImagePath = :ExhibitionImage";
	
		$stmt = $conn->prepare($query);
	
		$stmt->bindParam(':Title', $Title);
		$stmt->bindParam(':TitleANG', $TitleANG);
		$stmt->bindParam(':TitleIT', $TitleIT);
		$stmt->bindParam(':Description', $Description);
		$stmt->bindParam(':DescriptionANG', $DescriptionANG);
		$stmt->bindParam(':DescriptionIT', $DescriptionIT);
		$stmt->bindParam(':Date', $Date);
		$stmt->bindParam(':ExhibitionImage', $filePath);
				
		if($stmt->execute()){
			
			http_response_code(200);
			echo json_encode(array("message" => "Exhibition added."));
			$conn = null;
		}
		else{
	
			http_response_code(400);
			echo json_encode(array("message" => "Błąd podczas próby dodania wystawy."));
			$conn = null;
		}
	}else{
		http_response_code(400);
		$conn = null;
	}


}else{
	http_response_code(401);
    echo json_encode(array("message" => "Błąd podczas próby dodania wystawy. Brak dostępu."));
}

?>