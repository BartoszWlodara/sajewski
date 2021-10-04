<?php

function compressImage($source_image, $compress_image, $miniature) {

    $image_info = getimagesize($source_image);	

    if($miniature == true){

         // Get new sizes
        list($width, $height) = $image_info;
        $newwidth = 900;
        $newheight = ($newwidth/$width)*$height;

        // Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        if ($image_info['mime'] == 'image/png') { 
            $source = imagecreatefrompng($source_image);
        }else{
            $source = imagecreatefromjpeg($source_image);
        }
        
        // Resize
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        if ($image_info['mime'] == 'image/jpeg') { 
            imagejpeg($thumb, $compress_image, 30);
        }elseif ($image_info['mime'] == 'image/png') {
            imagepng($thumb, $compress_image, 8);
        }	    
        return $compress_image;

    }else{

        if ($image_info['mime'] == 'image/jpeg') { 
            $source_image = imagecreatefromjpeg($source_image);
            imagejpeg($source_image, $compress_image, 30);
        }elseif ($image_info['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($source_image);
            imagepng($source_image, $compress_image, 8);
        }	    
        return $compress_image;
    }
}

$minimized_file = null;

if(empty($fileName))
{
    $errorMSG = json_encode(array("message" => "Nie wybrano zdjęcia", "status" => false, "err_code" => "NoImage"));	
    echo $errorMSG;
}
else
{   
    
    $fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension
        
    $valid_extensions = array('jpeg', 'jpg', 'png'); 

    // allow valid image file formats
    if(in_array($fileExt, $valid_extensions))
    {				
        //check file not exist our upload folder path
        if(!file_exists($upload_path . $fileName))
        {
            // check file size '3,5MB'
            if($fileSize < 3500000){

                $image_destination = $upload_path.$fileName;

                if($ulpoad_type == 'category' || $ulpoad_type == 'exhibition'){
                    move_uploaded_file($tempPath, $upload_path . $fileName);
                    $sendMiniature = true;
                    $compress_images = compressImage($upload_path . $fileName, $image_destination, $sendMiniature);	

                }else{
                    move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path 
                    $minimized_file = $upload_path . "minimized".$fileName;
                    copy($upload_path . $fileName, $minimized_file);
    
                    $sendMiniature = false;
                    $compress_images = compressImage($upload_path . $fileName, $image_destination, $sendMiniature);	
                }

            }
            else{		
                $errorMSG = json_encode(array("message" => "Rozmiar pliku przekracza maksymalny limit 3,5 MB.", "status" => false, "err_code" => "FileSize"));	
                echo $errorMSG;
            }
        }
        else
        {		
            $errorMSG = json_encode(array("message" => "Dany plik istnieje w bazie.", "status" => false, "err_code" => "FileExists"));	
            echo $errorMSG;
        }
    }
    else
    {		
        $errorMSG = json_encode(array("message" => "Dozwolony format pliku to: JPG, JPEG, PNG.", "status" => false, "err_code" => "FileExtention"));	
        echo $errorMSG;		
    }
}

?>