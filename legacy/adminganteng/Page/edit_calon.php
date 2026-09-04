<title>Edit Calon Ketua OSIS | E-Pilketos</title>	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active"><a href="?p=calon">Calon</a></li><li>Edit Calon</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Edit Calon Ketua OSIS</h2>
			</div>
		</div><!--/.row-->
<?php 

$id = $_GET['id'];

if(isset($_GET['id'])){
	$id_calon = id_calon($id);
	foreach ($id_calon as $row) {
		$_nama       = $row['nama'];
		$_kelas      = $row['kelas'];
		$_organisasi = $row['organisasi'];
		$_visi       = $row['visi'];
		$_misi       = $row['misi'];
		$_foto       = $row['foto'];
	}
}

if(isset($_POST['edit'])){
	$nama       = $_POST['nama'];
	$kelas      = $_POST['kelas'];
	$organisasi = $_POST['organisasi'];
	$visi       = $_POST['visi'];
	$misi       = $_POST['misi'];

	//Foto/Gambar
	$name  = $_FILES['foto']['name'];
	$asal  = $_FILES['foto']['tmp_name'];
	$error = $_FILES['foto']['error'];
	$size  = $_FILES['foto']['size'];
	$type  = $_FILES['foto']['type'];
	$file  = '../Assets/img/calon/'.$name;
	$time  = time();


	if (!empty($nama) && !empty($kelas) && !empty($organisasi) && !empty($visi) && !empty($misi)) 
	{
		if(!empty($name))
		{
			if( $error == 0)
			{
				if($size < 500000)
				{
					if($type == 'image/jpeg')
					{
						if(file_exists($file))
						{
							$file = str_replace(".jpg", "", $file);
							$file = $file."_".$time.".jpg";
						}
						unlink($_foto);
						move_uploaded_file($asal, $file);
						if(edit_calonII($nama, $kelas, $organisasi, $visi, $misi, $file, $id)) 
						{
							?><script>window.location='?p=calon';</script><?php
						}else{
							?><script>swal('Oops...', 'Ada masalah saat mengedit data', 'error');</script><?php
						}
					}else{
						?><script>swal('Oops...', 'Formatnya harus jpg', 'error');</script><?php
					}
				}else{
					?><script>swal('Oops...', 'Fotonya kegedean!! maksimal 2MB', 'error');</script><?php
				}
			}else{
				?><script>swal('Oops...', 'Ada masalah saat upload foto', 'error');</script><?php
			}
		}else{
			if(edit_calonI($nama, $kelas, $organisasi, $visi, $misi, $id)) 
			{
				?><script>window.location='?p=calon';</script><?php
			}else{
				?><script>swal('Oops...', 'Ada masalah saat mengedit data', 'error');</script><?php
			}
		}
	} else {
		?><script>swal('Oops...', 'Form tidak boleh kosong', 'error');</script><?php
	}
	
}

?>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Edit Calon</div>
					<div class="panel-body">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="nama">Nama</label>
										<input name="nama" type="text" class="form-control" value="<?=$_nama?>" placeholder="Nama">
									</div>
									<div class="form-group">
										<label for="kelas">Kelas</label>
										<input name="kelas" type="text" class="form-control" value="<?=$_kelas?>" placeholder="Kelas">
									</div>
									<div class="form-group">
										<label for="organisasi">Organisasi</label>
										<input name="organisasi" type="text" class="form-control" value="<?=$_organisasi?>" placeholder="Organisasi">
									</div>
									<div class="form-group">
										<label for="foto">Foto</label>
										<input name="foto" type="file" class="form-control" onchange="loadFile1(event)"> 
										<img src="" id="output1" class="img-responsive" style="height: 300px;" 
										alt="Ukuran Foto 3x4, dengan format JPG. Ukuran file Pasfoto tidak boleh lebih dari 500 KB. Kualitas gambar harus cukup tajam dan fokus. Posisi badan dan kepala tegak sejajar menghadap kamera. Proporsi wajah antara 25% - 50% dari foto. Tidak ada bagian kepala yang terpotong dan wajah tidak boleh tertutupi ornamen. Kepala terletak di tengah secara horisontal (jarak kepala ke batas kiri kurang lebih sama dengan jarak kepala ke batas kanan)">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="visi">Visi</label>
										<textarea name="visi" class="form-control" id="visi" cols="30" rows="10" placeholder="Visi"><?=$_visi?></textarea>
									</div>
									<div class="form-group">
										<label for="misi">Misi</label>
										<textarea name="misi" class="form-control" id="misi" cols="30" rows="10" placeholder="Misi"><?=$_misi?></textarea>
									</div>
								</div>
							</div>
							<input type="reset" class="btn btn-default" value="Reset">
							<input type="submit" name="edit" class="btn btn-primary" value="Simpan">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>