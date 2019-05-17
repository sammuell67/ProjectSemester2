<link rel='stylesheet' type="text/css" href='css/style.css'>

<?php include("config.php") ?>
<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/28/2019
 * Time: 1:54 PM
 */


$sql = "SELECT Os.name, Os.surname, Oh.year, Oh.city, Oh.type, Um.discipline FROM oh Oh, osoby Os, umiestnenia Um WHERE Os.id_person = Um.id_person AND Oh.id_OH = Um.ID_OH AND Um.place = '1' ORDER BY Oh.year";

echo "<form action='best10.php' method='post'>";
echo "<div class='buttonik'>";
echo "<button class=\"button\">10 najlepsich</button>";
echo "</div>";
echo "</form>";

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
        echo "<td> <form  method='get' action='vymazanie.php'>";
        echo "<input onload='getValueOfId();' type='hidden' name='rowid' value=''>";
        echo "<input class='btn-default' type='submit' name='login' value='Delete'>";
        echo "</form>";
        echo "</td>  </tr>  \n";
    }
}

echo "<table class='darkTable' id='myTable2'>";
echo "<tr><th onclick=\"sortTable2(0,'myTable2')\">Firstname</th><th onclick=\"sortTable2(1,'myTable2')\" >Lastname</th><th onclick=\"sortTable2(2,'myTable2')\">Year</th><th>City</th><th onclick=\"sortTable2(4,'myTable2')\">Type</th><th>Sport</th></tr>";

try {
    $conn = new PDO("mysql:host=$servername;dbname=zadanie2", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec('SET NAMES utf8');
    $stmt = $conn->prepare($sql);
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


?>


<script>
    function sortTable2(n, tableN) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById(tableN);
        switching = true;
        //Set the sorting direction to ascending:
        dir = "asc";
        /*Make a loop that will continue until
        no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /*Loop through all table rows (except the
            first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("td")[n];
                y = rows[i + 1].getElementsByTagName("td")[n];
                /*check if the two rows should switch place,
                based on the direction, asc or desc:*/
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                //Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /*If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again.*/
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }

    }

    function getValueOfId() {
         x= $(this).closest('tr')[0].id;
        var id=$(this).parent().siblings(":first").text().value;
        document.getElementById(id).value =x;

    }

</script>
