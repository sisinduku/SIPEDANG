<div class="col-md-8">
	<div id="sipedang_kalendarreservasi"></div>
</div>
<div class="col-md-4">
	
</div>

<link href='<?php echo base_url("/assets/css/fullcalendar.min.css"); ?>' rel='stylesheet' />
<link href='<?php echo base_url("/assets/css/fullcalendar.print.css"); ?>' rel='stylesheet' media='print' />
<script src='<?php echo base_url("/assets/js/moment.min.js"); ?>'></script>
<script src='<?php echo base_url("/assets/js/fullcalendar.min.js"); ?>'></script>
<script>

	$(document).ready(function() {
	
		$('#sipedang_kalendarreservasi').fullCalendar({
			header: {
				left: 'prev next today',
				center: 'title',
				right: 'month, agendaWeek'
			},
			eventLimit: true, // allow "more" link when too many events
			events: {
				url: '<?php echo site_url("/ControlReservasi/ajax_get_listreservasi"); ?>',
				error: function() {
					//$('#script-warning').show();
					alert("Terjadi kesalahan.");
				}
			},
			loading: function(bool) {
				$('#sipedang_loadingbox').toggle(bool);
			},
			eventBackgroundColor: "#CEE4ED",
			eventTextColor: "#003751",
			eventBorderColor: "#CEE4ED",
			timeFormat: 'H:mm'
		});
		
	});

</script>
<div id="sipedang_loadingbox">
	<img src="<?php echo base_url("/assets/images/loader.gif"); ?>" alt="Loading..." /> Loading....
</div>