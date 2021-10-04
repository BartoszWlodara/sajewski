<?php
//header("Access-Control-Allow-Origin: *");      

include_once '../connect.php';
include_once '../SQL_Tables.php'; 

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $table_name = $ExhibitionTable;

	$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url_components = parse_url($url);

    $getExhibitionsSQL = '';

    if(isset($url_components['query'])){

        parse_str($url_components['query'], $params);

		$page = $params['page'];

		if(($page != null)||($page >= 0)){
            $page = $params['page'];
		}else{
            $page =1;
        }

		$no_of_records_per_page = 3;
		$offset = ($page-1) * $no_of_records_per_page; 

		$total_pages_sql = "SELECT COUNT(*) FROM " . $table_name . "";
		$result = $conn->prepare($total_pages_sql);
		$result->execute();

        $total_rows = $result->fetchColumn();
		$total_pages = ceil($total_rows / $no_of_records_per_page);

        $getExhibitionsSQL = "LIMIT $offset, $no_of_records_per_page";
    }

    // Send query
    $query = "SELECT ID, Title, TitleANG, TitleIT, Description, DescriptionANG, DescriptionIT, Date, ImagePath FROM $table_name ORDER BY ID DESC " . $getExhibitionsSQL . "";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $importArray = array();

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $importArray['Exhibitions'][] = $row;
    }

    if($stmt->execute()){

        http_response_code(200);
        echo json_encode(array("data" => $importArray, "pages" => $total_pages));
        $conn = null;
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Can't download exhibitions.", "status" => 400));
        $conn = null;
    }


?>