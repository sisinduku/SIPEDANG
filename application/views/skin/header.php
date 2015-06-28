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
    
    <title><?php if (isset($pageTitle)) echo $pageTitle; else echo "Untitled"; ?> - SIPEDANG</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('/assets/bower_components/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('/assets/css/global.css')?>" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('/assets/css/flickity.css')?>" rel="stylesheet">
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="<?php echo base_url('/assets/bower_components/jquery/dist/jquery.min.js')?>"></script>
    <script src="<?php echo base_url('/assets/js/jquery.easing.1.3.min.js')?>"></script>
    <script src="<?php echo base_url('/assets/js/flickity.pkgd.min.js')?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css/daterangepicker-bs3.css"); ?>" />
	
    <?php if (isset($needJQueryUI)) { //======= BUTUH JQUERY-UI? ====== ?>
	<link href="<?php echo base_url('/assets/css/jquery-ui.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('/assets/css/jquery-ui.theme.min.css'); ?>" rel="stylesheet">
	<?php } //========================================================= ?>
	<?php if (isset($pageAdditionalHead)) echo $pageAdditionalHead; ?>
  </head>

  <body role="document">

    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top" style="background-color: #686868; border: none;">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url("/"); ?>" style="color: #F5F5F5"><b><span class="glyphicon glyphicon-home"></span> SIPEDANG</b></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right" style="color: #F5F5F5">
            <li <?php if ($pageMenuId == 1) echo "class=\"active\""; ?>><a href="<?php echo site_url("/"); ?>">Home</a></li>
            <li <?php if ($pageMenuId == 2) echo "class=\"active\""; ?>><a href="<?php echo site_url("/reservasi/kategori"); ?>">Kategori</a></li>
            <li <?php if ($pageMenuId == 3) echo "class=\"active\""; ?>><a href="<?php echo site_url("/reservasi/tampil_kalender"); ?>">Kalender</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" role="main" id="sipedang_body">
		<div class="row">
			<img src="<?php echo base_url("/assets/images/header_home.png"); ?>" class="image" alt="SiPedang" style="width:100%;" />
		</div>
<?php if (!isset($hideFormReservasi)) { //=============== Jika form reservasi ditampilkan ======== ?>
		<div class="row" id="sipedang_ctr_formreservasi">
			<div class="col-lg-12">
				<div class="row">
					<form action="<?php echo site_url("/reservasi/form_reservasi"); ?>" method="post">
						<div class="row panel panel-default" style="margin: 10px 10px 0px 10px;">
							<div class="panel-heading">
								<h3 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> Formulir Reservasi</h3>
							</div>
							<div class="panel-body">
								<div class="col-md-6 form-horizontal">
									<div class="form-group">
										<label class="col-sm-3 control-label" for="sipedang_namakegiatan">Kegiatan</label>
										<div class="col-sm-9">
											<input type="text" required name="sipedang_namakegiatan" class="form-control"
												id="sipedang_namakegiatan" placeholder="Masukan Nama Kegiatan"
												value="<?php if (isset($sipedang_namakegiatan)) echo htmlspecialchars($sipedang_namakegiatan)?>"
												maxlength="128"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="sipedang_pemesan">Pemesan</label>
										<div class="col-sm-9">
											<input type="text" required name="sipedang_pemesan" class="form-control"
											id="sipedang_pemesan" placeholder="Masukan Nama Pemesan"
											value="<?php if (isset($sipedang_pemesan)) echo htmlspecialchars($sipedang_pemesan)?>"
											maxlength="64"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="sipedang_penyelenggara">Penyelenggara</label>
										<div class="col-sm-9">
											<input type="text" required name="sipedang_penyelenggara" class="form-control"
											id="sipedang_penyelenggara" placeholder="Masukan Penyelenggara"
											value="<?php if (isset($sipedang_penyelenggara)) echo htmlspecialchars($sipedang_penyelenggara)?>"
											maxlength="64"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="sipedang_kategori">Kategori</label>
										<div class="col-sm-9">
											<select name="sipedang_kategori" required class="form-control" id="sipedang_kategori" onchange="pilih_tambah_kategori()">
												<option value="">- Pilih Kategori Event -</option>
												<?php 
												$selectedKategori = (isset($sipedang_kategori)?$sipedang_kategori:0);
												foreach ($listKategori as $idx => $itemKategori) {
													echo "<option value=\"".$idx."\" ";
													if ($idx == $selectedKategori) echo "selected";
													echo ">".$itemKategori."</option>\n";
												}
												?>
											</select>
										</div>
									</div>
								</div> <!-- End col-6 -->
								
								<div class="col-md-6 form-horizontal" >
									<div class="form-group">
										<label class="col-sm-3 control-label" for="sipedang_waktupelaksanaan">Pelaksanaan</label>
										<div class="col-sm-9" id="sipedang_ctr_waktupelaksanaan">
											<input type="text" required name="sipedang_waktupelaksanaan" class="form-control"
												id="sipedang_waktupelaksanaan" placeholder="Waktu Pelaksanaan"
												value="<?php if (isset($sipedang_daterange)) echo htmlspecialchars($sipedang_daterange);?>"/>
											<input type="hidden" name="sipedang_tglmulai" id="sipedang_tglmulai"
												value="<?php if (isset($sipedang_tglmulai)) echo htmlspecialchars($sipedang_tglmulai); ?>" />
											<input type="hidden" name="sipedang_tglselesai" id="sipedang_tglselesai"
												value="<?php if (isset($sipedang_tglselesai)) echo htmlspecialchars($sipedang_tglselesai); ?>" />
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="sipedang_email">E-Mail</label>
										<div class="col-sm-9">
											<input type="email" required name="sipedang_email" class="form-control"
												id="sipedang_email" placeholder="Masukan E-Mail"
												value="<?php if (isset($sipedang_email)) echo htmlspecialchars($sipedang_email); ?>"
												maxlength="128"/>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="sipedang_kontak">Kontak</label>
										<div class="col-sm-9">
											<input type="text" required name="sipedang_kontak" class="form-control"
											id="sipedang_kontak" placeholder="Masukan Nomor Kontak"
											value="<?php if (isset($sipedang_kontak)) echo htmlspecialchars($sipedang_kontak); ?>"
											maxlength="16" pattern="[0-9+]+"/>
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
							</div>
						</div> <!-- End row form -->
					</form>
				</div> <!-- End row form -->
			</div> <!-- End col-12 -->
		</div>
		<!-- 
		<div class="row upload_surat" id="sipedang_ctr_formuploadsurat">
			<div class="col-sm-12">
				<div class="row">
					<form action="" method="post">
						<div class="row panel panel-default" style="margin: 10px 10px 0px 10px;">
							<div class="panel-heading">
								<h3 class="panel-title"><span class="glyphicon glyphicon-upload"></span> Upload Surat Bukti Reservasi</h3>
							</div>
							<div class="panel-body">
								<div class="col-md-6 form-horizontal">
									<div class="form-group">
										<label class="col-sm-4 control-label" style="text-align:left;" for="sipedang_namakegiatan">Kode Reservasi </label>
										<div class="col-sm-6">
											<input type="text" required name="sipedang_kode_reservasi" class="form-control"
												id="sipedang_kode_reservasi" placeholder="Masukan Kode Reservasi"
												/>
										</div>
									</div>
								</div>
								<div class="col-md-6 form-horizontal">
									<div class="form-group">
										<label class="col-sm-6 control-label" for="sipedang_namakegiatan">Upload Surat Bukti Reservasi</label>
										<div class="col-sm-6" style="padding-top: 5px;">
											<input type="file" required name="sipedang_upload_surat"
												id="sipedang_upload_surat"/>
										</div>
									</div>
								</div>
								
							</div>
							<div class="row" style="margin:auto;">
								<button style="width: 200px; margin: auto;" type="submit" name="sipedang_btnsubmit_uploadSurat" class="btn btn-primary btn-md btn-block">Submit</button>
							</div>
						</div>
						
					</form>
				</div>
			</div>
		</div>
		 -->
		<div class="row" style="background-color:#F5F5F5;border-bottom: solid 1px #CCCCCC;">
			<div class="col-sm-8">
				
			</div>
			<div class="col-sm-4">
				<button onclick="return toggle_form();" type="button" class="btn btn-info" style="margin: 5px; background-color: #686868; border: none;"><b>Formulir Reservasi</b>  <span class="glyphicon glyphicon-menu-down"></span></button>
				<!-- <button onclick="return toggle_form_upload_surat();" type="button" class="btn btn-info" style="margin: 5px; background-color: #686868; border: none;">
					<i class="glyphicon glyphicon-upload" style="margin-right:5px;"></i><b>Unggah Surat</b></button>  -->
			</div>
		</div>
<?php } //================ END IF ============================ ?>
		<ol class="breadcrumb" style="margin-top: 15px;">
		  <li><a href="<?php echo base_url("/"); ?>"><span class="glyphicon glyphicon-home"></span> Beranda</a></li>
		  <!-- <li><a href="#">Reservasi</a></li>
		  <li class="active">Data</li>  -->
		</ol>
		<div class="row" id="sipedang_mainbody">
		
