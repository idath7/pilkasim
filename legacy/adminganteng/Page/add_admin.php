<?php  
$hak  = mysqli_fetch_assoc(tampil($sesi));

if ($hak['id'] == 1){
?>

<title>Tambah Admin | E-Pilketos</title>	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li><a href="?p=profil">Profil</a></li><li>Tambah Admin</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Tambah Admin</h2>
			</div>
		</div><!--/.row-->

		<?php 

		if(isset($_POST['tambahin'])){
			$name = $_POST['name'];
			$user = trim($_POST['user']);
			$pass = trim($_POST['pass']);
			$mail = trim($_POST['mail']);
			
			if (!empty($name) || !empty($user) || !empty($pass) || !empty($mail)) {
				if(cek_nama($user)){
					if (add_admin($name, $user, $pass, $mail)) {
						?><script>window.location='?p=profil';</script><?php
					}else{
						?><script>swal('Oops...', 'Ada masalah saat menambahkan data', 'error');</script><?php
					}
				}else{
					?><script>swal('Oops...', 'Username sudah ada', 'error');</script><?php
				}
			} else {
				?><script>swal('Oops...', 'Form tidak boleh kosong', 'error');</script><?php
			}
			
		}

		?>

		<div class="row">
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading">Tambah Admin</div>
					<div class="panel-body">
						<form method="post">
							<div class="form-group">
								<label for="">Nama</label>
								<input class="form-control" type="text" name="name" minlength="5" placeholder="Nama">
							</div>
							<div class="form-group">
								<label for="">Username</label>
								<input class="form-control" type="text" name="user" minlength="5" placeholder="Username">
							</div>
							<div class="form-group">
								<label for="">Password</label>
								<input class="form-control" type="password" name="pass" minlength="5" placeholder="Password">
							</div>
							<div class="form-group">
								<label for="">Email</label>
								<input class="form-control" type="email" name="mail" minlength="5" placeholder="example@domain.com">
							</div>
							<input class="form-control btn btn-primary" type="submit" name="tambahin" value="Tambahkan">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php 
}else{
	?><script>swal({title: "Oops...!",text: "Anda bukan Administrator",type:"error"}, 
				function(){window.location='?p=profil';});</script><?php
}
?>