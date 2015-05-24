<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>Theme Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="../../dist/css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="theme.css" rel="stylesheet">

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

    <div class="container theme-showcase" role="main" style="margin-top: 50px;">
		
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
		  </ol>
		
		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		    <div class="item active">
		      <img src="<?php echo base_url("/assets/images/header.jpg"); ?>" alt="Sipedang">
		      <div class="carousel-caption">
		        ...
		      </div>
		    </div>
		    <div class="item">
		      <img src="<?php echo base_url("/assets/images/header.jpg"); ?>" alt="...">
		      <div class="carousel-caption">
		        ...
		      </div>
		    </div>
		    ...
		  </div>
		
		  <!-- Controls -->
		  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
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
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/assets/bower_components/jquery/dist/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('/assets/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
    
  </body>
</html>
