<?php
session_start();
require_once ('config.php');
if (isset($_POST['LDAP_btn'])) {
    $adServer = "ldap.stuba.sk";

    $dn  = 'ou=People, DC=stuba, DC=sk';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $ldaprdn  = "uid=$username, $dn";

    $ldapconn = ldap_connect($adServer);
    ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);


    $bind = ldap_bind($ldapconn, $ldaprdn, $password);
    if ($bind){

        $results=ldap_search($ldapconn,$dn,"uid=$username",array("givenname","sn","mail","cn","uisid","uid"));
        $info=ldap_get_entries($ldapconn,$results);
        $i=0;
        $aisUdaje = array("Meno"=>$info[$i]['givenname'][0],
            "Priezvisko"=>$info[$i]['sn'][0],
            "Používateľské meno"=>$info[$i]['uid'][0],
            "Id"=>$info[$i]['uisid'][0],
            "Email"=>$info[$i]['mail'][0]);
        $ISid= $info[$i]['uisid'][0];
        $meno=$info[$i]['givenname'][0];
        $priezvisko=$info[$i]['sn'][0];
        $email=$info[$i]['mail'][0];
        //$login=$info[$i]['uid'][0];


//$conn->close;
//$_SESSION['meno']=$info[$i]['uid'][0];
// $_SESSION['email']=$info[$i]['mail'][0];
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";

        $date_clicked = date('Y-m-d H:i:s');
        $ldap_login = "LDAP";
        $_SESSION['student'] = $ISid;
        //$sql8="INSERT INTO ULOHA (log_uz,cas,sposob_prihl) VALUES ('$username','$date_clicked', '$ldap_login')";
       // $conn->query($sql8);
        header('location:uloha2_student.php');

        /*$query2 = "SELECT * FROM prihlasenia WHERE login='$username' AND type_login='$ldap_login'";
        $result2 = mysqli_query($db, $query2);
        //$vysledok = mysqli_fetch_assoc($result2);
        //$result2 = $conn->query($query2);
        while ($riadok = mysqli_fetch_assoc($result2)) {
        $vysledok[] = $riadok;
        }
        $_SESSION['result'] = $vysledok;*/

    }
    else {
        echo "Zle prihlasovacie udaje";
    }

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



</div>

<form method="post"  action="uloha2_LDAP.php">
    <div class="box">
        <h1>LDAP Login</h1>


        <input type="text"  name="username" placeholder="LDAP login" class="email" />

        <input type="password" name="password" placeholder="Password" class="email" />


        <input type="submit" class="btn" name="LDAP_btn" value="prihlas">
        <div class="pad">
            <div class="col text-center">


                <a href="uloha2_index.php" class="btn btn-info" role="button">LDAP Login</a>

            </div>
        </div>

    </div> <!-- End Box -->

</form>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>

</html>
