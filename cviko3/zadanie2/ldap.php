<!DOCTYPE html>
<html lang="sk">
<head>
    <title>Dochádzka </title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <link rel="stylesheet" href="css/style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

</head>
<body>

<div>
    <div class="btns">

        <a id="reg" href="index.php">Registracia</a>
        <a id="log" href="login.php" class="active">Prihlásenie</a>
    </div>


    <div class="wrapper">
        <div class="references">
            <a href="index1.php">Google</a>
            <a href="ldap.php">LDAP</a>
            <a href="login.php">App</a>
        </div>
        <form class="form-style-7" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1>Prihlásenie</h1>
            <ul>
                <li>
                    <label for="login">Login</label>
                    <input type="text" name="login" maxlength="100">
                </li>
                <li>
                    <label for="pass">Heslo</label>
                    <input type="password" name="pass">
                </li>
                <li>
                    <input type="submit" value="Poslať">
                    <span class="wrong">Wrong login or password.Try again</span>
                </li>
            </ul>
        </form>
    </div>
</div>
<?php


require __DIR__ . '/config.php';

//tu su veci co si posielas z toho,co zadava user
$login = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $login = test_input($_POST["login"]);
    $pass = test_input($_POST["pass"]);


}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$acces = false;


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$ldap_server = "ldap.stuba.sk";

if (($pass AND $login) != "") {
    if ($connect = @ldap_connect($ldap_server)) { // if connected to ldap server

        ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);


        // bind to ldap connection
        if (($bind = @ldap_bind($connect)) == false) {
            print "bind:__FAILED__<br>\n";
            echo "bad";
        }

        // search for user
        if (($res_id = ldap_search($connect,
                "dc=stuba, dc=sk",
                "uid=$login")) == false
        ) {
            print "failure: search in LDAP-tree failed<br>";
            echo "bad";
        }

        if (ldap_count_entries($connect, $res_id) != 1) {
            print "failure: username $login found more than once<br>\n";
            echo "bad";
        }

        if (($entry_id = ldap_first_entry($connect, $res_id)) == false) {
            print "failur: entry of searchresult couln't be fetched<br>\n";
            echo "bad";
        }

        if (($user_dn = ldap_get_dn($connect, $entry_id)) == false) {
            print "failure: user-dn coulnd't be fetched<br>\n";
            echo "bad";
        }

        /* Authentifizierung des User */
        if (($link_id = ldap_bind($connect, $user_dn, $pass)) == false) {
            print "failure: username, password didn't match: $user_dn<br>\n";
            echo "bad";

        } else {
            $visit = "SELECT Datum FROM Prihlasenie WHERE Login ='$login' AND ID_typ=2";
            $visited = $conn->query($visit);
            echo '<style type="text/css">
            .wrapper {
                display:none;
            }
            </style>';
            /*$A="SELECT COUNT(ID_typ) AS 'pocet' FROM Prihlasenie WHERE ID_typ='$typ' ";*/
            $A = "SELECT Datum,Login FROM Prihlasenie WHERE ID_typ='1' ";
            $B = "SELECT Datum,Login FROM Prihlasenie WHERE ID_typ='2' ";
            $C = "SELECT Datum,Login FROM Prihlasenie WHERE ID_typ='3' ";
            $poceta = $conn->query($A);
            $pocetb = $conn->query($B);
            $pocetc = $conn->query($C);
            //$pocetA = $A->fetch_assoc() ;
            //echo  $pocetA['pocet'];
            $pocetA = $poceta->fetch_assoc();
            $acount = mysqli_num_rows($poceta);
            $bcount = mysqli_num_rows($pocetb);
            $ccount = mysqli_num_rows($pocetc);
            echo '<br/><br/> <a href="logout.php">Logout</a> <br/><br/>';

            echo '<div class="result">';

            echo '<h5>Prihlásený uživateľ: </h5>' . $login;
            echo '<h5>Typ prihlásenia:</h5>' . "LDAP";

            echo '<h5>Počet prihláseni cez App<h5>' . $acount;
            echo '<h5>Počet prihláseni cez LDAP<h5>' . $bcount;
            echo '<h5>Počet prihláseni cez Google<h5>' . $ccount;
            echo '<h5>História prihlásenia :</h5>';
            while ($riadok = $visited->fetch_assoc()) {

                echo $riadok['Datum'] . '<br>';
            }
            echo "</div>";
            $datum = date("Y-m-d H:i:s");
            $typ = "LDAP";
            $in = "INSERT INTO Prihlasenie (Login,ID_typ,Datum) VALUES ('$login','$typ','$datum')";

            if ($conn->query($in) === TRUE) {

            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

        }

    }
} else {
    echo "";
}
$conn->close();
//end do insert
?>