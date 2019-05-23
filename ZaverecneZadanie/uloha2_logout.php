<?php
/**
 * Created by PhpStorm.
 * User: JA
 * Date: 12. 3. 2019
 * Time: 20:49
 */
session_start();
session_destroy();
unset($_SESSION['student']);
unset($_SESSION['admin']);

header("location:uloha2_index.php");
?>