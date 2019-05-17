<?php
 session_start();
 mysqli_set_charset($conn, "utf8");
?>

<!DOCTYPE HTML>
<html lang="sk">
  <head>
    <title>Portál</title>
    <meta content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="style.css">
    <script types="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script type="text/javascript" src="script.js"></script>
  </head>
  <body> 
<header>
	<nav>
		<ul>
			<li><a href="index.php">Počasie</a></li>
			<li><a href="ip.php">IP adresy</a></li>
      		<li><a href="navstevy.php">Návštevy</a></li>	
		</ul>
	</nav>
</header>
