<?php
session_start();

// Set Language variable
if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];

    if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'> location.reload(); </script>";
    }
}

// Include Language file
if (isset($_SESSION['lang'])) {
    include "lang_" . $_SESSION['lang'] . ".php";
} else {
    include "lang_en.php";
}
?>
<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
</head>
<body>
<script>
    function changeLang() {
        document.getElementById('form_lang').submit();
    }
</script>


<!-- Language -->

<form method='get' action='' id='form_lang' >
    <select class="uloha2 jazyk" name='lang' onchange='changeLang();' >
        <option value='en' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'){ echo "selected"; } ?> >English</option>
        <option value='sk' <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'sk'){ echo "selected"; } ?> >Slovak</option>
    </select>
</form>

<div class='topnav'>
     <a href='uloha1_login.php' class=btn; role='button'><?= _ULOHA1 ?></a>
    <a href='uloha2_index.php' class=btn; role='button'> <?= _ULOHA2 ?></a>
    <a href='uloha3_index.php' class=btn; role='button'><?= _ULOHA3 ?></a>

</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>


<div id="page_kontakt">
    <div>
        <div class="contact-container">
            <h1 class="mat-col-primary-light">Samuel Solár</h1>
            <ul>
                <li>Email: <a href="mailto:xsolar@stuba.sk">xsolar@stuba.sk</a></li>
                <li><?= _SUBJECT ?>: Štvrtok 13:00</li>
            </ul>
        </div>
        <div class="contact-container">
            <h1 class="mat-col-primary-light">František Onderišin</h1>
            <ul>
                <li>Email: <a href="mailto:xonderisin@stuba.sk">xonderisin@stuba.sk</a></li>
                <li><?= _SUBJECT ?>: Štvrtok 13:00</li>
            </ul>
        </div>
        <div class="contact-container">
            <h1 class="mat-col-primary-light">Milan Pavlík</h1>
            <ul>
                <li>Email: <a href="mailto:xpavlikm3@stuba.sk">xpavlikm3@stuba.sk</a></li>
                <li><?= _SUBJECT ?>: Štvrtok 13:00</li>
            </ul>
        </div>
        <div class="contact-container">
            <h1 class="mat-col-primary-light">Matúš Chalko</h1>
            <ul>
                <li>Email: <a href="mailto:xchalko@stuba.sk">xchalko@stuba.sk</a></li>
                <li><?= _SUBJECT ?>: Štvrtok 13:00</li>
            </ul>
        </div>
        <div class="contact-container">
            <h1 class="mat-col-primary-light">Jakub Jadviš</h1>
            <ul>
                <li>Email: <a href="mailto:xjadvis@stuba.sk">xjadvis@stuba.sk</a></li>
                <li><?= _SUBJECT ?>: Štvrtok 13:00</li>
            </ul>
        </div>
    </div>
    <table class="blueTable">
        <thead>
        <tr>
            <td></td>
            <th>Samuel Solár</th>
            <th>Milan Pavlík</th>
            <th>František Onderišin</th>
            <th>Matúš Chalko</th>
            <th>Jakub Jadviš</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th><?= _RESPONZIVE ?></th>
            <td class="true">✔</td>
            <td class="true">✔</td>
            <td class="true">✔</td>
            <td class="true">✔</td>
            <td class="true">✔</td>
        </tr>

        <tr>
            <th><?= _ULOHA1 ?></th>
            <td class="true">✔</td>
            <td>✖</td>
            <td class="true">✔</td>
            <td>✖</td>
            <td class="true">✔</td>
        </tr>
        <tr>
            <th><?= _ULOHA2 ?></th>
            <td>✖</td>
            <td class="true">✔</td>
            <td>✖</td>
            <td class="true">✔</td>
            <td>✖</td>
        </tr>
        <tr>
            <th><?= _ULOHA3 ?></th>
            <td class="true">✔</td>
            <td>✖</td>
            <td class="true">✔</td>
            <td>✖</td>
            <td class="true">✔</td>
        </tr>
        <tr>
            <th><?= _PRIHL ?></th>
            <td class="true">✔</td>
            <td>✖</td>
            <td>✖</td>
            <td class="true">✔</td>
            <td>✖</td>
        </tr>
        <tr>
            <th><?= _STAT ?></th>
            <td>✖</td>
            <td class="true">✔</td>
            <td>✖</td>
            <td>✖</td>
            <td>✖</td>
        </tr>
        </tbody>
    </table>
</div>
</div>

</body>
</html>
