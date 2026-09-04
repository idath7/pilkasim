<?php
if ( isset($_POST["import"]) ) {
$storagename = $_FILES["file"]["name"];
$lokasi=$_FILES["file"]["tmp_name"];
$n=move_uploaded_file($_FILES["file"]["tmp_name"],$storagename);
if($n){
header("location:?p=import&fn=$storagename");

}else{
header("location:?p=data&msg=nosend");

}

}

$data = tampil_data();

?>
<title>Data Pemilih | E-Pilketos</title>	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Data Pemilih</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Data Pemilih</h2>
				<?php
               error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
               if($_GET['msg']=='send')
			      {
					//jika impor berhasil
			         echo '<div class="alert alert-success  alert-dismissable" id="alert">
			         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
			         </button>1 Data berhasil di Import</div>';
			    	} else  if($_GET['msg']=='nosend')
			      {
					//jika impor berhasil
			         echo '<div class="alert alert-danger alert-dismissable" id="alert">
			         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
			         </button>Gagal upload File !</div>';
			    	}
			    ?>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Data Pemilih&nbsp;&nbsp;
						<a class="btn btn-sm btn-primary" data-toggle="collapse" href="#import" aria-expanded="false" aria-controls="collapseExample">
						<span class="glyphicon glyphicon-upload"></span>
						Import Data
						</a>&nbsp;&nbsp;

						<a onclick="del();" href="#" class="btn btn-sm btn-danger pull-right">
						<span class="glyphicon glyphicon-trash"></span>
						Hapus Semua Data
						</a>&nbsp;&nbsp;
					</div>
					<div class="panel-body">
						<div class="collapse" id="import">
						<div class="well">
						<?php  
							if($_GET['msg']=='')
						      {
								//jika impor berhasil
						         echo '<div class="alert alert-info alert-dismissable" id="alert">
						         <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
						         </button>file Excel XLS/XLSX yang diijinkan !</div>';
						    	}
						?>
							<form action="" method="post" enctype="multipart/form-data">
								<a href="Format/Data-Pemilih.xlsx" class="btn btn-default"><span class="glyphicon glyphicon-download"></span>
								Download Format</a><br><br>
								<input type="file" name="file" id="file" style="width: 30%;" class="pull-left form-control">&nbsp;
								<button type="submit" class="btn btn-primary" name="import">
									<span class="glyphicon glyphicon-upload"></span> Import
								</button>
							</form>
						</div>
					</div>
						<table id="tabel" class="table table-bordered table-striped" cellspacing="0" width="100%">
							<thead style="background: #88c9fb;">
								<tr>
									<th>ID</th>
									<th>PASSWORD</th>
									<th>NAMA LENGKAP</th>
									<th>KELAS</th>
									<th>JK</th>
									<th>STATUS</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($data as $row): ?>
								<tr>
									<td><?= $row['nama'] ?></td>
									<td><?= $row['nis'] ?></td>
									<td><?= $row['nama2'] ?></td>
									<td><?= $row['kelas'] ?></td>
									<td><?= $row['jk'] ?></td>
									<td>
									<?php 
										if($row['status'] == 1) 
										echo "<span class='label label-danger'>Belum Memilih</span></span>";
										// Belum Memilih <span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
										else echo "<span class='label label-success'>Sudah Memilih</span>";
										// Sudah Memilih <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
									?> 	
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->

	</div>