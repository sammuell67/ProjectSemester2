<!DOCTYPE html>
<html>
<head>
    <title>Dochádzka </title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="css/style.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


</head>
<body>
<form id="selectForm" method="POST" action="">
    <input type="text" name="meno" id="meno" placeholder="AIS Login">
    <input class="vyber" type="submit" value="vybrat">
</form>

</body>
</html>
<script>

    var meno = <?= isset($_POST['meno']) ? $_POST['meno'] : '' ?>;


    $("#meno option").each(function() {
        if ($(this)[0].value == meno) {
            $('#typ').val(meno);
            return;
        }
    });

    function sortTable(n,ajdi) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById(ajdi);
        switching = true;
        //Set the sorting direction to ascending:
        dir = "desc";
        /*Make a loop that will continue until
         no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.getElementsByTagName("TR");
            /*Loop through all table rows (except the
             first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                 one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /*check if the two rows should switch place,
                 based on the direction, asc or desc:*/
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch= true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch= true;
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
                switchcount ++;
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
</script>
<?php


//if(isset($_GET['meno'])) {
$meno = $_POST['meno'];
//}


//tu su veci co si posielas z toho,co zadava user

//tu su veci co si posielas z toho,co zadava user
$login = $meno;  //teraz aby si to vyskusal,mozes tam dat napr. xsmetanka a ako password svoje heslo do aisu

//toto je napevno
$ldap_server = "ldap.stuba.sk";

if ($connect = @ldap_connect($ldap_server)) { // if connected to ldap server
    ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);

    //nasleduje set fucnckie ,pri ktorych ak nie si prihlaseny,vypise to spravu bad a dost --toto pouzivam v callbacku pre post
    // bind to ldap connection
    if (($bind = @ldap_bind($connect)) == false) {
        print "bind:__FAILED__<br>\n";
        echo "bad";
    }
    // search for user
    if (($res_id = ldap_search($connect, "dc=stuba, dc=sk", "uid=$login")) == false
    ) {
        print "failure: search in LDAP-tree failed<br>";
        echo "bad";
    }
}

$entry = ldap_first_entry($connect, $res_id);
$usrId = ldap_get_values($connect, $entry, "uisid")[0];


$ch = curl_init('http://is.stuba.sk/lide/clovek.pl');

// zostavenie dat pre POST dopyt
$toto=$usrId;
$data = array(
    'lang' => 'sk',
    'zalozka'=>'5',
    'rok'=>'1',
    'id'=>$toto


);

// nastavenie curl-u pre pouzitie POST dopytu
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// nastavenie curl-u pre ulozenie dat z odpovede do navratovej hodnoty z volania curl_exec
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

// vykonanie dopytu
$result = curl_exec($ch);
curl_close($ch);

// parsovanie odpovede pre ziskanie pozadovanych dat
$doc = new DOMDocument();
libxml_use_internal_errors(true);
$doc->loadHTML($result);
$xPath = new DOMXPath($doc);
$tableRows = $xPath->query('//html/body/div/div/div/table[last()]/tbody/tr');
$tableClass="order-table";
$idecko="firstTable";
echo "<table id=$idecko class='greyGridTable'><thead><tr><th>Publikácie-</th><th >Druh publikácie</th><th onclick=sortTable(2,'firstTable')>Rok</th></tr></thead><tbody>";
$counter=0;
for($i = 0; $i <= $tableRows->length - 1; $i++) {
    $pom=$tableRows[$i]->childNodes[2]->textContent;

    if( strpos($pom, 'monografie') !== false && ($tableRows[$i]->childNodes[3]->textContent >=2013)) {
        $counter=$counter+1;
        echo "<tr>";
//        echo "<td>".$tableRows[$i]->childNodes[0]->textContent."</td>";
        echo "<td>" . $tableRows[$i]->childNodes[1]->textContent . "</td>";
        echo "<td>" . $tableRows[$i]->childNodes[2]->textContent . "</td>";
        echo "<td>" . $tableRows[$i]->childNodes[3]->textContent . "</td>";
        echo "</tr>";
    }
    else continue;

}
echo "</tbody></table>";
if ($counter==0){
    echo '<style type="text/css">
            #firstTable {
               display:none;
            }
            </style>';
}
$counter=0;
$ideckodva="secondTable";
echo "<table id=$ideckodva class=$tableClass><thead><tr><th>Publikácia</th><th >Druh publikácie</th><th onclick=sortTable(2,'secondTable')>Rok</th></tr></thead><tbody>";
for($i = 0; $i <= $tableRows->length - 1; $i++) {
    $pom = $tableRows[$i]->childNodes[2]->textContent;

    if (strpos($pom, 'články') !== false &&($tableRows[$i]->childNodes[3]->textContent >=2013) ) {
        $counter=$counter+1;
        echo "<tr>";
        //echo "<td>".$tableRows[$i]->childNodes[0]->textContent."</td>";
        echo "<td>" . $tableRows[$i]->childNodes[1]->textContent . "</td>";
        echo "<td>" . $tableRows[$i]->childNodes[2]->textContent . "</td>";
        echo "<td>" . $tableRows[$i]->childNodes[3]->textContent . "</td>";
        echo "</tr>";
    } else continue;
}
echo "</tbody></table>";
if ($counter==0){
    echo '<style type="text/css">
            #secondTable {
               display:none;
            }
            </style>';
}
$counter=0;
$ideckotri="thirdTable";
echo "<table id=$ideckotri class=$tableClass><thead><tr><th>Publikácia</th><th >Druh publikácie</th><th onclick=sortTable(2,'thirdTable')>Rok</th></tr></thead><tbody>";
for($i = 0; $i <= $tableRows->length - 1; $i++) {
    $pom = $tableRows[$i]->childNodes[2]->textContent;

    if (strpos($pom, 'príspevky') !== false &&($tableRows[$i]->childNodes[3]->textContent >=2013) ) {
        $counter=$counter+1;
        echo "<tr>";
        //echo "<td>".$tableRows[$i]->childNodes[0]->textContent."</td>";
        echo "<td>" . $tableRows[$i]->childNodes[1]->textContent . "</td>";
        echo "<td>" . $tableRows[$i]->childNodes[2]->textContent . "</td>";
        echo "<td>" . $tableRows[$i]->childNodes[3]->textContent . "</td>";
        echo "</tr>";
    } else continue;
}
echo "</tbody></table>";
if ($counter==0){
    echo '<style type="text/css">
            #thirdTable {
               display:none;
            }
            </style>';
}
?>
