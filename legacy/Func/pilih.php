<?php  

	//Login
	function Login_user($user, $pass){
		global $link;

		$query = "SELECT * FROM data WHERE nama='$user' && nis='$pass' && status='1'";
		if($result = mysqli_query($link, $query)){
			if(mysqli_num_rows($result) != 0) return true;
			else return false;
		}
	}

	function tampil($sesi){
		global $link;
		
		$query = "SELECT nama FROM data WHERE nama='$sesi'";
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result) >0 ) echo mysqli_fetch_object($result)->nama;
		else return false;
	}

	//Pilih
	function tampilnama($id){
		global $link;

		$query  = "SELECT nama, hasil FROM calon WHERE id='$id'";
		$result = mysqli_query($link, $query) or die(mysqli_error());

		return $result;

	}

	function pilih($sesi, $tambah, $id){
		$sesi		= escape($sesi);
		$tambah		= escape($tambah);
		$id			= escape($id);

		global $link;
		$query = "UPDATE data SET status='0' WHERE nama='$sesi';";
		$query .= "UPDATE calon SET hasil='$tambah' WHERE id='$id'";
		
		$result = mysqli_multi_query($link, $query) or die(mysqli_error());

		return $result;
	}

	//Run query
	function run($query){
		global $link;

		if(mysqli_query($link, $query)) return true;
		else return false;
	}
?>