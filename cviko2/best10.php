<link rel='stylesheet' type="text/css" href='css/style2.css'>

<?php include("config.php") ?>

<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/3/2019
 * Time: 9:11 PM
 */
$sq10 = "SELECT Os.name, Os.surname, COUNT(Um.place) as PocetMedaili FROM osoby Os, umiestnenia Um WHERE Os.id_person = Um.id_person AND Um.place = '1' GROUP BY Um.id_person LIMIT 10";
echo "<form action='index.php' method='post'>";
echo "<div class='buttonik'>";
echo "<button class=\"button\">Spat</button>";
echo "<table class='paleBlueRows'>";
echo "<tr><th >Firstname</th><th>Lastname</th><th>Winners</th>";


class TableRows extends RecursiveIteratorIterator
{
    function __construct($it)
    {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current()
    {
        return "<td>" . parent::current() . "</td>";
    }

    function beginChildren()
    {
        echo "<tr>";
    }

    function endChildren()
    {
        echo "</tr>" . "\n";
    }
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=zadanie2", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec('SET NAMES utf8');
    $stmt = $conn->prepare($sq10);
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k => $v) {
        echo $v;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";