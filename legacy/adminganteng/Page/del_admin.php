<?php 

$hak  = mysqli_fetch_assoc(tampil($sesi));

if ($hak['id'] == 1){
	if(($_GET['id'])==1){
		?>
		<script>
		swal({title: "Oops...!",text: "Tidak boleh dihapus",type:"error"}, 
		function(){window.location='?p=profil';});
		</script>
		<?php
	}else{
		if(isset($_GET['id'])){
			if(del_admin($_GET['id'])){
				?><script>window.location='?p=profil';</script><?php
			}else{
				?><script>swal({title: "Oops...!",text: "Ada masalah saat menghapus data",type:"error"}, 
					function(){window.location='?p=profil';});</script><?php
			}
		}
	}
}else{
	?><script>swal({title: "Oops...!",text: "Anda bukan Administrator",type:"error"}, 
				function(){window.location='?p=profil';});</script><?php
}

?>
