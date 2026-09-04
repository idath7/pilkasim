<?php  
require_once 'Core/init.php';

unset($_SESSION['admin']);

header('Location: login.php');
?>