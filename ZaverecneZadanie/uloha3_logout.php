<?php
/**
 * Created by PhpStorm.
 * User: JA
 * Date: 12. 3. 2019
 * Time: 20:49
 */
session_start();
session_destroy();
unset($_SESSION['admin3']);

header("location:uloha3_index.php");
?>