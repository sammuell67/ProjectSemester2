<?php

session_start();
require_once ('config.php');

if(isset($_POST['login_btn'])) {

    $ID = $_POST['aisid'];
    $password = $_POST['password'];
    $hash_pass = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
    //$sql="SELECT COUNT(*) as pocet FROM users where login='$login'";
    //$stmt = $conn->prepare("SELECT * FROM Student_uloha2 where meno=:ID ");
    //$stmt = $conn->prepare("SELECT * FROM Login where ID=:ID ");
    $stmt = $conn->prepare("SELECT * FROM Student_uloha2 where meno=:ID ");
    $stmt->execute(array(':ID' => $ID));


    $row = $stmt->fetch();
    echo $row['id'];
   /* if (isset($_POST['checkboxik'])){
        $stmt = $conn->prepare("SELECT * FROM LoginAdmin where ID=:ID ");
        $stmt->execute(array(':ID' => $ID));
        $row = $stmt->fetch();
        if ($row) {
            if (password_verify($password,$row['heslo'])) {
                $_SESSION['message'] = "You are now logged in";
                $_SESSION['ID'] = $ID;
                // $today=date("Y-m-d H:i:s");
                // $sql3="INSERT INTO login(sposob_prihl,log_uz,cas) VALUES ('registracia', '$login','$today')";
                // $conn->query($sql3);
                header('location:admin.php');
            }else{
                echo "Your pass  is incorrec";
            }
        }else{
            echo "Your name  is incorrec";
        }
    }*/
    /*if($row) {
       // if (password_verify($password,$row['heslo'])) {
        if($row['heslo']==$password){
            $_SESSION['message'] = "You are now logged in";
            $_SESSION['meno'] = $ID;
            // $today=date("Y-m-d H:i:s");
            // $sql3="INSERT INTO login(sposob_prihl,log_uz,cas) VALUES ('registracia', '$login','$today')";
            // $conn->query($sql3);
            header('location:student.php');
        }else{
            echo "Your pass  is incorrec";
        }
    }else{
        echo "Your name  is incorrec";
    }
*/

}

?>

<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
</head>

<form method="post"  action="U2_index.php">
    <div class="box">
        <h1>Login</h1>

        Prihlásanie ako admin
        <label class="switch">
            <input name="checkboxik" type="checkbox" >
            <span class="slider round"></span>
        </label>

        <input type="text"  name="aisid" placeholder="AIS ID" class="email" />

        <input type="password" name="password" placeholder="Password" class="email" />


        <input type="submit" class="btn" name="login_btn" value="Sign in">


    </div> <!-- End Box -->
    <p>FEKERE</p>
</form>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>

</html>
