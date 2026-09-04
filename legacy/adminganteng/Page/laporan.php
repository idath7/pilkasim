<?php 
$calon = tampil_calon();
$no    = 1
?>
<title>Laporan | E-Pilkasim</title>	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Laporan</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Laporan</h2>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Laporan Hasil Pemiliahan Ketua OSIM Aliyah Wahid Hasyim Balung <?=date('Y'); ?>
						&nbsp;&nbsp;
						<form style="display: inline-block;" action="Page/Print.php" method="post" target="_blank">
						<input type="submit" name="print" class="btn btn-primary" value="Print">
						</form>
					</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>No</th>
									<th>Foto</th>
									<th>Nama</th>
									<th>Kelas</th>
									<th>Visi</th>
									<th>Misi</th>
									<th>Perolehan</th>
								</tr>
							</thead>
							<tbody>
							<?php  foreach($calon as $row):?>
								<tr>
									<td><?=$no++ ?></td>
									<td><img src="<?=$row['foto']?>" height="90px" alt=""></td>
									<td><?=$row['nama']?></td>
									<td style="width: 70px;"><?=$row['kelas']?></td>
									<td><?=$row['visi']?></td>
									<td><?=$row['misi']?></td>
									<td><?=$row['hasil']?></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>