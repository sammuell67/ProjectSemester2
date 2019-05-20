<html>
<body>

<form action="teams.php" method="get">
     Číslo tímu: <input type="text" name="team"><br>
    <button type="submit" value="Submit">Pozri</button>
</form>

</body>
</html>

<?php
session_start();
$_SESSION['predmet'] = $_GET["predmet"];
echo $_GET["rok"];
$predmet = $_GET["predmet"];
//echo $_GET["oddelovac"];
$ID = [];
$meno = [];
$email = [];
$heslo = [];
$tim = [];

$row = 1;
if (($handle = fopen("test2.csv", "r")) !== FALSE) {
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
//print_r($ID);
//print_r($meno);
//print_r($email);
//print_r($heslo);
//print_r($tim);
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
//    body VARCHAR(50)
//                    )";
//
//if ($conn->query($sql) === TRUE) {
//    echo "Table MyGuests created successfully";
//} else {
//    echo "Error creating table: " . $conn->error;
//}
    for ($i = 0; $i <= $row-2; $i++) {
        $hash_pass = password_hash($heslo[$i], PASSWORD_BCRYPT, ['cost' => 12]);
        $sql = "INSERT INTO ULOHA2 (id, meno, email, heslo, tim,predmet,body,suhlas)
        VALUES ('$ID[$i]', '$meno[$i]', '$email[$i]','$hash_pass','$tim[$i]','$predmet','','')";

        if ($conn->query($sql) === TRUE) {
            //echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

$sql1 = mysqli_query($conn, "SELECT tim FROM ULOHA2 ");
$sql2 = mysqli_query($conn, "SELECT COUNT(*) FROM ULOHA2 ");
$tim = mysqli_fetch_array($sql2);
$teams = [];
for ($k = 0; $k < (int)$tim[0] ; $k++) {
    while($rows[]=mysqli_fetch_array($sql1)) ;
    array_push($teams ,$rows[$k][0] );
}
$teams = array_unique($teams);

echo nl2br ("Zoznam timov : ". "\n");
foreach($teams as $item) {
    echo nl2br ($item . "\n");
}
$conn->close();
?>