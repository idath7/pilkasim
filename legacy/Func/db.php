<?php 
	
	$host = "localhost";
	$user = "epilkasim_maswah";
	$pass = "b4JZWtchpfn5pmbL";
	$db   = "epilkasim_maswah";

    $link = mysqli_connect($host, $user, $pass, $db) or die (mysqli_error());

//    define("$HOST", "localhost");
//    define("$USER", "pilkasim_maswaha");
//    define("$PASSWORD", "fGbbxkrcDEhysKLy");
//    define("$DATABASE", "pilkasim_maswaha");
//
//    $db = mysqli_connect($HOST, $USER, $PASSWORD, $DATABASE);

	//Anti sql Injection
	function escape($data){
		global $link;
		return mysqli_real_escape_string($link, $data);
	}

?>