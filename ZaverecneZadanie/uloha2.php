<?php
session_start();
$idAdmina=$_SESSION['admin'];
if(!$_SESSION['admin']){
    header('location:uloha2_index.php');
}

// Set Language variable
if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];

    if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'> location.reload(); </script>";
    }
}

// Include Language file
if (isset($_SESSION['lang'])) {
    include "lang_" . $_SESSION['lang'] . ".php";
} else {
    include "lang_en.php";
}
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta content="text/html; charset=UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link rel="stylesheet" href="css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>

</head>
<body>
<script>
    function changeLang() {
        document.getElementById('form_lang').submit();
    }
</script>


<!-- Language -->

<form method='get' action='' id='form_lang' >
    <select class="uloha2 jazyk" name='lang' onchange='changeLang();' >
        <option value='en' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?> >English</option>
        <option value='sk' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'sk'){ echo "selected"; } ?> >Slovak</option>
    </select>
</form>
<div class='topnav'>
    <div class="logout">
<a href='uloha1_logout.php' role='button' ><?= _ODHLAS ?></a>
    </div>
</div>


<div class="uloha2">
    <form  class="uloha2" action="parser.php" method="get">
        <?= _ZR ?> <input type="text" class="uloha2" name="rok" id="rok" required="required"><br>
        <?= _ZP ?> <input type="text" class="uloha2" name="predmet" id="predmet" required="required"><br>
        <label for="file"><?= _WC ?></label>
        <input type="file"  class="uloha2" name="fileToUpload" accept=".csv"/>
        <br>
        <?= _ZO ?>
        <input type="radio" name="oddelovac" value=";" required="required">;
        <input type="radio" name="oddelovac" value="," required="required">,
        <input class="uloha2" type="submit">
    </form>
</div>
<!--<div class="col text-right"><a href="uloha2_logout.php"class="btn btn-info" role="button" >Odhlásiť</a> </div>-->
</body>
</html>

