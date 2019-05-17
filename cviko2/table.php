<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/28/2019
 * Time: 2:01 PM
 */

print("<TABLE border=1 cellpadding=5 cellspacing=0 class=whitelinks id='myTable'>\n");
$A="SELECT surname FROM oh";
$poceta = $conn->query($A);
//$B="SELECT Datum,Login FROM Prihlasenie WHERE ID_typ='2' ";
//$C="SELECT Datum,Login FROM Prihlasenie WHERE ID_typ='3' ";
//$pocetb = $conn->query($B);
//$pocetc = $conn->query($C);
$acount=mysqli_num_rows($poceta);
print ("<TR><TH onclick=\"sortTable(0)\">Filename</TH><th onclick=\"sortTable(1)\">FileSize</th><th onclick=\"sortTable(2)\">Date</th></TR>\n");
for($index=0; $index < $indexCount; $index++) {
    if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files
        print("<TR><TD><a>$account</a></td>");
        print("<td>");
        print(filesize($dirArray[$index])." bytes");
        print("</td>");
        print("<td>");
        print(date("F d Y H",filemtime($dirArray[$index])));
        print("</td>");
        print("</TR>\n");
    }
}
print("</TABLE>\n");