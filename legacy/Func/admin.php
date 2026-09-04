<?php  
	
	//Tampil Admin
	function tampilAdmin(){
		global $link;

		$query  = "SELECT * FROM admin";
		$result = mysqli_query($link, $query) or die(mysqli_error());

		return $result;	
	}

	//Tampil per Id 
	function id_admin($id){
		global $link;

		$query  = "SELECT * FROM admin WHERE id=$id";
		$result = mysqli_query($link, $query) or die(mysqli_error());

		return $result;	
	}

	//Tambah Admin
	function add_admin($name, $user, $pass, $mail){
		$nama = escape($name);
		$user = escape($user);
		$pass = escape($pass);
		$mail = escape($mail);

		$pass = password_hash($pass, PASSWORD_DEFAULT);
		$query = "INSERT INTO admin (nama, user, pass, mail) VALUES ('$name', '$user', '$pass', '$mail')";
		return run($query);
	}

	//Uji nama kembar
	function cek_nama($user){
		global $link;

		$query = "SELECT * FROM admin WHERE user = '$user'";

		if($result = mysqli_query($link, $query)){
			if(mysqli_num_rows($result) == 0) return true;
			else return false;
		}
	}

	//Edit Admin
	function edit_admin($name, $user, $pass, $mail, $id){
		$nama = escape($name);
		$user = escape($user);
		$pass = escape($pass);
		$mail = escape($mail);
		$id   = escape($id);

		$pass = password_hash($pass, PASSWORD_DEFAULT);
		$query = "UPDATE admin SET nama='$name', user='$user', pass='$pass', mail='$mail' WHERE id='$id'";
		return run($query);	
	}

	//Delete data Admin
	function del_admin($id){
		$query = "DELETE FROM admin WHERE id=$id";
		return run($query);
	}

	//Login
	function user_admin($user){
		global $link;

		$query = "SELECT * FROM admin WHERE user='$user'";
		if($result = mysqli_query($link, $query)){
			if(mysqli_num_rows($result) != 0) return true;
			else return false;
		}
	}

	function pass_admin($user, $pass){
		global $link;

		$query  = "SELECT pass FROM admin WHERE user='$user'";
		$result = mysqli_query($link, $query);
		$hash   = mysqli_fetch_assoc($result)['pass'];

		if(password_verify($pass, $hash)) return true;
		else return false;
	}

	function tampil($sesi){
		global $link;
		
		$query = "SELECT nama, id FROM admin WHERE user='$sesi'";
		$result = mysqli_query($link, $query) or die(mysqli_error());

		return $result;
	}

	//Run query
	function run($query){
		global $link;

		if(mysqli_query($link, $query)) return true;
		else return false;
	}

?>