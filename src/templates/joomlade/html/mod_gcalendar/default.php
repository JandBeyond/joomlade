<?php
defined('_JEXEC') or die;
?>
<ul class="next-events">
	<?php foreach ($events AS $event) : ?>
		<li class="event" itemscope itemtype="http://schema.org/Event">
			<meta itemprop="startDate" content="<?php echo JDate::getInstance($event->startDate)->toISO8601(true); ?>">
			<meta itemprop="endDate" content="<?php echo JDate::getInstance($event->endDate)->toISO8601(true); ?>">
			<div class="event-name">
				<?php if($params->get('show_link', true)) : ?>
				<a href="<?php echo $event->htmlLink; ?>" target="_blank">
					<?php endif; ?>
					<span itemprop="name"><?php echo $event->summary; ?></span>
					<?php if($params->get('show_link', true)) : ?>
				</a>
			<?php endif; ?>
			</div>
			<div class="event-duration">
				<?php echo ModGCalendarHelper::duration($event); ?>
			</div>
			<?php if(!empty($event->location)): ?>
				<?php if($params->get('show_location', false)) : ?>
					<div class="event-location" itemprop="location" itemscope="" itemtype="http://schema.org/Text"><?php echo $event->location; ?></div>
				<?php else: ?>
					<meta itemprop="location" itemscope="" itemtype="http://schema.org/Text" content="<?php echo $event->location; ?>">
				<?php endif; ?>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>
