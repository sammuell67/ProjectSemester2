<?php
session_start();
$agree = $_GET["agree"];
$word = $_SESSION['word'];
$predmet = $_SESSION['predmet'];


include 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($agree == "agree"){
    $sql = "UPDATE ULOHA2BODY SET suhlas_admin='suhlasim' WHERE predmet='$predmet' AND tim='$word'";
}
else{
    $sql = "UPDATE ULOHA2BODY SET suhlas_admin='nesuhlasim' WHERE predmet='$predmet' AND tim='$word'";
}
//mysqli_query($conn, $sql);
$data1 ="https://147.175.121.210:4461/cviko1/ZaverecneZadanie/teams.php?team=";
$data2 = $word;
$result = $data1 . '' . $data2;
if ($conn->query($sql) === TRUE) {

    echo "<script type='text/javascript'>spge = '<?php echo $word ;?>';
            window.location.href = '$result';
            </script>";
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>