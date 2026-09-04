<?php  

	function jumlah(){
		global $link;

		$query = "SELECT * FROM data";
		$result= mysqli_query($link, $query);

		return $result;	
	}

	function sudah(){
		global $link;

		$query  = "SELECT * FROM data WHERE status='0'";
		$result = mysqli_query($link, $query);

		return $result;	
	}

	function belum(){
		global $link;

		$query  = "SELECT * FROM data WHERE status='1'";
		$result = mysqli_query($link, $query);

		return $result;	
	}

	//Chart
	function laporan(){
		global $link;

		$query = "SELECT nama, hasil FROM calon";
		$result= mysqli_query($link, $query);

		return $result;	
	}

?>
