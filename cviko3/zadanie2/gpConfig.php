<?php
session_start();

//Include Google client library
include_once 'src/Google_Client.php';
include_once 'src/contrib/Google_Oauth2Service.php';

/*
 * Configuration and setup Google API
 */
$clientId = '322400846998-9i4p38veg715gam1h3m53amhp5jcljua.apps.googleusercontent.com' ;
$clientSecret = '2rwUYjDDOHrpkgeZe4NNMo1o';
$redirectURL = 'https://147.175.121.210.xip.io:4126/cviko1/cviko3/zadanie2/index1.php';

//Call Google API
$gClient = new Google_Client();
$gClient->setApplicationName('Web client 1');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectURL);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>