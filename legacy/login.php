<?php  
require_once 'Core/init.php';

if(isset($_SESSION['admin'])){
	header('Location: index.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login Area</title>
	<link rel="stylesheet" type="text/css" href="../Assets/css/bootstrap.min.css">
	<link rel="shortcut icon" href="../Assets/img/icon.png">
	<link href="../Assets/css/sweetalert.css" rel="stylesheet">
	<script src="../Assets/js/sweetalert.min.js"></script>
	<style type="text/css">
		body{
			background: #f1f4f7;
			padding-top: 50px;
			color: #5f6468;
		}
		/*Panels*/

		.panel {
			border: 0;
			width: 33%;
		}

		.panel-heading {
			font-size: 18px;
			font-weight: 300;
			letter-spacing: 0.025em;
			height: 66px;
			line-height: 45px;
		}

		.panel-default .panel-heading {
			background: #fff;
			border-bottom: 1px solid #eee;
			color: #5f6468;
		}	
		.btn-primary{
			background-color: #30a5ff;
			border-color: #30a5ff;
		}
		.btn-primary:hover,.btn-primary:focus,.btn-primary:active{
			background: #1f9cfd;
			border-color: #1f9cfd;
		}
	</style>
</head>
<body>
	<center>
		<div class="panel panel-default">
			<div class="panel-heading">Login Area</div>
			<div class="panel-body">

<?php  

if(isset($_POST['login'])){
	$user = trim($_POST['username']);
	$pass = trim($_POST['password']);

	if(!empty($user) && !empty($pass))
	{
		if(user_admin($user))
		{
			if(pass_admin($user, $pass))
			{
				$_SESSION['admin'] = $user;
				header("Location: index.php");
			}else{
				?><script>sweetAlert("Oops...", "Password salah", "error");</script><?php	
			}
		}else{
			?><script>sweetAlert("Oops...", "Username salah/tidak terdaftar", "error");</script><?php
		}
	}else{
		?><script>sweetAlert("Oops...", "Form tidak boleh kosong", "error");</script><?php
	}
}

?>

				<form method="post">
					<div class="form-group">
						<input type="text" name="username" class="form-control" placeholder="Username" autofocus="">
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="password">
					</div>
					<input type="submit" name="login" class="btn btn-primary" value="Login">
				</form>
			</div>
		</div>
	</center>

	<script type="text/javascript" src="../Assets/js/jquery-3.1.0.min.js"></script>
	<script type="text/javascript" src="../Assets/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>