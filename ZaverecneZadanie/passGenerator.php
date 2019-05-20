<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Uloha3</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link rel="stylesheet" href="css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
<!--    <style>-->
<!--        .hilight {-->
<!--            color: red;-->
<!--            background-color: #3b99fc;-->
<!--            font-weight: bold;-->
<!--        }-->
<!---->
<!--        .detail {-->
<!--            border: 1px solid black;-->
<!--            width: 35%;-->
<!--            margin: auto;-->
<!---->
<!--        }-->
<!---->
<!--        .form {-->
<!--            border: 1px solid black;-->
<!--            width: 80%;-->
<!--            margin: auto;-->
<!--            margin-bottom: 10px;-->
<!--        }-->
<!--    </style>-->
</head>

<body>
<form method="get" class="form-style-7">
    <h2>Nahratie</h2>
    Nahratie súboru na pridanie hesiel:
    <input name="file" type="file" accept=".csv"/>
    <br>
    Oddeľovač
    <select name=delimeter>
        <option value=";"> ;</option>
        <option value=","> ,</option>
    </select><br>
    <input type="submit" value=Potvrď>
</form>

<form method="get" class="form-style-7">
    <h2>Odoslanie mailu</h2>

    Nahratie súboru na odoslanie mailov:
    <input name="mailFile" type="file" accept=".csv"/>
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
    <input name="email" type="text">
    <br>
    Login:
    <input name="login" type="text">
    <br>
    Heslo:
    <input type="password" name="pass" >
    <br>
    Predmet správy:
    <input name="subject" type="text">
    <br>
    <input type="submit" value=Potvrď>
</form>
</body>
</html>


<?php

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

$delimeter = $_GET["delimeter"];
$file = $_GET["file"];
$mailFile = $_GET["mailFile"];
$row = 1;
$help = 1;
$newCsvData = array();
$updated = 0;

if (($handle = fopen($file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, $delimeter)) !== FALSE) {
        $num = count($data);
        for ($c = 0; $c < $num; $c++) {
            if (strcasecmp($data[$c], 'heslo') == 0) {
                echo "heslo pridane";
                die();
            }
        }
        if ($row == 1) {
            $data[] = "heslo";
            $row++;
        } else
            $data[] = randomPassword();
        $newCsvData[] = $data;
    }
    fclose($handle);
}

$handle = fopen($file, 'w');

$num = count($newCsvData);
for ($c = 0; $c < $num; $c++) {
    fputcsv($handle, $newCsvData[$c]);
    $updated = 1;
}
fclose($handle);

if ($updated == 1) {
    echo '<a href="' . $file . '" download>Stiahnut subor</a>';
}
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

$sablona = file_get_contents("sablona.txt");
chmod($sablona, 0777);

function highlight($text, $word, $replace)
{
    if (strlen($text) > 0 && strlen($word) > 0) {
        return (str_replace($word, $replace, $text));
    }
    return ($text);
}
require 'PHPMailer/PHPMailerAutoload.php';

function sentMail($text, $name, $login, $password, $email, $subject, $emailTo, $nameTo)
{
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

    try {
        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.stuba.sk';                        // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $login;                       // SMTP username
        $mail->Password = $password;                      // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;
        $mail->CharSet = 'utf-8';// TCP port to connect to

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress($emailTo, $nameTo);  // Add a recipient
        //$mail->addAddress('contact@example.com');               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $text;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    };
}

$i = 1;
$name = $_GET['name'];
$text = $sablona;
$login = $_GET['login'];
$password = $_GET['pass'];
$emailFrom = $_GET['email'];
$subject = $_GET['subject'];
$emailTo = '';
$nameTo = '';
$pos = 0;

while ($i < $r) {
    for ($j = 0; $j < $c; $j++) {
        $text = highlight($text, "{{{$arr[0][$j]}}}", $arr[$i][$j]);
        $text = highlight($text, "{{sender}}", $name);
        if (strpos($arr[0][$j], 'Email') !== false) {
            $emailTo = $arr[$i][$j];
        }
        if (strpos($arr[0][$j], 'meno') !== false) {
            $nameTo = $arr[$i][$j];
        }
    }

    sentMail($text, $name, $login, $password, $emailFrom, $subject, $emailTo, $nameTo);
    $i++;
}

?>