<?php defined('_JEXEC') or die;

// Load FullCalendar assets
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . '/modules/mod_gcalendar/media/fullcalendar/fullcalendar.min.css');
$document->addScript(JUri::root() . '/modules/mod_gcalendar/media/fullcalendar/lib/moment.min.js');
$document->addScript(JUri::root() . '/modules/mod_gcalendar/media/fullcalendar/fullcalendar.min.js');
$document->addScript(JUri::root() . '/modules/mod_gcalendar/media/fullcalendar/lang/de.js');
$document->addScript(JUri::root() . '/modules/mod_gcalendar/media/fullcalendar/gcal.js');
?>
<script>
	jQuery(document).ready(function($) {
		jQuery('#calendar').fullCalendar({
			googleCalendarApiKey: '<?php echo $params->get('api_key', null); ?>',
			events: {
				googleCalendarId: '<?php echo $params->get('calendar_id', null); ?>'
			},
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			timeFormat: 'H:mm',
			eventClick: function(event) {
				window.open(event.url, 'gcalevent', 'width=700,height=600');
				return false;
			},
			loading: function(bool) {
				$('#loading').toggle(bool);
			}
		});
	});
</script>
<div id="calendar"></div>
