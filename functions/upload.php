<?php
/*****
*
* It's a function for uploading product Image.
* uploadOk = '1' Upload successful .
* uploadOk = '2' File is not an image.
* uploadOk = '3' File is too large.
* uploadOk = '4' File type is not allowed.
* uploadOk = '5' There was an unknown error uploading your file.
*
*****/
$target_dir = dirname(__FILE__)."/../img/product_img/";
$imageFileType = pathinfo($_FILES["product_photo"]["name"],PATHINFO_EXTENSION);
$file_name = md5(basename($_FILES["product_photo"]["name"])).'.'.$imageFileType;
$target_file = $target_dir . $file_name;

$check = getimagesize($_FILES["product_photo"]["tmp_name"]);
if($check != false) { // Check if image file is a actual image or fake image

    // Check if file already exists
    $i=1;
     while(file_exists($target_file)){         
             $file_name = md5(basename($target_file).$i).'.'.$imageFileType;
             $target_file = $target_dir . $file_name;
             $i++;
     }


    if ($_FILES["product_photo"]["size"] > 5000000) $uploadOk = '3'; // Check file size

    else{
        // Allow certain file formats
        if($imageFileType != "jpg"  && $imageFileType != "png" && $imageFileType != "jpeg"  && $imageFileType != "gif" ) $uploadOk = '4';

        else{
            if (move_uploaded_file($_FILES["product_photo"]["tmp_name"], $target_file)) {
                $uploadOk = '1';
            } 
            else $uploadOk = '5';
        }
        }

} else {
    $uploadOk = 2;
}
?>