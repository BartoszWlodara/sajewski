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
	$isFile;

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url_components = parse_url($url);

    $exhibition = null; 

    if(isset($url_components['query'])){

        parse_str($url_components['query'], $params);

        //Page number

        if(isset($params['exhibition'])){

            $exhibition = $params['exhibition'];

            if(($exhibition != null)&&($exhibition > 0)){
                $exhibition = $params['exhibition'];
            }else{
                $exhibition = null;
            }

        }else{
            $exhibition = null;
        }
        

    }else{
        $exhibition = null;
    }

	if($exhibition != null){

		$Title=$_POST['Title'];
		$TitleANG=$_POST['TitleANG'];
		$TitleIT=$_POST['TitleIT'];
		$Description=$_POST['Description'];
		$DescriptionANG=$_POST['DescriptionANG'];
		$DescriptionIT=$_POST['DescriptionIT'];
		$Date=$_POST['Date'];

		if(!empty($_FILES['sendimage'])){
            $isFile = true;
            $fileName  =  time() . rand(11, 99) . basename ($_FILES['sendimage']['name']);
            $tempPath  =  $_FILES['sendimage']['tmp_name'];
            $fileSize  =  $_FILES['sendimage']['size'];
        }else{
            $fileName = false;
        }
					
		$table_name = $ExhibitionTable;
		$upload_path = 'upload/'; 
		$ulpoad_type = 'exhibition';
		$Photo_path_DB = '';
		$Photo_path_updated = '';

		$query_search = "SELECT ID, ImagePath FROM " . $table_name ." WHERE ID= " . $exhibition . "";
		$stmt_search = $conn->prepare($query_search);
		$stmt_search->execute();

		$Photo_path;

		while($row=$stmt_search->fetch(PDO::FETCH_ASSOC)){
			$Photo_path = $row['ImagePath'];
		}

		if($stmt_search->execute()){

			$Photo_path_DB = $Photo_path;

			if($isFile){
				include_once '../photoValidation.php';
	
				$Photo_path_updated = $upload_path . $fileName;
	
			}else{
				$Photo_path_updated = $Photo_path_DB;
			}

			if(!isset($errorMSG)){
				$query_update = "UPDATE ". $table_name ." SET Title = '". $Title ."', TitleANG = '". $TitleANG ."', TitleIT = '". $TitleIT ."', 
				Description = '". $Description ."', DescriptionANG = '". $DescriptionANG ."', DescriptionIT = '". $DescriptionIT ."',
				Date = '". $Date ."', ImagePath = '". $Photo_path_updated ."' WHERE ID = ". $exhibition ."";
				$stmt = $conn->prepare($query_update);
				$stmt->execute();

				if($stmt->execute()){
				
					http_response_code(200);
					echo json_encode(array("message" => "Exhibition updated."));
					if($isFile){
						unlink($Photo_path_DB);
					}
					$conn = null;
				}
				else{
		
					http_response_code(400);
					echo json_encode(array("message" => "Błąd podczas próby aktualizacji wystawy."));
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
        echo json_encode(array("message" => "Błąd podczas próby aktualizacji wystawy. Nie odnaleziono wskazanej wystawy.", "status" => 400));
        $conn = null;
	}
	
}else{
	http_response_code(401);
	echo json_encode(array("message" => "Błąd podczas próby aktualizacji wystawy. Brak dostępu."));
}


?>