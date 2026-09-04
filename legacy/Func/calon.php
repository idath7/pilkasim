<?php 
	
	//Tampil Admin
	function tampil_calon(){
		global $link;

		$query  = "SELECT * FROM calon";
		$result = mysqli_query($link, $query) or die(mysqli_error());

		return $result;	
	} 

	//Tambah Calon
	function add_calon($nama, $kelas, $organisasi, $visi, $misi, $file){
		$nama		= escape($nama);
		$kelas		= escape($kelas);
		$organisasi	= escape($organisasi);
		$visi		= escape($visi);
		$misi		= escape($misi);
		$file		= escape($file);

		$query = "INSERT INTO calon (nama, kelas, organisasi, visi, misi, foto, hasil) 
				VALUES ('$nama', '$kelas', '$organisasi', '$visi', '$misi', '$file', '0')";
		return run($query);

	}

	//Tampil per Id 
	function id_calon($id){
		global $link;

		$query  = "SELECT * FROM calon WHERE id=$id";
		$result = mysqli_query($link, $query) or die(mysqli_error());

		return $result;	
	}

	//Edit Calon I
	function edit_calonI($nama, $kelas, $organisasi, $visi, $misi, $id){
		$nama		= escape($nama);
		$kelas		= escape($kelas);
		$organisasi	= escape($organisasi);
		$visi		= escape($visi);
		$misi		= escape($misi);
		$id 		= escape($id);

		$query = "UPDATE calon SET nama='$nama', kelas='$kelas', organisasi='$organisasi', 
				visi='$visi', misi='$misi' WHERE id='$id'";
		return run($query);	
	}

	//Edit Calon II
	function edit_calonII($nama, $kelas, $organisasi, $visi, $misi, $file, $id){
		$nama		= escape($nama);
		$kelas		= escape($kelas);
		$organisasi	= escape($organisasi);
		$visi		= escape($visi);
		$misi		= escape($misi);
		$file		= escape($file);
		$id 		= escape($id);

		$query = "UPDATE calon SET nama='$nama', kelas='$kelas', organisasi='$organisasi', 
				visi='$visi', misi='$misi', foto='$file' WHERE id='$id'";
		return run($query);	
	}

	//Delete Calon
	function del_calon($id){
		$query = "DELETE FROM calon WHERE id=$id";
		return run($query);
	}

	//Delete Semua Calon
	//Delete Calon
	function del_semua_calon(){
		$query = "DELETE FROM calon";
		return run($query);
	}

?>