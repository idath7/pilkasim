<?php  

require_once 'Core/init.php';

unset($_SESSION['user']);

header("Location: index.php");

?>