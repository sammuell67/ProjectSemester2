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
<div class='topnav'>
    <div class="logout">
        <a href='uloha1_logout.php' role='button' >Odhlásiť</a>
    </div>
</div>


<form  method="post" action="uloha2_student.php"  >

    <?php
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $idPrihlasenhoStudenta=$_SESSION['student'];

    $sq50 = mysqli_query($conn, "SELECT * FROM ULOHA2 where id =$idPrihlasenhoStudenta");
    echo "Študentové predmety:";
    while ($rowPredmety = mysqli_fetch_array($sq50 )) {
        echo $rowPredmety['predmet']." ";
    }
    ?>
    <br>
    <br>
    Vyber predmet ktorý chceš vidieť:
    <input name="idTemplate" type="text">
    <br>

    <input name="template" type="submit" value=Potvrď>

<?php



$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$idPrihlasenhoStudenta=$_SESSION['student'];
if(!$_SESSION['student']){
    header('location:uloha2_index.php');
}


function hlavicka($conn,$idPrihlasenhoStudenta,$predmet){
    $sql06 = mysqli_query($conn, "SELECT tim from ULOHA2 where id =$idPrihlasenhoStudenta"); //TODO prihlaseny student ked napojime prihlanie
    $timcislo = mysqli_fetch_array($sql06);
    $cisloTimu = $timcislo['tim'];
    $sql05 = mysqli_query($conn, "SELECT u2b.body FROM ULOHA2BODY u2b ,ULOHA2 u2 where u2b.tim = u2.tim and u2.id =$idPrihlasenhoStudenta and u2.predmet='$predmet'"); //TODO prihlaseny student ked napojime prihlanie
    $bodyCelkovo = mysqli_fetch_array($sql05);
    echo "<h3>Číslo tímu: " . $timcislo['tim'] . "</h3>";
    echo "<h4>Body pre tím: " . $bodyCelkovo['body'] . "</h4>";
}

if (isset($_POST['template'])) {
    $predmet1 = $_POST['idTemplate'];
    //$predmet1=$predmet;


    $sq50 = mysqli_query($conn, "SELECT * FROM ULOHA2 where id =$idPrihlasenhoStudenta");
   $counter=0;
    while ($rowPredmety = mysqli_fetch_array($sq50 )) {
       if( $rowPredmety['predmet']==$predmet1){
           $counter++;
       }
    }
   if($counter==0){
       $message = "Student nema tento predmet";
       echo "<script type='text/javascript'>alert('$message');</script>";

   }else {
       $_SESSION['predmet'] = $predmet1;
       $cislo = 20;
       $pom = 1;
       $_SESSION['pom'] = $pom;
       $sql05 = mysqli_query($conn, "SELECT u2b.body FROM ULOHA2BODY u2b ,ULOHA2 u2 where u2b.tim = u2.tim and u2.id =$idPrihlasenhoStudenta and u2.predmet='$predmet1'"); //TODO prihlaseny student ked napojime prihlanie
       $bodyCelkovo = mysqli_fetch_array($sql05);



       $sql3 = mysqli_query($conn, "SELECT * FROM ULOHA2 where id =$idPrihlasenhoStudenta and predmet='$predmet1'");//TODO sem pojde id z prihlasenia
       $bodyDB = mysqli_fetch_array($sql3);


       $sql06 = mysqli_query($conn, "SELECT tim from ULOHA2 where id =$idPrihlasenhoStudenta and predmet='$predmet1'"); //TODO prihlaseny student ked napojime prihlanie
       $timcislo = mysqli_fetch_array($sql06);
       $cisloTimu = $timcislo['tim'];

       hlavicka($conn, $idPrihlasenhoStudenta, $predmet1);

       if (!$bodyDB['body']) {
           tabulkaPreZadanieBodov($conn, $cisloTimu, $predmet1);
       } else {
           tabulkaPrePotvrdenieBodov($conn, $cisloTimu, $predmet1);
       }
   }
}

$predmet1=$_SESSION['predmet'];
$sql05 = mysqli_query($conn, "SELECT u2b.body FROM ULOHA2BODY u2b ,ULOHA2 u2 where u2b.tim = u2.tim and u2.id =$idPrihlasenhoStudenta and u2.predmet='$predmet1'"); //TODO prihlaseny student ked napojime prihlanie
$bodyCelkovo = mysqli_fetch_array($sql05);

$sql3 = mysqli_query($conn, "SELECT * FROM ULOHA2 where id =$idPrihlasenhoStudenta and predmet='$predmet1'");//TODO sem pojde id z prihlasenia
$bodyDB = mysqli_fetch_array($sql3);

$sql06 = mysqli_query($conn, "SELECT tim from ULOHA2 where id =$idPrihlasenhoStudenta and predmet='$predmet1'" ); //TODO prihlaseny student ked napojime prihlanie
$timcislo = mysqli_fetch_array($sql06);
$cisloTimu = $timcislo['tim'];

$sql69 = mysqli_query($conn, "SELECT suhlas from ULOHA2 where id =$idPrihlasenhoStudenta and predmet='$predmet1'"); //TODO prihlaseny student ked napojime prihlanie
$suhlas = mysqli_fetch_array($sql69);
$suhlasStudenta=$suhlas['suhlas'];



if (isset($_POST['Enabled'])) {

    $sql80 = "UPDATE ULOHA2 SET suhlas = 'suhlasim' WHERE id = $idPrihlasenhoStudenta and predmet='$predmet1'";//TODO sem id z prihlasenia
    $conn->query($sql80);
    $odstranBtn =1;
    hlavicka($conn,$idPrihlasenhoStudenta,$predmet1);
    tabulkaPrePotvrdenieBodov($conn, $cisloTimu, $predmet1);

}

if (isset($_POST['Disabled'])) {
    $sql81 = "UPDATE ULOHA2 SET suhlas = 'nesuhlasim' WHERE id = $idPrihlasenhoStudenta and predmet='$predmet1'";//TODO sem id z prihlasenia
    $conn->query($sql81);
    $odstranBtn =1;
    hlavicka($conn,$idPrihlasenhoStudenta,$predmet1);
    tabulkaPrePotvrdenieBodov($conn, $cisloTimu, $predmet1);
}

if(isset($_POST['rozdel'])) {

    $nezadalVsetko=0;
    $index=0;
    $sucetBodov=0;
    $predmet2=$_SESSION['predmet'];
    $result88 = mysqli_query($conn, "SELECT * FROM ULOHA2 where tim=$cisloTimu and predmet='$predmet2'");

    $sql05 = mysqli_query($conn, "SELECT u2b.body FROM ULOHA2BODY u2b ,ULOHA2 u2 where u2b.tim = u2.tim and u2.id =$idPrihlasenhoStudenta and u2.predmet='$predmet2'"); //TODO prihlaseny student ked napojime prihlanie
    $bodyCelkovo = mysqli_fetch_array($sql05);



    while ($row = mysqli_fetch_array($result88)) {

        if(!$_POST['body'.$index]){


            if (!$bodyDB['body']) {
                $nezadalVsetko=1;
            }
        }
        $body= $_POST['body'.$index];


        $sucetBodov+=$body;
        $index++;

    }


    if($sucetBodov==$bodyCelkovo['body'] && $nezadalVsetko==0) {
        $result = mysqli_query($conn, "SELECT * FROM ULOHA2 where tim=$cisloTimu and predmet='$predmet2'");

        $index=0;
        while ($row = mysqli_fetch_array($result)) {

            $id = $row['id'];
            $body = $_POST['body' . $index];
            $sql8 = "UPDATE ULOHA2 SET body =$body WHERE id = $id and predmet='$predmet2'";
            $conn->query($sql8);
            $index++;

        }
        $result = mysqli_query($conn, "SELECT * FROM ULOHA2 where id =$idPrihlasenhoStudenta and predmet='$predmet2'");
        $sql3 = mysqli_query($conn, "SELECT * FROM ULOHA2 where id =$idPrihlasenhoStudenta and predmet='$predmet2'");//sem pojde id z prihlasenia
        $bodyDB = mysqli_fetch_array($sql3);
        hlavicka($conn,$idPrihlasenhoStudenta,$predmet2);
        tabulkaPrePotvrdenieBodov($conn, $cisloTimu, $predmet1);

    }else{
        $message = "Zlý súčet bodov, alebo si nedal body každému";
        echo "<script type='text/javascript'>alert('$message');</script>";
        hlavicka($conn,$idPrihlasenhoStudenta,$predmet2);
        if (!$bodyDB['body']) {
            tabulkaPreZadanieBodov($conn, $cisloTimu,$predmet1);} else {
            tabulkaPrePotvrdenieBodov($conn, $cisloTimu,$predmet1);
        }
    }




}




function tabulkaPreZadanieBodov($conn,$cisloTimu,$predmet) {

    $result = mysqli_query($conn, "SELECT * FROM ULOHA2 where tim='$cisloTimu' AND predmet ='$predmet'");
    echo "<table class='blueTable'>";




    echo "<th>Email</th>";
    echo "<th>Meno</th>";
    echo "<th>Body</th>";
    /*echo "<th>Súhlas</th>";*/

    echo "</tr>";
    $index = 0;


    while ($row = mysqli_fetch_array($result)) {

        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['meno'] . "</td>";
        echo "<td><input type=\"number\" name=\"body$index\"   id=\"zadaneBody\" rmin='0' step='1'></td>";
      /*  if($row['suhlas'] == 'suhlasim') {
            echo "<td>" . "&#128077" . "</td>";
        }
        else if ($row['suhlas'] == 'nesuhlasim'){
            echo "<td>" . "&#128078" . "</td>";
        }
*/
        $index++;

        echo "</tr>";
    }
    echo "</table>";
}



function tabulkaPrePotvrdenieBodov($conn,$cisloTimu,$predmet) {

    $result = mysqli_query($conn, "SELECT * FROM ULOHA2 where tim='$cisloTimu' AND predmet = '$predmet' ");
    echo "<table class='blueTable'>";

    echo "<th>Email</th>";
    echo "<th>Meno</th>";
    echo "<th>Body</th>";
    echo "<th>Súhlas</th>";

    echo "</tr>";
    $index = 0;



    while ($row = mysqli_fetch_array($result)) {

        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['meno'] . "</td>";
        echo "<td>" . $row['body'] . "</td>";
        if($row['suhlas'] == 'suhlasim') {
            echo "<td>" . "&#128077" . "</td>";
        }
        else if ($row['suhlas'] == 'nesuhlasim'){
            echo "<td>" . "&#128078" . "</td>";
        }

        $index++;

        echo "</tr>";
    }
    echo "</table>";
}




$conn->close();
?>

    <input type="submit"  onclick="return confirm('Si si istý?')" " <?php  if(!$bodyDB['body'] || $odstranBtn==1 || $suhlas['suhlas'] ){?> style="display: none" <?php }?>  name="Enabled" value="Suhlasim" >
    <input type="submit"  onclick="return confirm('Si si istý?')"" <?php if(!$bodyDB['body'] || $odstranBtn==1 || $suhlas['suhlas'])   {?> style="display: none" <?php } ?>  name="Disabled" value="Nesuhlasim"  >
    <input type='submit'  <?php $pom=$_SESSION['pom']; if($bodyDB['body']||$pom!=1) {?> style="display: none" <?php } ?> name='rozdel' value='Rozdel body'  class="btn-close" >

</form>
</div>







</html>

