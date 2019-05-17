<?php


function getData($type, $radio, $ustav)
{

    $string = "https://is.stuba.sk/pracoviste/prehled_temat.pl?lang=sk;pracoviste=";
    $url = $string . $ustav;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($curl);
    curl_close($curl);
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($result);
    $xPath = new DOMXPath($doc);
    $tableRows = $xPath->query('//html/body/div/div/div/form/table[last()]/tbody/tr');
    if ($type == 1) {
        $bordel = "BP";
    }
    if ($type == 2) {
        $bordel = "DP";
    }
    createTable($tableRows, $radio, $bordel);


}

function createTable($tableRows, $radio, $bordel)
{

    echo '<table class="greyGridTable" id="tabulka" name="tabulka"> <thead>
<tr><td onclick="sortTable2(0)">Typ</td>
<td onclick="sortTable2(1)">Nazov</td>
<td onclick="sortTable2(2)">Veduci</td>
<td onclick="sortTable2(3)">Odbor</td>
<td>Obsadené/Max</td>
</tr></thead><tbody>';

    foreach ($tableRows as $row) {


        $annotationURL = 'https://is.stuba.sk' . $row->childNodes[8]->firstChild->firstChild->getAttribute('href');


        // vykonanie sekundarneho curl dopytu, a parsovanie odpovede pre ziskanie anotacie
        $ch = curl_init($annotationURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        //var_dump($result);
        curl_close($ch);

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($result);
        $xPath = new DOMXPath($doc);
        $annotation = $xPath->query('//html/body/div/div/div/table[1]/tbody/tr[last()]/td[last()]')[0]->textContent;


        if ($bordel == $row->childNodes[1]->textContent && $radio == "volne" && (strpos($row->childNodes[9]->textContent, "--") !== false)) {
            echo '<tr id="' . $row->childNodes[0]->textContent . '" onclick="ukaz(' . $row->childNodes[0]->textContent . ')">';

            echo '<td>' . $row->childNodes[1]->textContent . '</td>
    <td id="parent">' . $row->childNodes[2]->textContent . '</td>
<td>' . $row->childNodes[3]->textContent . '</td>
<td>' . $row->childNodes[5]->textContent . '</td>
<td>' . $row->childNodes[9]->textContent . '</td>
<td class="anotacia" id="r' . $row->childNodes[0]->textContent . '">' . $annotation . '</td>
            <p id="ineer"></p>';


        } else if ($bordel == $row->childNodes[1]->textContent && $radio == "obsadene" && (strpos($row->childNodes[9]->textContent, "--") != true) && (strpos($row->childNodes[9]->textContent, "0") != true)) {
            echo '<tr id="' . $row->childNodes[0]->textContent . '" onclick="ukaz(' . $row->childNodes[0]->textContent . ')">';

            echo '<td>' . $row->childNodes[1]->textContent . '</td>
<td>' . $row->childNodes[2]->textContent . '</td>
<td>' . $row->childNodes[3]->textContent . '</td>
<td>' . $row->childNodes[5]->textContent . '</td>
<td >' . $row->childNodes[9]->textContent . '</td>
<td class="anotacia" id="r' . $row->childNodes[0]->textContent . '">' . $annotation . '</td>
            <p id="ineer"></p>';

        }
    }
    echo "</tr>";

}


?>
