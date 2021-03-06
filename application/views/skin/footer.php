			</div> <!-- End of body row -->
		<div class="row" id="sipedang_footer" style="padding-top:25px;">
			<div class="col-md-8"> 
				<div class="panel panel-default" style="padding:0px">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="glyphicon glyphicon-link"></span> Tautan Terkait</h3>
					</div>
					<div class="panel-body">
					</div>
				</div>
			</div>
			<div class="col-md-4"> 
				<div class="panel panel-default" style="padding:0px">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="glyphicon glyphicon-flag"></span> Didukung Oleh</h3>
					</div>
					<div class="panel-body">
					</div>
				</div>
			</div>
			<div class="divclear"></div>
		</div>
		<div class="row" id="sipedang_bottom">
			&copy; 2015 - SIPEDANG
		</div>
    </div> <!-- /container -->

	<div id="sipedang_loadingbox">
		<img src="<?php echo base_url("/assets/images/loader.gif"); ?>" alt="Loading..." /> Loading....
	</div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/assets/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
	<!-- date-range-picker -->
    <script src="<?php echo base_url('/assets/js/daterangepicker.js')?>" type="text/javascript"></script>
	<!-- bootstrap time picker -->
    <script src="<?php echo base_url('/assets/js/bootstrap-timepicker.min.js')?>" type="text/javascript"></script>
    
    <?php if (isset($needJQueryUI)) { //======= BUTUH JQUERY-UI? ====== ?>
	<script type='text/javascript' src='<?php echo base_url('/assets/js/jquery-ui.min.js'); ?>'></script>
	<script type='text/javascript' src='<?php echo base_url('/assets/js/datepicker-id.js'); ?>'></script>
	<?php } //========================================================= ?>
	
	<script>
	$(document).ready(function(){
<?php if (!isset($hideFormReservasi)) { //=============== Jika form reservasi ditampilkan ======== ?>
		$('#sipedang_waktupelaksanaan').daterangepicker({
			format: 'YYYY-MM-DD HH:mm',
			timePicker: true,
			timePicker12Hour: false,
			dateLimit: { days: 2 },
			opens: 'left',
			drops: 'down',
			timePickerIncrement: 10,
		    minDate: '<?php echo date("Y/m/d"); ?>',
		    maxDate: '<?php echo date("Y/m/d", strtotime("+1 month")); ?>'
		},function(start, end, label) {
	        $('#sipedang_tglmulai').val(start.format('YYYY-MM-DD HH:mm'));
	        $('#sipedang_tglselesai').val(end.format('YYYY-MM-DD HH:mm'));
	    });
<?php } //================ END IF ============================ ?>
		if (typeof(initPage)==='function') initPage();
	});
	function toggle_form() {
		$("#sipedang_ctr_formreservasi").slideToggle(500, 'easeInOutQuint');
		return false;
	}
	function toggle_form_upload_surat()
	{
		$("#sipedang_ctr_formuploadsurat").slideToggle(500, 'easeInOutQuint');
		return false;
	}
  	</script>
  </body >
</html >
