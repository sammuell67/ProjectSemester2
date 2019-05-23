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
<div class='topnav'>
    <a href='uloha1_logout.php' role='button' >Odhlásiť</a>
</div>
<br>
<div class="uloha2_graf">
    <form action="teams.php" method="get">
         Číslo tímu: <input type="text" name="team"><br>
        <button type="submit" value="Submit">Pozri</button>
    </form>
</div>
<br>

</body>
</html>

<?php
session_start();
session_start();

if(!$_SESSION['admin']){
    header('location:uloha2_index.php');
}
$_SESSION['predmet'] = $_GET["predmet"];
$_SESSION['rok'] = $_GET["rok"];
$rok = $_GET["rok"];
$predmet = $_GET["predmet"];

$fileName = $_GET['fileToUpload'];

//$file = fopen($fileName, "r");
//chmod($file, 0777);


//echo $_GET["oddelovac"];
$ID = [];
$meno = [];
$email = [];
$heslo = [];
$tim = [];

$row = 1;
if (($handle = fopen($fileName, "r")) !== FALSE) {
    //chmod($handle, 0777);
    while (($data = fgetcsv($handle, 1000, $_GET["oddelovac"])) !== FALSE) {
        $num = count($data);
        array_push($ID,$data[0]);
        array_push($meno,$data[1]);
        array_push($email,$data[2]);
        array_push($heslo,$data[3]);
        array_push($tim,$data[4]);
        //echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c = 0; $c < $num; $c++) {
          //  echo $data[$c] . "<br />\n";
        }
    }

    fclose($handle);
}

include 'config.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

   //  sql to create table
//    $sql = "CREATE TABLE ULOHA2a (
//    id VARCHAR(50),
//    meno VARCHAR(50) ,
//    email VARCHAR(50) ,
//    heslo VARCHAR(300),
//    tim VARCHAR(50),
//    predmet VARCHAR(50),
//    body VARCHAR(50),
//    rok_predmetu VARCHAR(50)
//                    )";
//
//if ($conn->query($sql) === TRUE) {
//    echo "Table MyGuests created successfully";
//} else {
//    echo "Error creating table: " . $conn->error;
//}
$sql10 = mysqli_query($conn, "SELECT * FROM ULOHA2");
$boolean = false;
    for ($i = 0; $i <= $row-2; $i++) {
        $boolean = false;
        if($heslo[$i]!=""){
            $hash_pass = password_hash($heslo[$i], PASSWORD_BCRYPT, ['cost' => 12]);
        }
        else{
            $hash_pass="";
        }

        $sql10 = mysqli_query($conn, "SELECT * FROM ULOHA2");
        while($row300 = mysqli_fetch_array($sql10)){

            if($ID[$i]== $row300['id']&& $predmet== $row300['predmet'] && $rok==$row300['rok_predmetu']){
                $s = "UPDATE ULOHA2 SET email='$email[$i]',heslo='$hash_pass', tim='$tim[$i]',meno='$meno[$i]' WHERE predmet='$predmet' AND id='$ID[$i]' AND rok_predmetu='$rok'";
                $conn->query($s);
                $boolean = true;
            }

        }
        //echo $boolean;
        if($boolean != true) {
            $sql = "INSERT INTO ULOHA2 (id, meno, email, heslo, tim,predmet,body,suhlas,rok_predmetu)
        VALUES ('$ID[$i]', '$meno[$i]', '$email[$i]','$hash_pass','$tim[$i]','$predmet','','','$rok')";

            if ($conn->query($sql) === TRUE) {
                //echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

    }

$sql1 = mysqli_query($conn, "SELECT tim FROM ULOHA2 WHERE predmet='$predmet'  AND rok_predmetu='$rok'");
$sql2 = mysqli_query($conn, "SELECT COUNT(*) FROM ULOHA2");
$tim = mysqli_fetch_array($sql2);
$teams = [];
for ($k = 0; $k < (int)$tim[0] ; $k++) {
    while($rows[]=mysqli_fetch_array($sql1)) ;
    if(in_array($rows[$k][0],$teams)){

    }
    else{
        array_push($teams ,$rows[$k][0] );
    }

}

echo "<table class='blueTable'>";
echo "<th>Zoznam tímov v predmete : ".$predmet."  "."$rok</th>";
echo "</tr>";

foreach($teams as $item) {
    echo "<td>" .$item ."</td>";
    echo "</tr>";
}
echo "</table>";
$conn->close();
?>