<?php


include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

	$databaseService = new DatabaseService();
	$conn = $databaseService->getConnection();

	$pictureName = '';
	$pictureNameENG = '';
	$pictureNameIT = ''; 

	$pictureName=$_POST['PictureName'];
	$pictureNameENG = $_POST['PictureNameENG'];
	$pictureNameIT = $_POST['PictureNameIT'];
	$fileName  =  time() . rand(11, 99) . basename ($_FILES['sendimage']['name']);
//	$fileName_min  =  time() . rand(11, 99) ."-miniature-". basename ($_FILES['sendimage']['name']);
	$tempPath  =  $_FILES['sendimage']['tmp_name'];
//	$tempPath_min  =  clone $_FILES['sendimage'];
	$fileSize  =  $_FILES['sendimage']['size'];
	//$fileSize_min  =  $_FILES['sendimage']['size'];
	$category = $_POST['Category_ID'];
			
	$upload_path = 'upload/'; 
	$ulpoad_type = 'pictures';
	include_once '../photoValidation.php';


	$filePath = $upload_path . $fileName;
	//$filePath_min = $upload_path . $fileName_min;

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

	$table_name = $PictureTable;

	// Send query

	$query = "INSERT INTO " . $table_name . "
	SET Title = :PictureName,
		PhotoImg = :PictureImagePath,
		PhotoImg_min = :PictureImagePath_min,
		TitleANG = :PictureNameENG,
		TitleIT = :PictureNameIT,
		Category_ID = :Category_ID";

	$stmt = $conn->prepare($query);

	$stmt->bindParam(':PictureName', $pictureName);
	$stmt->bindParam(':PictureImagePath', $filePath);
	$stmt->bindParam(':PictureImagePath_min', $minimized_file);
	$stmt->bindParam(':PictureNameENG', $pictureNameENG);
	$stmt->bindParam(':PictureNameIT', $pictureNameIT);
	$stmt->bindParam(':Category_ID', $category);
			
	if($stmt->execute()){

		http_response_code(200);
		echo json_encode(array("message" => "Picture added."));
		$conn = null;
	}
	else{
		http_response_code(400);
		echo json_encode(array("message" => "Błąd podczas próby dodawania obrazu."));
		$conn = null;
	}

}else{
	http_response_code(400);
	//echo json_encode(array("message" => "Unable to add the picture. Photos issue."));
	$conn = null;
}


}else{
	http_response_code(401);
    echo json_encode(array("message" => "Błąd podczas próby dodawania obrazu. Brak dostępu."));
}

?>