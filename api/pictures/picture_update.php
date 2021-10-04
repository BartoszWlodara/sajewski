<?php
include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

	$databaseService = new DatabaseService();
	$conn = $databaseService->getConnection();
		
	$table_name = $PictureTable;
	$pictureName = '';
	$pictureNameENG = '';
	$pictureNameIT = ''; 
	$isFile;

	$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url_components = parse_url($url);

    $picture = null; 

    if(isset($url_components['query'])){

        parse_str($url_components['query'], $params);

        //Page number

        if(isset($params['picture'])){

            $picture = $params['picture'];

            if(($picture != null)&&($picture > 0)){
                $picture = $params['picture'];
            }else{
                $picture = null;
            }

        }else{
            $picture = null;
        }
        

    }else{
        $picture = null;
    }

	if($picture != null){

			$pictureName=$_POST['PictureName'];
			$pictureNameENG = $_POST['PictureNameENG'];
			$pictureNameIT = $_POST['PictureNameIT'];

			if(!empty($_FILES['sendimage'])){
				$isFile = true;
				$fileName  =  time() . rand(11, 99) . basename ($_FILES['sendimage']['name']);
				$tempPath  =  $_FILES['sendimage']['tmp_name'];
				$fileSize  =  $_FILES['sendimage']['size'];
			}else{
				$isFile = false;
			}

			$category = $_POST['Category_ID'];
					
			$upload_path = 'upload/'; 
			$ulpoad_type = 'pictures';
			$Photo_path_DB = '';
			$Photo_path_DB_min = '';
			$Photo_path_updated = '';
			$Photo_path_updated_min = '';

			$query_search = "SELECT ID, PhotoImg, PhotoImg_min FROM " . $table_name ." WHERE ID= " . $picture . "";
            $stmt_search = $conn->prepare($query_search);
            $stmt_search->execute();

            $Photo_path;
			$Photo_path_min;
    
            while($row=$stmt_search->fetch(PDO::FETCH_ASSOC)){
                $Photo_path = $row['PhotoImg'];
				$Photo_path_min = $row['PhotoImg_min'];
            }

			if($stmt_search->execute()){

                $Photo_path_DB = $Photo_path;
				$Photo_path_DB_min = $Photo_path_min;

				if($isFile){
                    include_once '../photoValidation.php';

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
        
                    $Photo_path_updated = $upload_path . $fileName;
					$Photo_path_updated_min = $minimized_file;
        
                }else{
                    $Photo_path_updated = $Photo_path_DB;
					$Photo_path_updated_min = $Photo_path_DB_min;
                }

		
				if((!isset($errorMSG))&&(!isset($errorMSG_min))){

					$query_update = "UPDATE ". $table_name ." SET Title = '". $pictureName ."', 
						PhotoImg = '". $Photo_path_updated ."', PhotoImg_min = '". $Photo_path_updated_min ."', TitleANG = '". $pictureNameENG ."',
						TitleIT = '". $pictureNameIT ."', Category_ID = '". $category ."' WHERE ID = ". $picture ."";

					$stmt = $conn->prepare($query_update);
					$stmt->execute();
			
					if($stmt->execute()){
		
						http_response_code(200);
						echo json_encode(array("message" => "Picture updated."));
						if($isFile){
							unlink($Photo_path_DB);
							unlink($Photo_path_DB_min);
						}
						$conn = null;
					}
					else{
						http_response_code(400);
						echo json_encode(array("message" => "Błąd podczas próby aktualizowania obrazu."));
						$conn = null;
					}
		
				}else{
					http_response_code(400);
					$conn = null;
				}


			}else{
                http_response_code(400);
                $conn = null;
            }


	}else{
		http_response_code(400);
        echo json_encode(array("message" => "Błąd podczas próby aktualizowania obrazu. Niepoprawny obraz.", "status" => 400));
        $conn = null;
	}

}else{
	http_response_code(401);
    echo json_encode(array("message" => "Błąd podczas próby aktualizowania obrazu. Brak dostępu."));
}

?>