<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Title</title>
</head>

<?php
if (isset($_FILES['image'])) {
    $errors = array();
    chmod($file, 0777);
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));

    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "Vyber len JPEG obrazok.";
    }

    if ($file_size > 2097152) {
        $errors[] = 'File size must be excately 2 MB';
    }

    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, "images/" . $file_name);
    } else {
        print_r($errors);
    }
}
$directory = "/cviko1/z2/images/";
$files = glob("images/*.*");



for ($i = 0; $i < count($files); $i++) {

    $file_name = $_FILES['image']['name'];
    $image = $files[$i];
    $pomoc= substr($image,7);
    $filename = $pomoc;
    $without_extension = pathinfo($filename, PATHINFO_FILENAME);
    $final =  ucfirst($without_extension);
    echo "<a onclick='toggle_visibility($i)' >";

    echo $pomoc;

    echo "<img id=$i style='display : none' src='$directory$pomoc'/> <br/>";

    echo "<a id='label.$i' style='visibility:hidden'> $final";


    echo '<br />';
}

?>

<html>
<body>

<form style="visibility: visible" action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="image"/>
    <input type="submit"/>
</form>


</body>
</html>
<script type="text/javascript">
    <!--
    function toggle_visibility(id) {

        var e = document.getElementById(id);

        if (e.style.display == 'block')
        {
            setName("label." + id);
            e.style.display = 'none';

        }
        else {
            e.style.display = 'block';
            setName("label." + id);
        }
    }

    function setName(name){
        var element = document.getElementById(name);

        if (element.style.visibility == 'visible')
            element.style.visibility = 'hidden';
        else
            element.style.visibility = 'visible';

    }

    //-->
</script>

