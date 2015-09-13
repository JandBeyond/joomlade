<?php
defined('_JEXEC') or die;
?>
<ul class="next-events">
	<?php foreach ($events AS $event) : ?>
		<li class="event" itemscope itemtype="http://schema.org/Event">
			<meta itemprop="startDate" content="<?php echo JDate::getInstance($event->startDate)->toISO8601(); ?>">
			<meta itemprop="endDate" content="<?php echo JDate::getInstance($event->endDate)->toISO8601(); ?>">
			<div class="event-duration">
				<?php echo ModGCalendarHelper::duration($event); ?>
			</div>
			<a href="<?php echo $event->htmlLink; ?>" target="_blank">
				<span class="event-title" itemprop="name">
					<?php echo $event->summary; ?>
				</span>
			</a>
			<?php if($params->get('show_location', false) && !empty($event->location)) : ?>
				<div class="event-location"><?php echo $event->location; ?></div>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>

