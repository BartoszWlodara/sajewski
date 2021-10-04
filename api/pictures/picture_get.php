<?php
//header("Access-Control-Allow-Origin: *");      

include_once '../connect.php';
include_once '../SQL_Tables.php'; 

    $databaseService = new DatabaseService();
    $conn = $databaseService->getConnection();

    $table_name = $PictureTable;

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url_components = parse_url($url);

    $getCategorySQL = '';
    $getPageNoSQL = '';

    $page;

    if(isset($url_components['query'])){

        parse_str($url_components['query'], $params);

        //Page number

        if(isset($params['page'])){

            $page = $params['page'];

            if(($page != null)||($page >= 0)){
                $page = $params['page'];
            }else{
                $page =1;
            }

        }else{
            $page = 1;
        }
        
        

        // Category Type

        $category; 
        if(isset($params['category'])){

            $category = $params['category'];

            if($category == '00'){
                $getCategorySQL = "";
            }else{
                $getCategorySQL = "WHERE Category_ID = " . $category . "";
            }

        }else{
            $getCategorySQL = "";
        }
       
    }else{
        $page = 1;
    }

    $no_of_records_per_page = 9;
	$offset = ($page-1) * $no_of_records_per_page; 

	$total_pages_sql = "SELECT COUNT(*) FROM " . $table_name . " " . $getCategorySQL . "";
	$result = $conn->prepare($total_pages_sql);
	$result->execute();

    $total_rows = $result->fetchColumn();
	$total_pages = ceil($total_rows / $no_of_records_per_page);

    $getPageNoSQL = "LIMIT $offset, $no_of_records_per_page";

    // Send query
    $query = "SELECT ID, Title, PhotoImg, PhotoImg_min, TitleANG, TitleIT, Category_ID FROM " . $table_name ." " . $getCategorySQL . " ORDER BY ID DESC " . $getPageNoSQL . "";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $importArray = array();

    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        $importArray['Pictures'][] = $row;
    }

    if($stmt->execute()){

        http_response_code(200);
        echo json_encode(array("data" => $importArray, "pages" => $total_pages));
        $conn = null;
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Can't download pictures.", "status" => 400));
        $conn = null;
    }


?>