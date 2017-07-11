<?php
/**
 * @package    Wicked.Location
 *
 * @author     Christiane Maier_Stadtherr <christiane.maier_stadtherr@wicked_chick.de>
 * @copyright  (c) 2014 Wicked_Chick Benjamin Trenkle. All rights reserved
 * @license    GNU General Public License version 2 or later; See LICENSE
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

$item = json_decode($this->item->additional_fields);
?>

<div id="cbf-swim" class="cbf-swim row_fluid">

	<?php if (!empty($item->swim_fotos)):
		$fotos = explode(',', $item->swim_fotos); ?>
		<div class="row-fluid">
			<?php foreach ($fotos as $i => $foto) : ?>
					<img class="span6"
						src="<?php echo $this->baseurl ."/images/swim/" . trim(str_replace('.jpg', '', $foto)) .".jpg"; ?>"
						alt="<?php echo $this->escape(trim($this->item->title)) . ' Foto' . $i; ?>"/>
				<?php if ($i % 2 == 1) : ?>
					</div><div class="row-fluid">
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div class="description">
	<dl>
	<?php if (!empty($item->swim_price)): ?>
		<dt>Preis: </dt>
		<dd><?php echo trim($item->swim_price); ?></dd>
	<?php endif; ?>

	<?php if (!empty($item->swim_beforeafter)): ?>
		<dt>Vor und nach dem Schwimmen: </dt>
		<dd><?php echo implode(', ' ,$item->swim_beforeafter); ?></dd>
	<?php endif; ?>

	<?php if (!empty($item->swim_enterpool)): ?>
		<dt>Einstieg ins Wasser: </dt>
		<dd><?php echo implode(', ' ,$item->swim_enterpool); ?></dd>
	<?php endif; ?>

	<?php if (!empty($item->swim_arrival)): ?>
		<dt>Anfahrt: </dt>
		<dd><?php echo $item->swim_arrival; ?></dd>
	<?php endif; ?>

	<?php if (!empty($item->swim_parking)): ?>
		<dt>Behindertenparkplätze: </dt>
		<dd><?php echo $item->swim_parking; ?></dd>
	<?php endif; ?>

	<?php if (!empty($item->swim_entrance)): ?>
		<dt>Eingang: </dt>
		<dd><?php echo $item->swim_entrance; ?></dd>
	<?php endif; ?>

	<?php  if (!empty($item->swim_ramp_length)):?>
		<dt>Rampe: </dd>
		<dd>Länge: <?php echo trim($item->swim_ramp_length); ?> m,
			Steigung: <?php echo trim($item->swim_ramp_incline); ?> %</dd>
	<?php endif; ?>

	<?php if (!empty($item->swim_change)): ?>
		<dt>Umkleide: </dt>
		<dd><?php echo $item->swim_change; ?></dd>
	<?php endif; ?>
	</dl>
	</div>
	<?php if (!empty($item->swim_fotoshower)):
		$fotos = explode(',', $item->swim_fotoshower); ?>
		<div class="row-fluid">
			<?php foreach ($fotos as $i => $foto) : ?>
				<img class="span6"
					src="<?php echo $this->baseurl ."/images/swim/" . trim(str_replace('.jpg', '', $foto)) .".jpg"; ?>"
					alt="<?php echo $this->escape(trim($this->item->title)) . ' Foto' . $i; ?>"/>
				<?php if ($i % 2 == 1) : ?>
					</div><div class="row-fluid">
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div class="description">
	<dl>
	<?php if (!empty($item->swim_shower)): ?>
		<dt>Dusche: </dt>
		<dd><?php echo $item->swim_shower; ?></dd>
	<?php endif; ?>

	<?php if (!empty($item->swim_jumpin)): ?>
		<dt>Einstiegsmöglichkeit: </dt>
		<dd><?php echo $item->swim_jumpin; ?></dd>
	<?php endif; ?>

	<?php if (!empty($item->swim_water)): ?>
		<dt>Wasser: </dt>
		<dd><?php echo trim($item->swim_water); ?></dd>
	<?php endif; ?>

	<?php if (!empty($item->swim_gastro)): ?>
		<dt>Gastronomie: </dt>
		<dd><?php echo $item->swim_gastro; ?></dd>
	<?php endif; ?>

	<?php if (!empty($item->swim_wc)): ?>
		<dt></dt>
		<dd>
		<?php
			$registry = new Registry;
			$registry->loadString($item->swim_wc);
			$tmp = $registry->toArray();
			$wcs = $tmp['swim_wc'];
			$wcnames = $tmp['swim_wcname'];

			foreach ($wcs as $key => $wc):
				$link = JRoute::_('index.php?option=com_wickedlocation&view=location'
						. '&catid=' . $this->item->catslug
						. '&type=' . 'toilet'
						. '&id=' . $this->escape($wcs[$key] . ':' . $wcnames[$key]));
				echo JHtml::_('link', $link, $wcnames[$key], array('class' => 'btn btn-success'));
			endforeach;
		?>
		</dd>
	<?php endif; ?>
	</dl>
	</div>
</div>