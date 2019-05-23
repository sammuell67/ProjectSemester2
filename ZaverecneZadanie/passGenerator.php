<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <title>Uloha3</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <!--    <link rel="stylesheet" href="css/style.css">-->
    <link rel="stylesheet" href="css/myStyle.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
</head>

<body>


<?php
echo "<div class='topnav''>";
echo "<a href='uloha1_logout.php' class='btn' role='button' >Odhlásiť</a> ";
echo "</div>";

?>
<!--<div class="col text-right"><a href="uloha3_logout.php" class="btn btn-info" role="button">Odhlásiť</a></div>-->
<div class="uloha3Body">
    <div class="uloha3Div">
        <form method="post" class="uloha3Form">
            <h2>Odoslanie mailu</h2>

            Nahratie súboru na odoslanie mailov:
            <input class="custom-file-input" name="mailFile" type="file" accept=".csv"/>
            <br>
            Oddeľovač
            <select name=delimeter>
                <option value=";"> ;</option>
                <option value=","> ,</option>
            </select><br>
            Meno:
            <input name="name" type="text">
            <br>
            Email:
            <input name="email0" type="text">
            <br>
            Login:
            <input name="login" type="text">
            <br>
            Heslo:
            <input type="password" name="pass">
            <br>
            Predmet správy:
            <input name="subject" type="text">
            <br>
            <input name="sendMail" type="submit" value=Potvrď>
        </form>
    </div>
    <div class="uloha3Div">
        <form method="post" class="uloha3Form">
            <h2>Nahratie</h2>
            Nahratie súboru na pridanie hesiel:

            <input class="custom-file-input" name="file" type="file" accept=".csv"/>

            <br>
            Oddeľovač
            <select name=delimeter>
                <option value=";"> ;</option>
                <option value=","> ,</option>
            </select><br>
            <input name="passAdd" type="submit" value=Potvrď>
        </form>
    </div>

    <div class="uloha3Div">
        <form method="post" class="uloha3Form">
            <h2>Nahratie</h2>
            Výber ID šablóny:
            <input name="idTemplate" type="text">
            <input name="template" type="submit" value=Potvrď>
        </form>
    </div>
</div>

<div class="uloha3New">
    <form method="post" class="uloha3Form">
        <input name="showTemplates" type="submit" value="Zobraz šablóny">
    </form>
</div>

</body>

</html>

<?php



require('config.php');
require 'PHPMailer/PHPMailerAutoload.php';
session_start();
//header("Content-Type: text/html;charset=utf-8");


//unset($_SESSION['template']);

if (!$_SESSION['admin3']) {
    header('location:uloha3_index.php');
}

$connection = new mysqli($servername, $username, $password, $dbname);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
$query = mysqli_query($connection, "SET NAMES 'utf8'");

function logMail($conn, $date, $studentName, $subject, $id)
{
    $in = " INSERT INTO logMail (datumOdoslania,menoStudenta, predmetSpravy,IDSablony) VALUES ('$date','$studentName','$subject','$id'); ";

    $conn->query($in);
}

function randomPassword()
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 15; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function sentMail($tex, $nname, $loginn, $passw, $emailFr, $subject, $emailTo, $nameTo)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.stuba.sk';                        // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $loginn;                       // SMTP username
        $mail->Password = $passw;                      // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;
        $mail->CharSet = 'utf-8';// TCP port to connect to

        //Recipients
        $mail->setFrom($emailFr, $nname);
        $mail->addAddress($emailTo, $nameTo);  // Add a recipient

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $tex;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo '<script>console.log("Message has been sent.");</script>';

    } catch (Exception $e) {
        echo '<script>console.log("Message could not be sent.");</script>';
        echo '<script>console.log("Mailer Error: ' . $mail->ErrorInfo . '");</script>';
    };
}

function tableTemplates($conn)
{

    $result = mysqli_query($conn, "SELECT * FROM sablony;");
    echo '<div class="uloha3Table">';
    echo "<table class='blueTable'>";

    echo "<th>ID</th>";
    echo "<th>Sablona</th>";
    echo "</tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['sablona'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo '</div>';
}

function returnTemplate($conn, $id)
{
    $result = mysqli_query($conn, "SELECT sablona FROM sablony WHERE id =  '$id';");
    $row = mysqli_fetch_row($result);
    return $row[0];
}

function highlight($text, $word, $replace)
{
    if (strlen($text) > 0 && strlen($word) > 0) {
        return (str_replace($word, $replace, $text));
    }
    return ($text);
}

$filename = "new_csv.csv";
$delimeter = $_POST["delimeter"];
$file = $_POST["file"];
$mailFile = $_POST["mailFile"];
$row = 1;
$help = 1;
$newCsvData = array();
$updated = 0;
$data = array();
if (isset($_POST['passAdd'])) {
    $handle = fopen($file, "r");
    chmod($handle, 0777);
        while (($data = fgetcsv($handle, 1000, $delimeter))) {
            $num = count($data);
            for ($c = 0; $c < $num; $c++) {
                if (strcasecmp($data[$c], 'heslo') == 0) {
                    echo '<script>alert("Heslo pridane");</script>';
                    die();
                }
            }
            if ($row == 1) {
                $data[] = "heslo";
                $row++;
            } else {
                $data[] = randomPassword();
            }
            $newCsvData[] = $data;
        }
        fclose($handle);

    ob_clean();
    $f = fopen('php://memory', 'w');

    foreach ($newCsvData as $line) {
        echo $line;
        fputcsv($f, $line, $delimeter);
    }

    function exportCsv($f,$filename )
    {
        //move back to beginning of file
        fseek($f, 0);

        //set headers to download file rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'. $filename .'";');
        //output all remaining data on a file pointer
        fpassthru($f);
    }

    exportCsv($f,$filename);
}
if (isset($_POST['sendMail'])) {
    $arr = array(array(), array());
    $r = 0;
    $handle = fopen($mailFile, "r");
    chmod($handle, 0777);

    while ($data = fgetcsv($handle, 1000, $delimeter)) {
        $num = count($data);
        for ($c = 0; $c < $num; $c++) {
            $arr[$r][$c] = $data[$c];
        }
        $r++;
    }

    $i = 1;
    $nname = $_POST['name'];
    $templateSession = $_SESSION['template'];
    $loginn = $_POST['login'];
    $passw = $_POST['pass'];
    $emailFr = $_POST['email0'];
    $subject = $_POST['subject'];
    $emailTo = '';
    $nameStudent = '';
    $date = date("Y-m-d H:i:s");
    $text = '';
    $idT =  $_SESSION['idTemplate'];
    while ($i < $r) {
        $text = $templateSession;
        for ($j = 0; $j < $c; $j++) {
            $text = highlight($text, "{{{$arr[0][$j]}}}", $arr[$i][$j]);
            $text = highlight($text, "{{sender}}", $name);
            if (strpos($arr[0][$j], 'Email') !== false) {
                $emailTo = $arr[$i][$j];
            }
            if (strpos($arr[0][$j], 'Meno') !== false) {
                $nameStudent = $arr[$i][$j];
            }
        }
        sentMail($text, $nname, $loginn, $passw, $emailFr, $subject, $emailTo, $nameStudent);

        logMail($conn, $date, $nameStudent, $subject, $idT);
        $i++;
    }
    $connection->close();
}
if (isset($_POST['showTemplates'])) {
    tableTemplates($connection);
    $connection->close();
}
if (isset($_POST['idTemplate'])) {

    $idTemplate = $_POST['idTemplate'];

    $_SESSION['idTemplate'] = $idTemplate;

    $template = returnTemplate($connection, $idTemplate);
    $connection->close();
    $_SESSION['template'] = $template;
    echo  '<script>console.log("Šablóna vybraná");</script>';
}

?>

