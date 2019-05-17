
<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
</head>
    <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

    <div class="box">
            <h1>Login</h1>


            <input type="text" name="aisid" value="AIS ID" class="email" />

            <input type="password" name="password" value="password"  class="email" />


        <a href="login.php"><div class="btn">Sign In</div></a>

        </div> <!-- End Box -->

    </form>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>

</html>


