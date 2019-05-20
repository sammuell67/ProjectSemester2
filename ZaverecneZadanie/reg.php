<?php
session_start();
require_once ('config.php');

if(isset($_POST['register_btn'])) {
    session_start();
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $hash_pass = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
    echo $password;
    if ($password == $password2) {

        try {
            $stmt = $conn->prepare("INSERT INTO Admin(login,password) VALUES ( :login,:password)");
            $stmt->execute(array(':login' => $login, ':password' => $hash_pass));
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }

    }
}




?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS.css">
    <title>Registration</title>
</head>
<body>



<div class="pad">
    <div class="col text-center">
        <a href="login.php" class="btn btn-info" role="button">Login</a>
        <a href="LDAP.php" class="btn btn-info" role="button">LDAP Login</a>
        <a href="form.php" class="btn btn-dark" role="button">Registration</a>
    </div>


</div>
<form method="post" action="reg.php" class="form" >
    <table >
        <tr>
            <td>Name:</td>
            <td><input type="text" name="name" class="textInput"></td>
        </tr>
        <tr>
            <td>Surname:</td>
            <td><input type="text" name="surname" class="textInput"></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="email" name="email" class="textInput"></td>
        </tr>
        <tr>
            <td>Login:</td>
            <td><input type="text" name="login" class="textInput"></td>
        </tr>
        <tr>
            <td>Password:</td>
            <td><input type="password" name="password" class="textInput"></td>
        </tr>
        <tr>
            <td>Password again:</td>
            <td><input type="password" name="password2" class="textInput"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="register_btn" value="Register" class="btn btn-primary"></td>
        </tr>
    </table>
</form>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>