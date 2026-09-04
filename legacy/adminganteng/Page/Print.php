<?php
require_once '../../Func/db.php';
require_once '../../Func/calon.php'; 
$calon = tampil_calon();
$no    = 1
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Laporan Hasil Pemilihan Ketua OSIM | E-Pilkasim</title>
	<link rel="shortcut icon" href="../../Assets/img/icon.png">
	<link rel="stylesheet" href="../../Assets/css/bootstrap.min.css">
</head>
<body style="width: 100%;">
	<div class="row">
		<div class="col-md-12">
		<h4 class="text-center">Laporan Hasil Pemilihan Ketua OSIM Aliyah Wahid Hasyim Balung <?php echo date('Y'); ?></h4>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Foto</th>
						<th>Nama</th>
						<th style="width: 70px;">Kelas</th>
						<th>Visi</th>
						<th>Misi</th>
						<th>Perolehan</th>
					</tr>
				</thead>
				<tbody>
				<?php  foreach($calon as $row):?>
					<tr>
						<td><?=$no++ ?></td>
						<td><img src="<?php echo "../".$row['foto'];?>" width="150" alt=""></td>
						<td><?=$row['nama']?></td>
						<td><?=$row['kelas']?></td>
						<td><?=$row['visi']?></td>
						<td><?=$row['misi']?></td>
						<td><?=$row['hasil']?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<script src="../../Assets/js/jquery-3.1.0.min.js"></script>
<script src="../../Assets/js/bootstrap.min.js"></script>
<script>
	window.print();
</script>
</body>
</html>