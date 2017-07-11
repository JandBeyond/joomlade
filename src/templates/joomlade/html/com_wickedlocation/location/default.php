<?php
/**
 * @package    Wicked.Location
 *
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-chick.de>
 * @author     Christiane Maier-Stadtherr <christiane.maier-stadtherr@wicked-chick.de>
 * @copyright  Copyright (C) 2015 Wicked Software Benjamin Trenkle. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.caption');

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');

$item		= $this->item;
$state		= $this->state;
$attribs	= $this->item->attribs;

$user		= JFactory::getUser();

$printurl  = 'index.php?option=com_wickedlocation&task=location&view=location&id='
		. $this->escape($item->slug)
		. '&tmpl=component&print=1';
?>

<div id="wickedlocation" class="wickedlocation">
	<?php
	// Value from Menu-Params
	if ($this->params->get('show-page-heading','0')) :
		echo '<h1>' . $this->params->get('page_heading'). '</h1>';
	endif;

	if ($this->params->get('show_title','1')) :
		echo '<h2>' . $this->escape(trim($this->item->title)) . '</h2>';
	endif;
	?>

	<?php if ($this->params->get('print_button','1')) : ?>
		<?php if (!$this->print): ?>
			<div class="icons">
				<div class="btn-group pull-right">
					<a class="btn dropdown-toggle btn-warning" data-toggle="dropdown" href="#">
						<span class="icon-cog"></span>
						<span class="caret"></span>
					</a>
				</div>
			</div>
		<?php else: ?>
			<a class="btn btn-success pull-right"onclick="window.print();return false;" href="#"><?php echo JText::_('COM_WICKEDLOCATION_PRINT'); ?></a>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	if ($this->params->get('show_short_description', true) && !empty($item->short_description)):
		echo '<p class="short-descr">' . $this->escape($item->short_description) . '</p>';
	endif; ?>

	<?php if ($this->item->image->get('image')) :
				$attribs = array();
				$width  =  $this->item->image->get('width');
				$height =  $this->item->image->get('height');

				$attribs['width']	= !$width ? "100%" : $this->escape($width);
				$attribs['height']	= !$height ? "auto" : $this->escape($height);
				$attribs['class']	= $this->item->image->get('img-top');

				echo JHtml::_('image', $this->escape($this->item->image->get('image')), $this->escape($this->item->image->get('alt')), $attribs);

				if ($this->item->image->get('caption')) : ?>
					<figcaption class="caption small">
						<?php echo $this->escape($this->item->image->get('caption')); ?>
					</figcaption>
				<?php endif; ?>
	<?php endif; ?>

	<div class="row-fluid">
		<div class="span12">
			<div class="span8">
				<div class="info-block">
				<div class="wickedlocation-map-top">
					<?php if ($this->params->get('show_googlemap','none') == 'top' ) : ?>
							<?php echo $this->loadTemplate('map');?>
					<?php endif; ?>
				</div>

				<?php if (strlen($item->description)): ?>
					<div class="description clearfix">
						<?php echo $item->description; ?>
					</div>
				<?php endif;?>

				<?php echo $this->loadTemplate('additional'); ?>

				</div>
			</div>

			<div class="span4">
				<div class="addr-block">
					<?php echo $this->loadTemplate('icons'); ?>
					<?php echo $this->loadTemplate('address'); ?>

					<?php // todo: only if there is somthing to show ?>
					<?php echo $this->loadTemplate('details'); ?>
				</div>
			</div>
		</div>
	</div>

	<?php if ($this->params->get('show_googlemap','none') == 'bottom' ) : ?>
		<div class="wickedlocation-map-bottom">
			<?php echo $this->loadTemplate('map');?>
		</div>
	<?php endif; ?>

	<?php echo $this->item->event->pagination; ?>

</div>