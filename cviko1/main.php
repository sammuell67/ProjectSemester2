<?php

$target="uploads/";

if($_FILES["fileToUpload"]["name"]) {

    $file = $_FILES["fileToUpload"];
    chmod($file,0777);
    $filename = $file["name"];
    $array = explode('.', basename($_FILES["fileToUpload"]["name"]));
    $ext = end($array);
    $fileName =$_GET['$fileName'];
    $newname = $fileName.$ext;
    $tmp_name = $file["tmp_name"];
    $targetzip = $target.$newname;

    if(move_uploaded_file($tmp_name, $targetzip)) {
        echo "Uploaded complete";
    }
    else echo "No uploaded";

}
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

?>