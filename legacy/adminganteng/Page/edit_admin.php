<?php  
$hak  = mysqli_fetch_assoc(tampil($sesi));

if ($hak['id'] == 1){
?>
<title>Edit Admin | E-Pilketos</title>	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active"><a href="?p=profil">Profil</a></li><li>Edit admin</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Edit Admin</h2>
			</div>
		</div><!--/.row-->
		<?php 

		$id = $_GET['id'];

		if(isset($_GET['id'])){
			$id_admin = id_admin($id);
			foreach ($id_admin as $row) {
				$_name = $row['nama'];
				$_user = $row['user'];
				$_pass = $row['pass'];
				$_mail = $row['mail'];
			}
		}

		if(isset($_POST['edit'])){
			$name = $_POST['name'];
			$user = trim($_POST['user']);
			$pass = trim($_POST['pass']);
			$mail = trim($_POST['mail']);
			$pass_= trim($_POST['passlama']);

			if (!empty($name) || !empty($user) || !empty($pass) || !empty($mail) || !empty($pass_)) {

				if(password_verify($pass_, $_pass)){

					if (edit_admin($name, $user, $pass, $mail, $id)) {
						?><script>window.location='?p=profil';</script><?php
					}else{
						?><script>swal('Oops...', 'Ada masalah saat mengedit', 'error');</script><?php
					}

				}else{
					?><script>swal('Oops...', 'Password lama Anda salah', 'error');</script><?php
				}

			} else {
				?><script>swal('Oops...', 'Form tidak bleh kosong', 'error');</script><?php
			}
			
		}

		?>

		<div class="row">
			<div class="col-md-5">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Admin</div>
					<div class="panel-body">
						<form method="post">
							<div class="form-group">
								<label for="">Nama</label>
								<input class="form-control" type="text" name="name" value="<?= $_name;  ?>" placeholder="Nama">
							</div>
							<div class="form-group">
								<label for="">Username</label>
								<input class="form-control" type="text" name="user" value="<?= $_user;  ?>" placeholder="Username">
							</div>
							<div class="form-group">
								<label for="">Password lama</label>
								<input class="form-control" type="password" name="passlama" placeholder="Password lama">
							</div>

							<div class="form-group">
								<label for="">Password baru</label>
								<input class="form-control" type="password" name="pass" placeholder="Password baru">
							</div>
							<div class="form-group">
								<label for="">Email</label>
								<input class="form-control" type="email" name="mail" value="<?= $_mail;  ?>" placeholder="Email">
							</div>
							<input class="form-control btn btn-primary" type="submit" name="edit" value="Simpan">
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