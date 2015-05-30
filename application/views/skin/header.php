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
			<ol class="breadcrumb">
			  <li><a href="<?php echo base_url("/"); ?>"><span class="glyphicon glyphicon-home"></span> Home</a></li>
			  <li><a href="#">Page 1</a></li>
			  <li class="active">Data</li>
			</ol>
		</div>
		<div class="row" id="sipedang_mainbody">