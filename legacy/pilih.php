<?php require_once 'Template/head.php';

if(!isset($_SESSION['user'])){
	header('Location: index.php');
}else{

$calon = tampil_calon();
$no    = 1

?>

<div class="container">
<h1 id="h2">Pemilihan Ketua OSIM MA WAHID HASYIM <?=date('Y'); ?></h1>
	<div id="rowrow" class="row">
	<?php  foreach($calon as $row):
		$foto = str_replace("../", "", $row['foto']);
	?>
		<div class="col-md-3 col-md-6 col-xs-12">
			<div class="panel panel-default">
				<center>
					<div class="panel-body">
						<img src="<?=$foto; ?>" class="img-responsive" alt="">
						<b><?php echo $no++.". ".$row['nama']; ?></b><p class="text-mutted"><?=$row['organisasi'];?></p>
					</div>
					<div class="panel-footer">
						<a data-toggle="modal" href="#detail<?=$row['id']; ?>" class="btn btn-info btn-sm">
						<span class="glyphicon glyphicon-info-sign"></span> Visi dan Misi
						</a>
						<a href="proses.php?id=<?=$row['id']; ?>" class="btn btn-primary btn-sm">
						<span class="glyphicon glyphicon-ok"></span> Pilih
						</a>

					</div>
				</center>
			</div>
		</div>
		<?php endforeach; ?>
	</div><!--/.row-->
</div>

<?php foreach($calon as $row): ?>
	<!-- Visi dan Misi -->
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
<?php } require_once 'Template/foot.php'; ?>
