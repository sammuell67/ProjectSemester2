<?php
session_start();
include 'config.php';
$word = $_SESSION['word'];
$predmet = $_SESSION['predmet'];
$rok = $_SESSION['rok'];
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM ULOHA2 WHERE predmet ='$predmet ' AND rok_predmetu='$rok'";
$query = $conn->query($sql);
if($query->num_rows > 0){
    $delimiter = ",";
    $filename = "members_" . date('Y-m-d') . ".csv";

    //create a file pointer
    $f = fopen('php://memory', 'w');

    //set column headers
    $fields = array('id', 'meno', 'body');
    fputcsv($f, $fields, $delimiter);

    //output each row of the data, format line as csv and write to file pointer
    while($row = $query->fetch_assoc()){
        $status = ($row['status'] == '1')?'Active':'Inactive';
        $lineData = array($row['id'], $row['meno'], $row['body'],$status);
        fputcsv($f, $lineData, $delimiter);
    }

    //move back to beginning of file
    fseek($f, 0);

    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    //output all remaining data on a file pointer
    fpassthru($f);
}
$data1 ="https://147.175.121.210:4461/cviko1/ZaverecneZadanie/teams.php?team=";
$data2 = $word;
$result = $data1 . '' . $data2;
 "<script type='text/javascript'>spge = '<?php echo $word ;?>';
            window.location.href = '$result';
            </script>";
exit;

?>