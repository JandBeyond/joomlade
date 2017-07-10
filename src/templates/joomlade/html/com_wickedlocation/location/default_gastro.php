<?php
/**
 * @package    Wicked.Location
 *
 * @author     Christiane Maier-Stadtherr <christiane.maier-stadtherr@wicked-chick.de>
 * @copyright  (c) 2014 Wicked-Chick Benjamin Trenkle. All rights reserved
 * @license    GNU General Public License version 2 or later; See LICENSE
 */

defined('_JEXEC') or die;
use Joomla\Registry\Registry;

$item = json_decode($this->item->additional_fields);

$af = array('a', 'b', 'c', 'd', 'e', 'f');
$gm = array('g', 'h', 'i', 'j', 'k', 'l', 'm');
$nz = array('n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
?>

<div id="cbf-gastro" class="cbf-gastro row_fluid">

	<?php  if (!empty($item->gastro_restauranttype)):?>
		<p><strong>
			<?php echo str_replace(',', ', ', trim(implode(',', $item->gastro_restauranttype))); ?>
		</strong><p>
	<?php endif; ?>

	<?php
		if (!empty($item->access_type) && $item->access_type != 'Für Rollstühle geeignet'):
			echo '<p><strong>' . $item->access_type . '</strong></p>';
		endif;
		if (!empty($item->gastro_steps)):
			echo '<p>' . $item->gastro_steps . '</p>';
		endif;
	?>

	<?php  if (!empty($item->gastro_price)):?>
			<p><strong>Preisniveau: </strong>
				<?php echo $item->gastro_price; ?> <p>
	<?php endif; ?>

	<?php
		if (!empty($item->gastro_cuisine) || !empty($item->gastro_othercuisine)): ?>
			<p><strong>Küche: </strong>

					<?php
					$tmp = (!empty($item->gastro_cuisine)) ? implode(',', $item->gastro_cuisine) : '';
					$tmp .= (!empty($item->gastro_cuisine)) ? ', ' : '';
					$tmp .= (!empty($item->gastro_othercuisine)) ?  $item->gastro_othercuisine : '';
					echo str_replace(',', ', ', $tmp);
			?>
			</p>
		<?php endif; ?>

	<?php if (!empty($item->gastro_cuisinespecial)): ?>
		<p><strong>Spezialität: </strong><?php echo trim($item->gastro_cuisinespecial); ?> </p>
	<?php endif; ?>

	<dl>
		<?php if (!empty($item->gastro_arrival)): ?>
			<dt>Anfahrt: </dt>
			<dd><?php echo trim($item->gastro_arrival); ?> </dd>
		<?php endif; ?>

		<?php if (!empty($item->gastro_parking)): ?>
			<dt>Behindertenparkplätze </dt>
			<dd><?php echo $item->gastro_parking; ?> </dd>
		<?php endif; ?>

		<?php if (!empty($item->gastro_entrance)): ?>
			<dt>Eingang </dt>
			<dd><?php echo trim($item->gastro_entrance); ?> </dd>
		<?php endif; ?>

		<?php if (!empty($item->gastro_interior)): ?>
			<dt>Raum </dt>
			<dd><?php echo $item->gastro_interior; ?> </dd>
		<?php endif; ?>

		<?php if (!empty($item->gastro_outside)): ?>
			<dt>Außen </dt>
			<dd><?php echo $item->gastro_outside; ?> </dd>
		<?php endif; ?>

		<?php if (isset($item->gastro_accesstype) && !empty($item->gastro_accesstype)): ?>
			<dt>Zugang </dt>
			<dd><?php echo $item->gastro_accesstype; ?> </dd>
		<?php endif; ?>

		<?php if (!empty($item->gastro_access_interior)): ?>
			<dt>Raum </dt>
			<dd><?php echo $item->gastro_access_interior; ?> </dd>
		<?php endif; ?>
	</dl>
	<?php if (!empty($item->gastro_wc)): ?>
	<div class="row-fluid gastro-wcs">
			<p><strong>Toiletten</strong><p>
			<p>
			<?php
					$registry = new Registry;
					$registry->loadString($item->gastro_wc);
					$tmp = $registry->toArray();
					$wcs = $tmp['gastro_wc'];
					$wcnames = $tmp['gastro_wcname'];

					foreach ($wcs as $key => $wc):
							$link = JRoute::_('index.php?option=com_wickedlocation&view=location'
									. '&catid=' . $this->item->catslug
									. '&type=' . 'toilet'
									. '&id=' . $wcs[$key]);
							echo JHtml::_('link', $link, $wcnames[$key], array('class' => 'btn btn-success'));
					endforeach; ?>
			</p>
	</div>
	<?php endif; ?>
	<?php
	if (!empty($item->gastro_wc_id)):
		$link = JRoute::_('index.php?option=com_wickedlocation&view=location'
				. '&catid=' . $this->item->catslug
				. '&type=' . 'toilet'
				. '&id=' . $item->gastro_wc_id);
		echo '<p>' . JHtml::_('link', $link, 'Details zum WC', array('class' => 'btn btn-success')) . '</p>';
	endif; ?>

	</div>