<?php
session_start();
$body = $_GET["body"];
$word = $_SESSION['word'];
$predmet = $_SESSION['predmet'];
$rok = $_SESSION['rok'];

include 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//  sql to create table
//    $sql = "CREATE TABLE ULOHA2BODY (
//    predmet VARCHAR(50),
//    tim VARCHAR(50) ,
//    body VARCHAR(50),
//    rok_predmetu VARCHAR(50)
//                    )";

//if ($conn->query($sql) === TRUE) {
//    echo "Table MyGuests created successfully";
//} else {
//    echo "Error creating table: " . $conn->error;
//}
$data1 ="https://147.175.121.210:4461/cviko1/ZaverecneZadanie/teams.php?team=";
$data2 = $word;
$result = $data1 . '' . $data2;
$sql2 = mysqli_query($conn, "SELECT * FROM ULOHA2BODY ");
while($row = mysqli_fetch_array($sql2)){
    if($row['predmet'] == $predmet && $row['tim'] == $word && $row['rok_predmetu'] == $rok){
        $sql = "UPDATE ULOHA2BODY SET body='$body' WHERE predmet='$predmet' AND tim='$word' AND rok_predmetu='$rok'";
        mysqli_query($conn, $sql);
        echo "<script type='text/javascript'>spge = '<?php echo $word ;?>';
            window.location.href = '$result';
            </script>";
        exit();
    }
}

$sql = "INSERT INTO ULOHA2BODY (predmet, tim,body,suhlas_admin,rok_predmetu)
        VALUES ('$predmet', '$word', '$body','','$rok')";

if ($conn->query($sql) === TRUE) {

    echo "<script type='text/javascript'>spge = '<?php echo $word ;?>';
            window.location.href = '$result';
            </script>";
        exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
