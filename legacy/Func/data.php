<?php  
	//Tampil Data
	function tampil_data(){
		global $link;

		$query  = "SELECT * FROM data";
		$result = mysqli_query($link, $query) or die(mysqli_error());

		return $result;	
	} 

	//Delete Data
	function del_data(){
		$query = "DELETE FROM data";
		return run($query);
	}

	function del_hasil(){
		$query = "UPDATE calon SET hasil='0'";
		return run($query);
	}
?>