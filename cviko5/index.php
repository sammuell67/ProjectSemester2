<!DOCTYPE html>
<html>
<?php

include_once "function.php";
?>
<head>
    <title>Zadanie 5</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
          integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>
<body class="bgc">
<div class="container">

    <form action="index.php" method="POST">

        <select name="typ" id="typ" name="typ">
            <option value="1">BP</option>
            <option value="2">DP</option>
        </select>


        <select name="ustav" id="ustav" name="ustav">
            <option value="642">Ústav automobilovej mechatroniky</option>
            <option value="548">Ústav elektroenergetiky a aplikovanej elektrotechniky</option>
            <option value="549">Ústav elektroniky a fotoniky</option>
            <option value="550">Ústav elektrotechniky</option>
            <option value="816">Ústav informatiky a matematiky</option>
            <option value="817">Ústav jadrového a fyzikálneho inžinierstva</option>
            <option value="818">Ústav multimediálnych informačných a komunikačných technológií</option>
            <option value="356">Ústav robotiky a kybernetiky</option>
        </select>

        <input type="submit" name="Login" class="" value="Send">
        <br>

        <input type="radio" name="radio" value="volne" checked="true"> Volne<br>
        <input type="radio" name="radio" value="obsadene"> Obsadene<br>

    </form>


    <?php
    if (isset($_POST['Login'])) {

        $result = $_POST['typ'];
        $id_prac = $_POST['ustav'];
        $radio = $_POST['radio'];

        getData($result,$radio,$id_prac);

    }
    ?>


</div>
<script src="script.js"></script>
</body>
</html>
