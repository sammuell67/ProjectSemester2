<!DOCTYPE html>
<html>
<head>
    <title>Zápočet 1</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="css/style2.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


</head>
<body>
<form id="selectForm" method="POST" action="">

    <input type="text" name="pole" id="pole" placeholder="Zadaj slovo"/>
    <input class="vyber" type="submit" value="Vygeneruj heslo">
</form>
<div>

</div>
</body>
</html>
<?php

$vstup = $_POST['pole'];


$vstup = str_replace("ľ", "2", $vstup);
$vstup = str_replace("š", "3", $vstup);
$vstup = str_replace("č", "4", $vstup);
$vstup = str_replace("ť", "5", $vstup);
$vstup = str_replace("ž", "6", $vstup);
$vstup = str_replace("ý", "7", $vstup);
$vstup = str_replace("á", "8", $vstup);
$vstup = str_replace("í", "9", $vstup);
$vstup = str_replace("é", "0", $vstup);


$vstup = str_replace("ň", "n", $vstup);
$vstup = str_replace("ä", "a", $vstup);
$vstup = str_replace("ô", "o", $vstup);
$vstup = str_replace("ú", "u", $vstup);



for ($x = 1; $x <= 100; $x+=2) {
    $vstup[$x] = strtoupper($vstup[$x]);
}
echo "<p> $vstup </p>";

?>