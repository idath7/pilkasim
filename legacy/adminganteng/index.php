<?php
require_once 'Core/init.php';

if(!isset($_SESSION['admin'])){
	header('Location: login.php');
}else{
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="../Assets/css/bootstrap.min.css" rel="stylesheet">
<link href="../Assets/css/styles.css" rel="stylesheet">
<link rel="shortcut icon" href="../Assets/img/icon.png">

<!--Icons-->
<script src="../Assets/js/lumino.glyphs.js"></script>

<!-- Sweet Alert -->
<link href="../Assets/css/sweetalert.css" rel="stylesheet">
<script src="../Assets/js/sweetalert.min.js"></script>
<link href="../Assets/css/dataTables.bootstrap.css" rel="stylesheet">
</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"><span>E-Pilketos </span>Admin</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
						<?php
						$sesi = @$_SESSION['admin'];
						$tampil = tampil($sesi);
						$nama = mysqli_fetch_assoc($tampil);

						echo $nama['nama'];
						?>
						<span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a href="?p=profil">
								<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
								 Profil
								 </a>
							</li>
							<li role="presentation" class="divider"></li>
							<li>
								<a href="index.php">
								<svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>
								 Dashboard
								</a>
							</li>
							<li>
								<a href="?p=calon">
								<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
								 Calon
								</a>
							</li>
							<li>
								<a href="?p=data">
								<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>
								 Data Pemilih
								</a>
							</li>
							<li>
								<a href="?p=laporan">
								<svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg>
								 Laporan
								</a>
							</li><br>
							<li>
								<a href="../" target="_blank">
								<svg class="glyph stroked desktop"><use xlink:href="#stroked-desktop"/></svg>
								 Kunjungi Situs
								</a>
							</li>
							<li role="presentation" class="divider"></li>
							<li><a href="logout.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>

		</div><!-- /.container-fluid -->
	</nav>

	<div id="collapse" class="col-sm-3 col-lg-2 sidebar">
		<hr>
		<ul class="nav menu">
			<li>
				<a href="index.php">
				<svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg>
				 Dashboard
				</a>
			</li>
			<li>
				<a href="?p=calon">
				<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
				 Calon
				</a>
			</li>
			<li>
				<a href="?p=data">
				<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>
				 Data Pemilih
				</a>
			</li>
			<li>
				<a href="?p=laporan">
				<svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg>
				 Laporan
				</a>
			</li><br>
			<li>
				<a href="../" target="_blank">
				<svg class="glyph stroked desktop"><use xlink:href="#stroked-desktop"/></svg>
				 Kunjungi Situs
				</a>
			</li>
			<li role="presentation" class="divider"></li>
			<li>
				<a href="logout.php">
				<svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"/></svg>
				 Logout
				 </a>
			</li>
		</ul>

	</div><!--/.sidebar-->

<?php
	$p = @$_GET['p'];

	if($p == "") include 'Page/dashboard.php';
	else
		// Calon
		if($p == "calon") include 'Page/calon.php';
		else
			if($p == "edit_calon") include 'Page/edit_calon.php';
		else
			if($p == "add_calon") include 'Page/add_calon.php';
		else
			if($p == "del_calon") include 'Page/del_calon.php';
		else
			if($p == "del_all") include 'Page/del__calon.php';
	else
		// Data Pemilih
		if($p == "data") include 'Page/data.php';
		else
			if($p == "data_edit") include 'Page/data_edit.php';
		else
			if($p == "del_data") include 'Page/del_data.php';
		else
			if($p == "import") include 'Page/import.php';
	else
		// Profil
		if($p == "profil") include 'Page/profil.php';
		else
			if($p == "edit_admin") include 'Page/edit_admin.php';
		else
			if($p == "add_admin") include 'Page/add_admin.php';
		else
			if($p == "del_admin") include 'Page/del_admin.php';
	else
		// Laporan
		if($p == "laporan") include 'Page/laporan.php';
?>

	<script src="../Assets/js/jquery-3.1.0.min.js"></script>
	<script src="../Assets/js/bootstrap.min.js"></script>
	<script src="../Assets/js/jquery.dataTables.min.js"></script>
	<script src="../Assets/js/dataTables.bootstrap.min.js"></script>
	<script src="tinymce/tinymce.min.js"></script>
	<script src="../Assets/js/chartli.js"></script>
	<script src="../Assets/js/jquery.easeScroll.js"></script>
	<script type="text/javascript">
	$(document).ready(function () {

	//Import file excel
	window.setTimeout(function() {
	    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
	        $(this).remove();
	    });
	}, 5000);

	});
	</script>
	<script>
		try {
		setTimeout(function(){
			console.clear();
			console.log("%cWelcome!", "color: #000; font-size:45px; font-weight: bold; font-family: Arial");
			console.log("%cAda perlu sesuatu di console?", "color: blue; font-size:25px; font-weight: bold; font-family: Arial");
			console.log("%cJangan paste disini, code yang tidak Anda mengerti.", "color: red; font-size:20px; font-weight: bold; font-family: Arial");
		}, 1000);
		} catch(e) {

		}
	</script>
	<script>
		//easeScroll
		$("html").easeScroll();

		//Import
		$(document).ready(function(){
			// Sembunyikan alert validasi kosong
			$("#kosong").hide();
		});

		function del(){
			swal({
			    title: "Are you sure?",
				text: "Data akan di hapus",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				closeOnConfirm: false
			}, function(){ window.location='?p=del_data'; });
		}

		//Table
		$(function() { $('#tabel').dataTable(); });

		// Preview 1
		var loadFile1 = function(event) {
			var reader = new FileReader();
				reader.onload = function(){
					var output1 = document.getElementById('output1');
					output1.src = reader.result;
				};
			reader.readAsDataURL(event.target.files[0]);
		};

		// Preview 2
		var loadFile2 = function(event) {
			var reader = new FileReader();
				reader.onload = function(){
					var output2 = document.getElementById('output2');
					output2.src = reader.result;
				};
			reader.readAsDataURL(event.target.files[0]);
		};

		//Tambah calon
		tinymce.init({
			selector:"#visi",
			menubar: false,
		    plugins: ["preview wordcount advlist autolink lists link image charmap preview pagebreak searchreplace insertdatetime, fullscreen hr , table,  directionality, emoticons, textcolor, colorpicker, textpattern, code"],
		    toolbar: "undo redo | fontselect fontsizeselect | styleselect | bullist numlist | forecolor backcolor emoticons | preview wordcount",
		    convert_urls: false,
		    theme_advanced_font_sizes : "8px,10px,12px,14px,16px,18px,20px,24px,32px,36px",
		});

		tinymce.init({
			selector:"#misi",
			menubar: false,
		    plugins: ["preview wordcount advlist autolink lists link image charmap preview pagebreak searchreplace insertdatetime, fullscreen hr , table,  directionality, emoticons, textcolor, colorpicker, textpattern, code"],
		    toolbar: "undo redo | fontselect fontsizeselect | styleselect | bullist numlist | forecolor backcolor emoticons | preview wordcount",
		    convert_urls: false,
		    theme_advanced_font_sizes : "8px,10px,12px,14px,16px,18px,20px,24px,32px,36px",
		});

		//Style
		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){
		        $(this).find('em:first').toggleClass("glyphicon-minus");
		    });
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#collapse').collapse('hide')
		})
	</script>

	<!-- collumn chart -->
	<script>
		var chart = echarts.init(document.getElementById('chart'));
		window.onresize = chart.resize
		option =
		{
		    tooltip: { trigger: 'item'},
		    toolbox: { show: true, feature: { saveAsImage: { show: true } } },

		    calculable: true,
		    grid: { borderWidth: 0, y: 35, y2: 35, x: 30, x2: 30 },
		    xAxis: [
		        { type: 'category', show: true,
		            <?php $hasil = laporan(); ?>
		            data: [ <?php foreach($hasil as $row): echo "'".$row['nama']."',"; endforeach; ?> ]
		        }
		    ],

		    yAxis: [ { type: 'value', show: true } ],
		    series: [
		        { name: '', type: 'bar',
		        	itemStyle: {
		            	normal: {
		                    color: function (params) {
		                        // build a color map as your need.
		                        var colorList = [
		                          '#27ae60', '#2980b9', '#8e44ad', '#2c3e50',
		                          '#d35400', '#c0392b', '#bdc3c7', '#7f8c8d'
		                        ];
		                        return colorList[params.dataIndex]
		                    },
		                    label: { show: true, position: 'top', formatter: '{b}\n{c}' }
		                }
		            },
		            data: [ <?php foreach($hasil as $row): echo "'".$row['hasil']."',"; endforeach; ?> ],
		        }
		    ]
		};

		chart.setOption(option);
	</script>

</body>


</html>
<?php } ?>
