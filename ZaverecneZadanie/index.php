
<!DOCTYPE HTML>
<html lang="sk">
<head>
    <meta content="text/html; charset=UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/loginstyle.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:700,600' rel='stylesheet' type='text/css'>
</head>

    <form method="post"  action="login.php">
        <div class="box">
            <h1>Login</h1>

            Prihlásanie ako admin
            <label class="switch">
                <input name="checkboxik" type="checkbox" >
                <span class="slider round"></span>
            </label>

            <input type="text"  name="aisid" placeholder="AIS ID" class="email" />

            <input type="password" name="password" placeholder="Password" class="email" />


            <input type="submit" class="btn" value="Sign in">

        </div> <!-- End Box -->
    </form>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js" type="text/javascript"></script>

</html>
