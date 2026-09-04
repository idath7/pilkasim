<?php  

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
$databasetable = "data";

set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';


// This is the file path to be uploaded.
$inputFileName = $_GET['fn']; 
try {
		$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	} catch(Exception $e) {
		die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
	}


$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet


for($i=2;$i<=$arrayCount;$i++){
$a = $allDataInSheet[$i]["A"];
$b = $allDataInSheet[$i]["B"];
$c = $allDataInSheet[$i]["C"];
$d = $allDataInSheet[$i]["D"];
$e = $allDataInSheet[$i]["E"];

global $link;

$query = "INSERT INTO data (nis,nama2,nama,kelas,jk,status) VALUES('$c','$b','$a','$d','$e','1')";
$hasils = mysqli_query($link, $query);
if ($hasils) {

@unlink ("$inputFileName");
header("location:?p=data&msg=send");
}

}

?>