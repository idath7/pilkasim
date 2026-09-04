<?php require_once 'Core/init.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>E-PILKETOM MA WAHAS</title>
	<link rel="stylesheet" href="Assets/css/bootstrap.min.css">
	<link rel="shortcut icon" href="Assets/img/icon.png">
	<link rel="stylesheet" href="Assets/css/index.css">
	<link rel="stylesheet" href="Assets/css/sweetalert.css">
	<script src="Assets/js/sweetalert.min.js"></script>
</head>
<body>
<?php
error_reporting(E_ALL ^ E_NOTICE);

if(isset($_POST['login'])){
	$user = trim($_POST['username']);
	$pass = trim($_POST['password']);
error_reporting(E_ALL ^ E_DEPRECATED);

	if(!empty($user) && !empty($pass))
	{
		if(Login_user($user, $pass))
		{
			$_SESSION['user'] = $user;
			header("Location: pilih.php");
		}else{
			?><script>swal("Oops...", "Username atau Password salah/tidak terdaftar/sudah memilih", "error");</script><?php
		}
	}else{
		?><script>swal("Oops...", "Form tidak boleh kosong", "error");</script><?php
	}
}



?>
<nav id="nav" class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <img style="height: 130%;" alt="Brand" src="Assets/img/ready.png">
      </a>
    </div>
	    <ul class="nav navbar-nav navbar-right">
	    	<li>
	    		<img style="height: 100%;" src="Assets/img/user_.png">
	    	</li>
	    	<li><br>

		        <b id="txt" style="padding-top-top: 8px; color: #3c78b5;">Selamat Datang</b><br>
		        <i><?php if(isset($_SESSION['user'])){
							$sesi = $_SESSION['user'];
							tampil($sesi);
					
		        }
					
					?>
					<?php
error_reporting(E_ALL ^ E_NOTICE);
					echo $s['nama2'] ?>
				</i>
	        </li>
		</ul>
  </div>
</nav>
