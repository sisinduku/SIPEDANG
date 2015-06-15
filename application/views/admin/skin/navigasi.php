		<!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url("/pengelola");?>">Peminjaman Ruang Sidang Informatika</a>
                <p class="navbar-text">Login sebagai:
                	<b><?php if (isset($loggedInUser)) echo htmlspecialchars($loggedInUser); ?></b></p>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">              
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:#fff;">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Ganti Kata sandi</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo site_url("/ControlAutentikasi/logout"); ?>">
                        	<i class="fa fa-sign-out fa-fw"></i> Keluar</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            
            <!-- /.navbar-top-links -->
			<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo site_url('pengelola/ControlReservasi/dasbor')?>">
                            	<span class="fa fa-home"></span> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><span class="fa fa-list"></span> Overview Reservasi</a>
                            <ul class="nav nav-second-level">
                            	<li>
                                    <a href="<?php echo site_url('pengelola/ControlReservasi/list_reservasi/pending')?>">
                                    	<span class="fa fa-warning"></span> Pending</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('pengelola/ControlReservasi/list_reservasi/approved')?>">
                                    	<span class="fa fa-check"></span> Approved</a>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('pengelola/ControlReservasi/list_reservasi/archive')?>">
                                    	<span class="fa fa-folder"></span> Archived</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="<?php echo site_url('/ControlAutentikasi/ubah_password')?>">
                            	<span class="fa fa-key"></span> Ubah Password</a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('/ControlAutentikasi/logout')?>">
                            	<span class="fa fa-power-off"></span> Log out</a>
                        </li>
                        <li style="text-align: center; color: #BFBFBF; padding-top: 10px;font-size:0.9em;">
                            <p>SiPedang v.0.5 beta &copy; 2015</p>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">    