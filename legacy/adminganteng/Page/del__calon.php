<?php
	if(del_semua_calon()){
		$files = glob('../Assets/img/calon/*');

		foreach ($files as $file) {
			if(is_file($file)) unlink($file);
		}

		?><script>
		swal({title: "Sukses!",text: "Data berhasil dihapus",type:"success"}, function(){window.location='?p=calon';});
		</script><?php
	}else{
		?><script>
		swal({title: "Oops...",text: "Ada masalah saaat menghapus data",type:"error"}, 
		function(){window.location='?p=calon';});
		</script><?php
	}
?>