<?php
/**
 * @package    Wicked.Location
 *
 * @author     Christiane Maier-Stadtherr <christiane.maier-stadtherr@wicked-chick.de>
 * @copyright  Copyright (C) 2015 Wicked Software Benjamin Trenkle. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$nullDate	= JFactory::getDbo()->getNullDate();
$item		= $this->item;
$params		= $this->params;
?>

<?php if (isset($item->icons)): ?>

	<div class="wickedlocation-icons">

		<?php foreach ($item->icons as $icon):
			$attribs = array(
					'width'		=> $icon->width,
					'height'	=> $icon->height,
					'class'		=> 'icon hasTooltip',
					'title'		=> $icon->description
			);

			echo JHtml::_('image', $icon->icon, $icon->alt, $attribs);

		endforeach; ?>
	</div>
<?php endif; ?>
