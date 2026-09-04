<?php  

	if(del_data()){
		?><script>
		swal({title: "Sukses!",text: "Data berhasil dihapus",type:"success"}, function(){window.location='?p=data';});
		</script><?php
	}else{
		?><script>
		swal({title: "Oops...",text: "Ada masalah saaat menghapus data",type:"error"}, 
		function(){window.location='?p=data';});
		</script><?php
	}

?>