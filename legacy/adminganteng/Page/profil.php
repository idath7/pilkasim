<?php 	
$admin = tampilAdmin();
$no = 1	
?>
<title>Profil | E-Pilketos</title>	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Profil</li>&nbsp;&nbsp;<a data-toggle="modal" href="?p=add_admin" class="btn btn-xs btn-primary">Tambah Admin</a>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Profil Admin</h2>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Admin</div>
					<div class="panel-body">
						<table class="table table-bordered table-responsive">
							<tr class="active">
								<th width="5%">#</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Opsi</th>
							</tr>
							<?php foreach($admin as $row): ?>
							<tr class="success">
								<td><?= $no++;  ?></td>
								<td><?= $row['nama'];  ?></td>
								<td><?= $row['mail'];  ?></td>
								<td><?php if((mysqli_num_rows($admin)) > 1){
										echo"<a href='?p=del_admin&id=";
										echo $row['id']."'"; 
										echo " class='btn btn-xs btn-danger'>Hapus</a>";
											}
									?>
									<a href="?p=edit_admin&id=<?= $row['id'] ?>" class="btn btn-xs btn-primary">Edit</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>