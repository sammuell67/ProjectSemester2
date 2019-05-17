<meta charset="utf-8"/>
<link rel="stylesheet" href="css/style.css">

<?php

//Include GP config file
include_once("gpConfig.php");
require __DIR__.'/config.php';

if(isset($_GET['code'])){
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
    echo $redirectURL;
}

if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
    //Get user profile data from google
    $gpUserProfile = $google_oauthV2->userinfo->get();

    if(!empty($gpUserProfile)){
        $output = '<h1>Google </h1>';
        $output = '<h1>Google+ Profile Details </h1>';
        $output .= '<br/>Google ID : ' . $gpUserProfile['id'];
        $output .= '<br/>Name : ' . $gpUserProfile['given_name'].' '.$gpUserProfile['family_name'];
        $output .= '<br/>Email : ' . $gpUserProfile['email'];
        $output .= '<br/>Locale : ' . $gpUserProfile['locale'];
        $email=$gpUserProfile['email'];


        $output .= '<br/><br/> <a href="googleLogout.php">Logout</a> <br/><br/>';

    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
} else {
    $authUrl = $gClient->createAuthUrl();
    $output = filter_var($authUrl, FILTER_SANITIZE_URL);


}
echo "<div class='references'>";
echo $output;
echo "</div>";
?>

<?php
if($email!="") {
    $datum = date("Y-m-d H:i:s");
    $typ = "Google";

    $in = "INSERT INTO Prihlasenie (Login,ID_typ,Datum) VALUES ('$email','$typ','$datum')";
    $visit = "SELECT Datum FROM Prihlasenie WHERE Login ='$email' AND ID_typ='$typ'";
    $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        if ($conn->query($in) === TRUE) {
            echo '<div class="result">';
            echo "Vitajte, ste prihlaseny"."\n";
              echo "Aktualne prihlaseny : '$email' pomocou sluzby Google"."\n";
              echo "Historia prihlásení :"."\n";
          } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }
          $result = $conn->query($visit);
      while ($rowsec = $result->fetch_assoc()) {
             echo "<p>".$rowsec['Datum']."</p>";

        }
        echo '</div>';


    }
}
?>



