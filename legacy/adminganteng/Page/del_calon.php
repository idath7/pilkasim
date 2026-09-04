<?php 

	if(isset($_GET['id'], $_GET['f'])){
		if(file_exists($_GET['f'])){
			unlink($_GET['f']);

			if(del_calon($_GET['id'])){
				?><script>
				swal({title: "Sukses!",text: "Data berhasil dihapus",type:"success"}, 
				function(){window.location='?p=calon';});
				</script><?php
			}else{
				?><script>
				swal({title: "Oops...",text: "Ada masalah saaat menghapus data",type:"error"}, 
				function(){window.location='?p=calon';});
				</script>
				<?php
			}
			
		}else{
			?><script>
			swal({title: "Oops...",text: "Ada masalah saaat menghapus foto",type:"error"}, 
			function(){window.location='?p=calon';});
			</script><?php
		}
	}

?>