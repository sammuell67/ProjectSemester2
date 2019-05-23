<?php

// Include the main TCPDF library (search for installation path).
require_once('PDFPOKUS/examples/tcpdf_include.php');


function fetch_data($predmet)
{

    $output = '';
    $servername = "localhost";
    $username = "xjadvis";
    $password = "xjadvis123";
    $dbname = "ZaverecneZadanieSamo";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $column_count = mysqli_num_rows(mysqli_query($conn, "describe $predmet"));
    $result = mysqli_query($conn, "SELECT * FROM $predmet");
    $query10 = "SELECT COLUMN_NAME  FROM INFORMATION_SCHEMA.COLUMNS WHERE  TABLE_NAME = '$predmet';";
    $hlavicka = mysqli_query($conn, $query10);

    $output .="<table>";
    $output.="<tr>";

    while ($row = mysqli_fetch_array($hlavicka)) {
        for ($o = 0; $o < $column_count; $o++) {

            if ($row[$o] != null) {
                $output .= "<th>" . $row[$o] . "</th>";
            }
        }

    }
    $output.="</tr>";
    $output.="<tr>";

    while ($row = mysqli_fetch_array($result)) {
        $output.="<tr>";

        for ($o = 0; $o < $column_count; $o++) {

            if ($row[$o] != null) {
                $output .= "<td>" . $row[$o] . "</td>";
            }
        }
        $output.="</tr>";

    }

    $output .="</table>";

    return $output;
}

$predmet = $_GET['vybernazvupredmetu'];


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ucitel');
$pdf->SetTitle($predmet);
$pdf->SetSubject('Vypis');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
$pdf->SetHeaderData('', '', $predmet . '', "Created by Smatlab", array(0, 64, 255), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

$pdf->SetFont('dejavusans', '', 10, '', true);

$pdf->AddPage('L');


$content.= fetch_data($predmet);
$pdf->writeHTML($content);
$pdf->Output('example_001.pdf', 'I');
