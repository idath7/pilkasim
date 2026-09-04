<?php 
$calon = tampil_calon();
$no    = 1
?>
<title>Calon Ketua OSIS | E-Pilketos</title>	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Calon</li>&nbsp;&nbsp;
				<a href="?p=add_calon" class="btn btn-xs btn-primary">Tambah Calon</a>&nbsp;&nbsp;
				<a href="?p=del_all" class="btn btn-xs btn-danger">Hapus Semua</a>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Calon Ketua OSIS</h2>
			</div>
		</div><!--/.row-->
		
		<div class="row">

<?php  foreach($calon as $row):?>

			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-default">
					<center>
						<div class="panel-body">
							<img src="<?=$row['foto'] ?>" class="img-responsive" alt="">
							<b><?php echo $no++.". ".$row['nama']; ?></b><p class="text-mutted"><?=$row['organisasi'];?></p>
						</div>
						<div class="panel-footer">
							<a data-toggle="modal" href="#detail<?=$row['id']; ?>" class="btn btn-info btn-sm">Detail</a>
							<a href="?p=edit_calon&id=<?=$row['id'];?>" class="btn btn-primary btn-sm">Edit</a>
							<a href="?p=del_calon&id=<?=$row['id']; ?>&f=<?=$row['foto']; ?>" class="btn btn-danger btn-sm">Hapus</a>
						</div>
					</center>
				</div>
			</div>

<?php endforeach; ?>

		</div><!--/.row-->
	</div>

<?php foreach($calon as $row): ?>	
	<!-- Detail -->
	<div class="modal fade" id="detail<?=$row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Visi dan Misi</h4>
	      </div>
	      <div class="modal-body">
      		<table>
  			<tr>
  				<td>Nama</td>
  				<td>&nbsp;</td>
  				<td>:</td>
  				<td>&nbsp;</td>
  				<td><?=$row['nama']; ?></td>
  			</tr>
  			<tr>
  				<td>Kelas</td>
  				<td>&nbsp;</td>
  				<td>:</td>
  				<td>&nbsp;</td>
  				<td><?=$row['kelas']; ?></td>
  			</tr>
  			<tr>
  				<td>Organisasi</td>
  				<td>&nbsp;</td>
  				<td>:</td>
  				<td>&nbsp;</td>
  				<td><?=$row['organisasi']; ?></td>
  			</tr>
  		</table><br>
	        <b>VISI :</b>
	        	<div><?=$row['visi']; ?></div>
	        <b>MISI :</b>
	        	<div><?=$row['misi']; ?></div>
	      </div>
	    </div>
	  </div>
	</div>
<?php endforeach; ?>