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
			timeFormat: 'H:mm',
			dayClick: function(date, jsEvent, view) {
				var tabel = $(this).closest('table');
				var sel = $(tabel).find("td");
				$(sel).css('background-color','none');
				$(this).css('background-color','none');
			},
			eventClick: function(calEvent, jsEvent, view) {
				detil_event(calEvent.id);
				return false;
		    }
		});
		
	});

</script>
<div id="sipedang_loadingbox">
	<img src="<?php echo base_url("/assets/images/loader.gif"); ?>" alt="Loading..." /> Loading....
</div>

<div class="modal fade" tabindex="-1" role="dialog"
	id="sipedang_dlg_detilevent">
	<div class="modal-dialog modal-lg">
		<div class="modal-dialog">
			<div class="modal-content">
				<div id="sipedang_dlg_loader">
					<div class="modal-body">
						<img src="<?php echo base_url("/assets/images/loader.gif")?>"
							alt="Loading..." /> <b>Loading....</b>
					</div>
				</div>
				<div id="sipedang_dlg_main">
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var activeId = 0;
	function detil_event(idEvent) {
		$('#sipedang_dlg_loader').show();
		$('#sipedang_dlg_main').hide();
		
		activeId = idEvent;
		$('#sipedang_dlg_detilevent').modal({
            keyboard: false,
            backdrop: 'static'
        });
		return false;
	}
	$(function() {
	    $('#sipedang_dlg_detilevent').on('shown.bs.modal',function(e){
	    	$.ajax({
		    	method: 'POST',
				url: "<?php echo site_url("/ControlReservasi/ajax_detil_kegiatan"); ?>",
				data:{id: activeId},
				type: 'html'
    		}).done(function(data) {
    			$('#sipedang_dlg_loader').hide();
    			$('#sipedang_dlg_main').html(data).show();
    		});
	    });
	});

	
  </script>