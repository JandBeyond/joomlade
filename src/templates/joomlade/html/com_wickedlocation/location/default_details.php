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

$nullDate	= JFactory::getDbo()->getNullDate();
$item		= $this->item;
$params		= $this->params;

$author = $params->get('show_author') && !empty($item->author );
if ($author
	|| $params->get('show_category', '0')
	|| $params->get('show_publish_date', '0')
	|| $params->get('show_create_date', '0')
	|| $params->get('show_hits', '0')):
?>
	<div class="muted">
		<dl>
			<dt><?php echo JText::_('COM_WICKEDLOCATION_LOCATION_MISC'); ?></dt>

			<?php if ($params->get('show_category', '0')) : ?>
				<dd class="category-name">
					<i class="icon-folder"></i>
					<?php echo $this->escape($item->category); ?>
				</dd>
			<?php endif; ?>

			<?php if ($author) : ?>
				<dd>
					<i class="icon-user"></i>
					<?php echo JText::sprintf('COM_WICKEDLOCATION_WRITTENBY',$this->escape($item->author)); ?>
				</dd>
			<?php endif; ?>

			<?php if ($params->get('show_publish_date', '0')) : ?>
			<dd>
				<?php
					if ($item->publish_up == $nullDate):
						$tmp = JFactory::getDate($item->created)->format('Y-m-d');
					else:
						$tmp = JFactory::getDate($item->publish_up)->format('Y-m-d');
					endif;
				?>
				<i class="icon-calendar"></i>
					<?php echo JText::sprintf('COM_WICKEDLOCATION_PUBLISHED_DATE',
							JHtml::_('date', $tmp , JText::_('DATE_FORMAT_LC4'))); ?>
			</dd>
		<?php endif; ?>

		<?php if ($params->get('show_create_date', '0')) : ?>
			<dd>
				<i class="icon-calendar"></i>
					<?php
						$tmp = JFactory::getDate($item->created)->format('Y-m-d');
						echo JText::sprintf('COM_WICKEDLOCATION_CREATED_DATE', JHtml::_('date', $tmp, JText::_('DATE_FORMAT_LC4')));
					?>
			</dd>
		<?php endif; ?>

		<?php if ($params->get('show_modify_date', '0')) : ?>
			<dd>
				<?php if ($item->modified == $nullDate):
					$tmp = JFactory::getDate($item->created)->format('Y-m-d');
				else :
					$tmp = JFactory::getDate($item->modified)->format('Y-m-d');
				endif; ?>

				<i class="icon-calendar"></i>
					<?php echo JText::sprintf('COM_WICKEDLOCATION_LAST_UPDATED',JHtml::_('date', $tmp, JText::_('DATE_FORMAT_LC4'))); ?>
			</dd>
		<?php endif; ?>

		<?php if ($params->get('show_hits', '0')) : ?>
			<dd>
				<i class="icon-eye-open"></i>
					<?php echo JText::sprintf('COM_WICKEDLOCATION_HITS', (int) $item->hits); ?>
			</dd>
		<?php endif; ?>

		</dl>
	</div>
<?php endif; ?>