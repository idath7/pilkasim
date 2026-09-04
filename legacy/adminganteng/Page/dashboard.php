<title>Dashboard | E-Pilkasim</title>	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">Dashboard</h2>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked sound on"><use xlink:href="#stroked-sound-on"/></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">
								<?php  
									$masuk  = mysqli_num_rows(sudah());
									$jumlah = mysqli_num_rows(jumlah());
									
									if(($masuk && $jumlah) > 0 ){
										$hasil  = ($masuk/$jumlah) * 100;
										echo substr($hasil, 0,4).'%';
									}else{
										echo "0%";
									}

								?>
							</div>
							<div class="text-muted">Suara Masuk</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?=mysqli_num_rows(jumlah()); ?></div>
							<div class="text-muted">Jumlah Pemilih</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"/></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?=mysqli_num_rows(sudah()); ?></div>
							<div class="text-muted">Sudah Memilih</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"/></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"><?=mysqli_num_rows(belum()); ?></div>
							<div class="text-muted">Belum Memilih</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">Grafik Perolehan Suara Pemilihan Ketua OSIM - MAS WAHID HASYIM BALUNG <?=date('Y'); ?></div>
					<div class="panel-body">
						<div id="chart" style="width: 100%;height:400px;"></div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
	</div>