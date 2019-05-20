<!DOCTYPE html>
<html lang="en">
<head>
    <title>Zapocet</title>
    <meta charset="UTF-8">
    <style>
        .hilight{
            color:red;
            background-color: #3b99fc;
            font-weight: bold;
        }
    </style>

</head>
<body>
<form  method="post">
    URL adresa <input type="text" name="url" id="url"><br>
    Hladany text<input type="text" name="text" id="text"><br>
    <input type="submit" value="Submit" name="Submit">
</form>


<?php
$url = $_POST['url'];
$text = $_POST['text'];
$file = file_get_contents($url);
$counter = 0;


function highlight($text='', $word='')
{
    if(strlen($text) > 0 && strlen($word) > 0)
    {
        return (str_ireplace($word, "<span class='hilight'>{$word}</span>", $text));
    }
    return ($text);
}

$file = highlight($file,$text);
echo $file;


?>

</body>
</html>