<!DOCTYPE html>
<html lang = "sk">
<head>
    <title>Login </title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <link rel="stylesheet" href="css/style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <meta name="google-site-verification" content="17OxJFpDdqO_lUFBnilTnnMThUr5khud-n6zjjIiuHA" />

</head>
<body>
<div class="btns">

            <a id="reg" href="index.php" class="active">Registracia</a>
            <a id="log" href="login.php">Prihlásenie</a>
</div>
<div class="wrapper">

    <form class="form-style-7" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h1>Registrácia</h1>
        <ul>
            <li>
                <label for="name">Meno</label>
                <input type="text" name="name" maxlength="100">

            </li>
            <li>
                <label for="surname">Priezvisko</label>
                <input type="text" name="surname" maxlength="100">

            </li>
            <li>
                <label for="email">Email</label>
                <input type="email" name="email" maxlength="100">
                <!--<span>Enter a valid email address</span>-->
            </li>
            <li>
                <label for="login">Login</label>
                <input type="text" name="login" maxlength="100">
                <!--                <span>Your website address (eg: http://www.google.com)</span>
                -->         </li>
            <li>
                <label for="pass">Heslo</label>
                <input type="password" name="pass">
                <!--                <span>Say something about yourself</span>
                --> </li>
            <li>
                <input type="submit" value="Poslať" >
            </li>
        </ul>
    </form>

</div>

<?php
/**
 * Created by PhpStorm.
 * User: Jakub
 * Date: 13.3.2017
 * Time: 18:04
 */

require __DIR__.'/config.php';

$name = $surname = $email = $login = $passw = "";
$kon=false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $surname=test_input($_POST["surname"]);
    $email = test_input($_POST["email"]);
    $login = test_input($_POST["login"]);
    $passw = test_input($_POST["pass"]);

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// Create connection
$pass=password_hash($passw,PASSWORD_DEFAULT);

$conn = new mysqli($servername, $username,$password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ((($name && $surname && $email && $login && $pass)!= "")) {
    $konlog = "SELECT Login,Email FROM Uzivatelia WHERE Login ='$login' OR Email='$email'";
    $result = $conn->query($konlog);
    while ($rows = $result->fetch_assoc()) {
        if ($login == $rows['Login'] OR $email == $rows['Email']) {
            echo "nepodarilo sa registrovat , email alebo login sa uz pouziva";
            $kon = true;
            die();
        }

    }
    $sql = "INSERT INTO Uzivatelia (Meno, Priezvisko, Email, Login, Heslo)
VALUES ('$name', '$surname', '$email', '$login', '$pass')";
    if ((($name && $surname && $email && $login && $pass) != "")) {

        if ($conn->query($sql) === TRUE) {

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

}
else {
    echo "";
}
$conn->close();
?>

</body>
</html>