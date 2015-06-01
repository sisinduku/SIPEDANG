<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="<?php echo base_url("/assets/favicon.ico");?>" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title><?php if (isset($pageTitle)) echo $pageTitle; else echo "Untitled"; ?> - SiPedang</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/global.css')?>" rel="stylesheet">
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="<?php echo base_url('/assets/bower_components/jquery/dist/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('/assets/js/jquery.easing.1.3.min.js')?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css/daterangepicker-bs3.css"); ?>" />
	
    <?php if (isset($needJQueryUI)) { //======= BUTUH JQUERY-UI? ====== ?>
	<link href="<?php echo base_url('/assets/css/jquery-ui.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('/assets/css/jquery-ui.theme.min.css'); ?>" rel="stylesheet">
	<?php } //========================================================= ?>
	<?php if (isset($pageAdditionalHead)) echo $pageAdditionalHead; ?>
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
            <li <?php if ($pageMenuId == 1) echo "class=\"active\""; ?>><a href="<?php echo site_url("/"); ?>">Home</a></li>
            <li><a href="#about">Kategori</a></li>
            <li <?php if ($pageMenuId == 3) echo "class=\"active\""; ?>><a href="<?php echo site_url("/ControlReservasi/tampil_kalender"); ?>">Kalender</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" role="main" id="sipedang_body">
		<div class="row">
			<img src="<?php echo base_url("/assets/images/header_home.jpg"); ?>" alt="SiPedang" style="width:100%;" />
		</div>
<?php if (!isset($hideFormReservasi)) { //=============== Jika form reservasi ditampilkan ======== ?>
		<div class="row" id="sipedang_ctr_formreservasi">
			<div class="col-lg-12">
				<h3><span class="glyphicon glyphicon-pencil"></span> Formulir Reservasi Ruang Sidang</h3>
				<div class="row">
					<form action="<?php echo site_url("/ControlReservasi/form_reservasi"); ?>"
						method="post" id="sipedang_formreservasi">
						<div class="col-md-6 form-horizontal">
							<div class="form-group">
								<label class="col-sm-3 control-label" for="sipedang_namakegiatan">Kegiatan</label>
								<div class="col-sm-9">
									<input type="text" required name="sipedang_namakegiatan" class="form-control" id="sipedang_namakegiatan" placeholder="Masukan Nama Kegiatan"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="sipedang_pemesan">Pemesan</label>
								<div class="col-sm-9">
									<input type="text" required name="sipedang_pemesan" class="form-control" id="sipedang_pemesan" placeholder="Masukan Nama Pemesan"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="sipedang_penyelenggara">Penyelenggara</label>
								<div class="col-sm-9">
									<input type="text" required name="sipedang_penyelenggara" class="form-control" id="sipedang_penyelenggara" placeholder="Masukan Penyelenggara"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="sipedang_kategori">Kategori</label>
								<div class="col-sm-9">
									<select name="sipedang_kategori" required class="form-control" id="sipedang_kategori" onchange="pilih_tambah_kategori()">
										<option value="">- Pilih Kategori Event -</option>
										<option value="1">Seminar PKL</option>
										<option value="2">Seminar TA</option>
										<option value="3">Kegiatan Jurusan</option>
										<option value="4">Kegiatan Organisasi</option>
										<option value="5">Lain-Lain</option>
									</select>
								</div>
							</div>
						</div> <!-- End col-6 -->
						
						<div class="col-md-6 form-horizontal" >
							<div class="form-group">
								<label class="col-sm-3 control-label" for="sipedang_waktupelaksanaan">Pelaksanaan</label>
								<div class="col-sm-9" id="sipedang_ctr_waktupelaksanaan">
									<input type="text" required name="sipedang_waktupelaksanaan" class="form-control" id="sipedang_waktupelaksanaan" placeholder="Waktu Pelaksanaan"/>
									<input type="hidden" name="sipedang_tglmulai" id="sipedang_tglmulai" value="" />
									<input type="hidden" name="sipedang_tglselesai" id="sipedang_tglselesai" value="" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="sipedang_email">E-Mail</label>
								<div class="col-sm-9">
									<input type="email" required name="sipedang_email" class="form-control" id="sipedang_email" placeholder="Masukan E-Mail"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label" for="sipedang_kontak">Kontak</label>
								<div class="col-sm-9">
									<input type="text" required name="sipedang_kontak" class="form-control" id="sipedang_kontak" placeholder="Masukan Nomor Kontak"/>
								</div>
							</div>
							<div class="form-group">
								<div class=" col-sm-12">
								  <input type="hidden" name="sipedang_submit" value="<?php echo "submit-".date("Ymd-His"); ?>" />
								  <button type="submit" name="sipedang_btnsubmit" class="btn btn-primary btn-md btn-block">
								  	Daftar <span class="glyphicon glyphicon-chevron-right"></span> </button>
								</div>
							</div>
						</div>
						
					</form>
				</div> <!-- End row form -->
			</div> <!-- End col-12 -->
		</div>
		<div class="row" style="background-color:#F5F5F5;border-bottom: solid 1px #CCCCCC;">
			<div class="col-sm-8">
				
			</div>
			<div class="col-sm-4">
				<a href="#" onclick="return toggle_form();">Formulir Reservasi</a>
			</div>
		</div>
<?php } //================ END IF ============================ ?>
		<ol class="breadcrumb" style="margin-top: 15px;">
		  <li><a href="<?php echo base_url("/"); ?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
		  <li><a href="#">Page 1</a></li>
		  <li class="active">Data</li>
		</ol>
		<div class="row" id="sipedang_mainbody">