<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

?>

<h3 class="moduleheading moduleheading fullwidth"><?php echo JText::_('TPL_JOOMLADE_HEADING_NEWS'); ?></h3>

<div id="carousel-blog" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<?php for($i = 0; $i < count($this->lead_items); $i = $i + 3): ?>
		<li data-target="#carousel-blog" data-slide-to="<?php echo ($i / 3) ?>"  <?php if($i == 0) { echo 'class="active"'; } ?>></li>
		<?php endfor; ?>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<?php for($i = 0; $i < count($this->lead_items); $i = $i + 3): ?>
		<div class="item <?php if($i == 0) { echo 'active'; } ?>">
			<?php foreach(array_slice($this->lead_items, $i, 3) as $item): ?>
				<div class="col-md-4">
					<?php $images = json_decode($item->images); ?>

					<?php if($images->image_intro): ?>
						<img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $item->title; ?>" />
					<?php endif; ?>

					<h3><?php echo $item->title; ?></h3>

					<?php echo $item->introtext; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php endfor; ?>
	</div>

	<!-- Controls -->
	<a class="left carousel-control" href="#carousel-blog" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only"><?php echo JText::_('JPREV'); ?></span>
	</a>
	<a class="right carousel-control" href="#carousel-blog" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only"><?php echo JText::_('JNEXT'); ?></span>
	</a>
</div>
