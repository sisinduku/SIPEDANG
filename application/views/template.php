<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="<?php echo base_url("/assets/favicon.ico");?>" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>SiPedang</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/global.css')?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body role="document">

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url("/"); ?>">
	        <img alt="Brand" src="<?php echo base_url("/assets/images/undip_70.png"); ?>" id="sipedang_imglogo">
	      </a>
          <a class="navbar-brand" href="<?php echo base_url("/"); ?>">SiPedang</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">Kategori</a></li>
            <li><a href="#contact">Kalender</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" role="main" id="sipedang_body">
		<div class="row">
			<img src="<?php echo base_url("/assets/images/header_home.jpg"); ?>" alt="SiPedang" style="width:100%;" />
			<ol class="breadcrumb">
			  <li><a href="<?php echo base_url("/"); ?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
			  <li><a href="#">Page 1</a></li>
			  <li class="active">Data</li>
			</ol>
		</div>
		<div class="row">
			<div class="col-md-8" id="sipedang_mainbody">
			<div class="well">
				<h3>Kegiatan Terdekat:</h3>
		<?php
		if (!empty($kegiatanTerdekat[0])) {
			$waktuKegiatan = strtotime($kegiatanTerdekat[0]->waktuMulaiPinjam);
			echo "Nama kegiatan: ".htmlspecialchars($kegiatanTerdekat[0]->kegiatan)."<br>\n";
			echo "Oleh: ".htmlspecialchars($kegiatanTerdekat[0]->penyelenggara)."<br>\n";
			
			echo $this->load->tanggalIndonesia($waktuKegiatan, true, false);
			echo date("H:i", $waktuKegiatan);
		}
		
		?>
			</div>
				
		<ul class="media-list">
		<?php
		foreach ($kegiatanTerdekat as $itemKegiatan) {
			echo "<li class=\"media\">\n";
			echo "	<div class=\"media-left\">\n";
			echo "		<a href=\"#\">\n";
			echo "			<img class=\"media-object\" src=\"".base_url("/assets/images/hmif_32.png")."\"\n";
			echo "				alt=\"ICO\" style=\"width:32px;height:32px;\">\n";
			echo "		</a>\n";
			echo "	</div>\n";
			echo "	<div class=\"media-body\">\n";
			echo "		<h4 class=\"media-heading\"><a href=\"#\">".htmlspecialchars($itemKegiatan->kegiatan)."</a></h4>\n";
			echo "			<p>Oleh: ".htmlspecialchars($itemKegiatan->penyelenggara)."</p>\n";
			echo "	</div>\n";
			echo "</li>\n";
		}
		?>
				</ul>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">
				    	<span class="glyphicon glyphicon-calendar"></span> Kalendar Kegiatan</h3>
				  </div>
				  <div class="panel-body">
				    Kalender di sini
				  </div>
				</div>
				
				<div class="panel panel-default">
				  <div class="panel-heading">
				    <h3 class="panel-title">
				    	<span class="glyphicon glyphicon-list"></span> Cara Peminjaman</h3>
				  </div>
				  <div class="panel-body">
				    <ol>
				    	<li>Isi formulir</li>
				    	<li>Datang ke ruang jurusan (konfirmasi) dalam kurang dari 3 jam dari pemesanan</li>
				    	<li>Selesai</li>
				    </ol>
				  </div>
				</div>
			</div>
		</div> <!-- End of body row -->
		<div class="row" id="sipedang_footer">
			<div class="col-md-8">
				Link Terkait:<br>
			</div>
			<div class="col-md-4">
				Supported by...
			</div>
			<div class="divclear"></div>
		</div>
		<div class="row" id="sipedang_bottom">
			&copy; 2015 - SiPedang
		</div>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/assets/bower_components/jquery/dist/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('/assets/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
    
  </body>
</html>
