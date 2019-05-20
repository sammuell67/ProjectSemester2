<?php

session_start();
require_once ('config.php');
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
<h2>Webové technológie 2</h2>

<form  method="post" action="uloha2_student.php">


<?php



$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql05 = mysqli_query($conn, "SELECT u2b.body FROM ULOHA2BODY u2b ,ULOHA2 u2 where u2b.tim = u2.tim and u2.id ='86139'"); //TODO prihlaseny student ked napojime prihlanie
$gv = mysqli_fetch_array($sql05);

$sql06 = mysqli_query($conn, "SELECT tim from ULOHA2 where id ='86139'"); //TODO prihlaseny student ked napojime prihlanie
$timcislo = mysqli_fetch_array($sql06);

echo "<h3>Group: " . $timcislo['tim'] . "</h3>";
echo "<h4>Group valuation: " . $gv['body'] . "</h4>";





$result = mysqli_query($conn, "SELECT * FROM ULOHA2a");
$sql3 = mysqli_query($conn, "SELECT * FROM ULOHA2a where id ='12345'");//TODO sem pojde id z prihlasenia
$bodyDB = mysqli_fetch_array($sql3);

$pom=0;
if(isset($_POST['Enabled'])) {

        $sql80 = "UPDATE ULOHA2a SET suhlas = 'suhlasim' WHERE id = '12345'";//TODO sem id z prihlasenia
        $conn->query($sql80);
        $pom=1;
    
}

if(isset($_POST['Disabled']))

{
    $sql81 = "UPDATE ULOHA2a SET suhlas = 'nesuhlasim' WHERE id = '12345'";//TODO sem id z prihlasenia
    $conn->query($sql81);
    $pom=1;


}

if(isset($_POST['rozdel'])) {

    $index=0;
while ($row = mysqli_fetch_array($result)) {

    $id=$row['id'];
    $body= $_POST['body'.$index];
    $sql8="UPDATE ULOHA2a SET body =$body WHERE id = $id";
     $conn->query($sql8);
    $index++;

}
    $result = mysqli_query($conn, "SELECT * FROM ULOHA2a");
    $sql3 = mysqli_query($conn, "SELECT * FROM ULOHA2a where id ='86139'");//sem pojde id z prihlasenia
    $bodyDB = mysqli_fetch_array($sql3);


}
if($bodyDB['body']==0){
    tabulkaPreZadanieBodov($conn);
}else{
    tabulkaPrePotvrdenieBodov($conn);
}

function tabulkaPreZadanieBodov($conn) {

    $result = mysqli_query($conn, "SELECT * FROM ULOHA2a");
    echo "<table class='blueTable'>";

    echo "<th>Email</th>";
    echo "<th>Full name</th>";
    echo "<th>Points</th>";
    echo "<th>Agree</th>";

    echo "</tr>";
    $index = 0;

    while ($row = mysqli_fetch_array($result)) {

        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['meno'] . "</td>";
        echo "<td><input type=\"text\" name=\"body$index\"></td>";
        echo "<td>" . $row['suhlas'] . "</td>";

        $index++;

        echo "</tr>";
    }
    echo "</table>";
}

function tabulkaPrePotvrdenieBodov($conn) {

    $result = mysqli_query($conn, "SELECT * FROM ULOHA2a");
    echo "<table class='blueTable'>";

    echo "<th>Email</th>";
    echo "<th>Full name</th>";
    echo "<th>Points</th>";
    echo "<th>Agree</th>";

    echo "</tr>";
    $index = 0;

    while ($row = mysqli_fetch_array($result)) {

        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['meno'] . "</td>";
        echo "<td>" . $row['body'] . "</td>";
        echo "<td>" . $row['suhlas'] . "</td>";

        $index++;

        echo "</tr>";
    }
    echo "</table>";
}





$conn->close();
?>


    <input type="submit" <?php echo $bodyDB; if($bodyDB['body']==0 )  {?> style="display: none" <?php } ?>  name="Enabled" value="Enabled"   >



    <input type="submit" <?php echo $bodyDB; if($bodyDB['body']==0 )   {?> style="display: none" <?php } ?>  name="Disabled" value="Disabled"    >



    <input type='submit'<?php echo $bodyDB; if($bodyDB['body']>0) {?> style="display: none" <?php } ?> name='rozdel' value='Rozdel body'  class="btn-close" >

</form>



</html>

