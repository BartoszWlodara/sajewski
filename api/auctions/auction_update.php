<?php
include_once '../protected.php'; // include authorization
include_once '../SQL_Tables.php'; 

if($isAuth){

	$databaseService = new DatabaseService();
	$conn = $databaseService->getConnection();
		
	$table_name = $AuctionTable;
	$isFile;

	$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url_components = parse_url($url);

    $auction = null; 

    if(isset($url_components['query'])){

        parse_str($url_components['query'], $params);

        //Page number

        if(isset($params['auction'])){

            $auction = $params['auction'];

            if(($auction != null)&&($auction > 0)){
                $auction = $params['auction'];
            }else{
                $auction = null;
            }

        }else{
            $auction = null;
        }
        

    }else{
        $auction = null;
    }

	if($auction != null){

			$Title=$_POST['Title'];
			$TitleANG=$_POST['TitleANG'];
			$TitleIT=$_POST['TitleIT'];
			$Link=$_POST['Link'];
			$Date=$_POST['Date'];

			if(!empty($_FILES['sendimage'])){
				$isFile = true;
				$fileName  =  time() . rand(11, 99) . basename ($_FILES['sendimage']['name']);
				$tempPath  =  $_FILES['sendimage']['tmp_name'];
				$fileSize  =  $_FILES['sendimage']['size'];
			}else{
				$isFile = false;
			}
					
			$upload_path = 'upload/'; 
			$ulpoad_type = 'auctions';
			$Photo_path_DB = '';
			$Photo_path_DB_min = '';
			$Photo_path_updated = '';
			$Photo_path_updated_min = '';

			$query_search = "SELECT ID, ImagePath, ImagePathMin FROM " . $table_name ." WHERE ID= " . $auction . "";
            $stmt_search = $conn->prepare($query_search);
            $stmt_search->execute();

            $Photo_path;
			$Photo_path_min;
    
            while($row=$stmt_search->fetch(PDO::FETCH_ASSOC)){
                $Photo_path = $row['ImagePath'];
				$Photo_path_min = $row['ImagePathMin'];
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

					$query_update = "UPDATE ". $table_name ." SET Title = '". $Title ."', 
						ImagePath = '". $Photo_path_updated ."', ImagePathMin = '". $Photo_path_updated_min ."', TitleANG = '". $TitleANG ."',
						TitleIT = '". $TitleIT ."', Link = '". $Link ."', Date = '". $Date ."' WHERE ID = ". $auction ."";

					$stmt = $conn->prepare($query_update);
					$stmt->execute();
			
					if($stmt->execute()){
		
						http_response_code(200);
						echo json_encode(array("message" => "Auction updated."));
						if($isFile){
							unlink($Photo_path_DB);
							unlink($Photo_path_DB_min);
						}
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
                http_response_code(400);
                echo json_encode(array("message" => "Nie znaleziono obecnego zdjęcia aukcji do zastąpienia."));
                $conn = null;
            }


	}else{
		http_response_code(400);
        echo json_encode(array("message" => "Błąd podczas dodawania aukcji. Wskazana aukcja nie istnieje.", "status" => 400));
        $conn = null;
	}

}else{
	http_response_code(401);
    echo json_encode(array("message" => "Błąd podczas dodawania aukcji. Brak dostępu."));
}


?>