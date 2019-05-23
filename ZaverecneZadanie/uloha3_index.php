<?php

session_start();
require_once ('config.php');

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
if(isset($_POST['login_btn'])) {

    $login = $_POST['aisid'];
    $password = $_POST['password'];
    $hash_pass = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
    //$sql="SELECT COUNT(*) as pocet FROM users where login='$login'";
    //$stmt = $conn->prepare("SELECT * FROM Student_uloha2 where meno=:ID ");
    //$stmt = $conn->prepare("SELECT * FROM Login where ID=:ID ");
    $stmt = $conn->prepare("SELECT * FROM Admin where login=:login ");
    $stmt->execute(array(':login' => $login));


    $row = $stmt->fetch();
    if($row) {
        if (password_verify($password,$row['password'])) {


            // $today=date("Y-m-d H:i:s");
            // $sql3="INSERT INTO login(sposob_prihl,log_uz,cas) VALUES ('registracia', '$login','$today')";
            // $conn->query($sql3);
            $_SESSION['admin3'] = $login;
            header('location:passGenerator.php');
        }else{
            echo "Your pass  is incorrec";
        }
    }else{
        echo "Your name  is incorrec";
    }


}

?>

<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
</head>
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

<form method="post"  action="uloha3_index.php">
    <div class="box">
        <h1><?= _PRIHL ?></h1>



        <input type="text"  name="aisid" placeholder="login" class="email" />

        <input type="password" name="password" placeholder="Password" class="email" />


        <input type="submit" class="btn" name="login_btn" value=<?= _SAD ?>>



    </div>

</form>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>

</html>
