<div class="col-md-8">
	<div id="calendar"></div>
</div>
<div class="col-md-4">
	
</div>

<link href='<?php echo base_url("/assets/css/fullcalendar.min.css"); ?>' rel='stylesheet' />
<link href='<?php echo base_url("/assets/css/fullcalendar.print.css"); ?>' rel='stylesheet' media='print' />
<script src='<?php echo base_url("/assets/js/moment.min.js"); ?>'></script>
<script src='<?php echo base_url("/assets/js/fullcalendar.min.js"); ?>'></script>
<script>

	$(document).ready(function() {
	
		$('#calendar').fullCalendar({
			header: {
				left: 'prev today',
				center: 'title',
				right: 'next'
			},
			eventLimit: true, // allow "more" link when too many events
			events: {
				url: '<?php echo base_url("/csi/ajax"); ?>',
				error: function() {
					$('#script-warning').show();
				}
			},
			loading: function(bool) {
				$('#loading').toggle(bool);
			},
			eventBackgroundColor: "#CEE4ED",
			eventTextColor: "#003751",
			eventBorderColor: "#CEE4ED"
		});
		
	});

</script>