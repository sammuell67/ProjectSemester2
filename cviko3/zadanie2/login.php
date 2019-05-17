<!DOCTYPE html>
<html lang = "sk">
<head>
    <title>Login </title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <link rel="stylesheet" href="css/style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

</head>
<body>

<div>
<div class="btns">

    <a id="reg" href="index.php" >Registracia</a>
   <a id="log" href="login.php" class="active">Prihlásenie</a>
</div>



    <div class="wrapper">

            <div class="references">
                <a href="index1.php">Google</a>
                <a href="ldap.php">LDAP</a>
                <a href="login.php">App</a>

            </div>
        <form class="form-style-7" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

            <h1>Prihlásenie</h1>
            <ul>

                <li>
                    <label for="login">Login</label>
                    <input type="text" name="login" maxlength="100">
                    <!--                <span>Your website address (eg: http://www.google.com)</span>
                    -->         </li>
                <li>
                    <label for="pass">Heslo</label>
                    <input type="password" name="pass" >
                    <!--                <span>Say something about yourself</span>
    -->            </li>
                <li>
                    <input type="submit" value="Poslať" >
                    <span class="wrong">Wrong login or password.Try again</span>
                </li>
            </ul>
        </form>
    </div>
</div>
<?php


include_once 'gpConfig.php';
require __DIR__.'/config.php';
 $email = $login = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $email = test_input($_POST["email"]);
    $login = test_input($_POST["login"]);
    $pass = test_input($_POST["pass"]);


}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$typ="Registracia";
//echo $epass;
$datum =  date("Y-m-d H:i:s");;


$succes=false;
if ($login=="" || $pass=="") {

    die();
}
else{
    $sql = "SELECT Login,Heslo FROM Uzivatelia WHERE Login = '$login' ";
    $log="INSERT INTO Prihlasenie (Login,ID_typ,Datum) VALUES ('$login','$typ','$datum')";
        $result = $conn->query($sql);


        $visit = "SELECT Datum FROM Prihlasenie WHERE Login ='$login' AND ID_typ='$typ'";
        $visited = $conn->query($visit);

        while ($rowsec = $result->fetch_assoc()) {
            $konpass = $rowsec['Heslo'];
            $konlogi = $rowsec['Login'];
            if ($login == $rowsec['Login'] && password_verify($pass, $rowsec['Heslo'])) {

                $succes = true;
                echo '<style type="text/css">
            .wrapper {
               display:none;
            }
            </style>';
                /*$A="SELECT COUNT(ID_typ) AS 'pocet' FROM Prihlasenie WHERE ID_typ='$typ' ";*/
                $A="SELECT Datum,Login FROM Prihlasenie WHERE ID_typ='Registracia' ";
                $B="SELECT Datum,Login FROM Prihlasenie WHERE ID_typ='LDAP' ";
                $C="SELECT Datum,Login FROM Prihlasenie WHERE ID_typ='Google' ";
                $poceta = $conn->query($A);
                $pocetb = $conn->query($B);
                $pocetc = $conn->query($C);
                //$pocetA = $A->fetch_assoc() ;
                //echo  $pocetA['pocet'];
                $pocetA = $poceta->fetch_assoc();
                $acount=mysqli_num_rows($poceta);
                $bcount=mysqli_num_rows($pocetb);
                $ccount=mysqli_num_rows($pocetc);

                echo '<div class="result">';
                echo '<br/><br/> <a href="logout.php">Logout</a> <br/><br/>';

                echo '<h5>Prihlásený uživateľ: </h5>' . $login;
                echo '<h5>Typ prihlásenia:</h5>' . "App";

                echo '<h5>Počet prihláseni cez App<h5>'.$acount;
                echo '<h5>Počet prihláseni cez LDAP<h5>'.$bcount;
                echo '<h5>Počet prihláseni cez Google<h5>'.$ccount;
                echo '<h5>História prihlásenia :</h5>';

                while($riadok=$visited->fetch_assoc()){

                    echo  $riadok['Datum'].'<br>';
                }
                echo "</div>";



                    if ($conn->query($log) === TRUE) {

                    } else {
                        echo "Error: " . $log . "<br>" . $conn->error;
                    }

                //echo "New record created successfully";
                ////echo $result;
                //echo $pass;
                echo '<div class="result">';


                echo "</div>";

            } else {
                echo '<style type="text/css">
            .wrong {
               visibility:visible;
            }
            </style>';
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }



$conn->close();
?>

</body>
</html>