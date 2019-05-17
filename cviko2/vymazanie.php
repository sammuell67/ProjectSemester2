
<link rel='stylesheet' type="text/css" href='css/style.css'>

<?php include("config.php") ?>
<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/28/2019
 * Time: 1:54 PM
 */


try {
    $conn = new PDO("mysql:host=$servername;dbname=zadanie2", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($_GET['rowid'])) {
        $id = $_GET['rowid'];
    }
    $sql = "DELETE FROM osoby WHERE id =". $id;

    $conn->exec($sql);
    echo "Record deleted!";



} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;


