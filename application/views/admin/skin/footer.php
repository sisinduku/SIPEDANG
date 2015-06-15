<?php if (!isset($simplePage)) { //==================== IF not SIMPLEMODE ================== ?>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    
    <div class="footer" style="background-color:black; padding: 10px; font-size:0.8em;color:#fff;text-align:center;">
        Copyright &copy; SIPEDANG
    </div>
<?php } //=============== END IF ======================== ?>
	
	<div id="sipedang_loadingbox">
		<img src="<?php echo base_url("/assets/images/loader.gif"); ?>" alt="Loading..." /> Loading....
	</div>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url('assets/bower_components/metisMenu/dist/metisMenu.min.js')?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('assets/dist/js/sb-admin-2.js')?>"></script>

</body >

</html >