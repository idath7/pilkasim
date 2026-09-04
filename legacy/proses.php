<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="Assets/css/sweetalert.css">
	<script src="Assets/js/sweetalert.min.js"></script>
</head>
<body>
	<?php  

	require_once 'Core/init.php';  
	$id = $_GET['id'];
	$calon = tampilnama($id);
	$row = mysqli_fetch_assoc($calon);
	$tambah = ($row['hasil']) + 1;
	$sesi = $_SESSION['user'];
	$memilih = pilih($sesi, $tambah, $id);

	if ($memilih == TRUE){ 
		?><script>
			swal({title: "Terima Kasih!",text: "Anda sudah memilih", timer:5000 ,type:"success"}, 
			function(){window.location='logout.php';});
		</script><?php
	}

	?>	
</body>
</html>
