<?php
/**
 * @package    Wicked.Location
 *
 * @author     Christiane Maier_Stadtherr <christiane.maier_stadtherr@wicked_chick.de>
 * @copyright  (c) 2014 Wicked_Chick Benjamin Trenkle. All rights reserved
 * @license    GNU General Public License version 2 or later; See LICENSE
 */

defined('_JEXEC') or die;

$item = json_decode($this->item->additional_fields);
?>

<div id="dart" class="dart row_fluid">
	<p>
		<?php
			switch ($item->dart_smoke):
			 case '':
				 echo JText::_('COM_WICKEDLOCATION_DART_SMOKE_UNKNOWN');
				 break;
			 case 'no':
				 echo JText::_('COM_WICKEDLOCATION_DART_SMOKE_NO');
				 break;
			 case 'yes':
				echo JText::_('COM_WICKEDLOCATION_DART_SMOKE_ALWAYS');
				 break;
			 case 'noplay':
				 echo JText::_('COM_WICKEDLOCATION_DART_SMOKE_NOTCONTEST');
				 break;
		 endswitch; ?>
	</p>

	<?php if ($item->dart_num_steeldart && $item->dart_num_steeldart != '0'): ?>
	<p>
		<?php echo JText::sprintf('COM_WICKEDLOCATION_PLACES_STEELDART', $this->escape(trim($item->dart_num_steeldart))); ?>
	</p>
	<?php endif; ?>

	<?php if ($item->dart_num_edart && $item->dart_num_edart != '0'): ?>
	<p>
		<?php echo JText::sprintf('COM_WICKEDLOCATION_PLACES_EDART', $this->escape(trim($item->dart_num_edart))); ?>
	</p>
	<?php endif; ?>

	<?php if (!empty($item->dart_opening) || !empty($item->dart_training_adult)
			|| !empty($item->dart_training_youth) || !empty($item->dart_competitions)): ?>

	<table class="table table-condensed" >
	<tbody>
		<?php if (!empty($item->dart_opening)): ?>
			<tr><td colspan="4"><h3><?php echo JText::_('COM_WICKEDLOCATION_DART_OPENING'); ?> </h3></td></tr>
				<?php
				$registry = new JRegistry;
				$registry->loadString($item->dart_opening);
				$tmp = $registry->toArray();

				$days = $tmp['dart_open_days'];
				$from = $tmp['dart_open_from'];
				$to = $tmp['dart_open_to'];

				foreach ($days as $key => $day): ?>
					<tr>
						<td><?php echo $this->escape($tmp['dart_open_days'][$key]); ?></td>
						<td><?php echo $this->escape($tmp['dart_open_from'][$key]); ?></td>
						<td>
						<?php
						if (!empty($tmp['dart_open_from'][$key]) && !empty($tmp['dart_open_to'][$key])):
							echo JText::_('COM_WICKEDLOCATION_DART_TO');
						endif;
						?>
						</td>
						<td><?php echo $this->escape($tmp['dart_open_to'][$key]); ?></td>
					</tr>
				<?php endforeach; ?>
		<?php endif; ?>

		<?php if (!empty($item->dart_training_adult)): ?>
		<tr><td colspan="4"><h3><?php echo JText::_('COM_WICKEDLOCATION_DART_TRAINING_ADULT'); ?></h3></td></tr>
			<?php
			$registry = new JRegistry;
			$registry->loadString($item->dart_training_adult);
			$tmp = $registry->toArray();

			$days = $tmp['dart_training_adult_days'];
			foreach ($days as $key => $day): ?>
				<tr>
					<td><?php echo $this->escape($tmp['dart_training_adult_days'][$key]); ?></td>
					<td><?php echo $this->escape($tmp['dart_training_adult_from'][$key]); ?></td>
						<td>
						<?php
						if (!empty($tmp['dart_training_adult_from'][$key]) && !empty($tmp['dart_training_adult_to'][$key])):
							echo JText::_('COM_WICKEDLOCATION_DART_TO');
						endif;
						?>
						</td>
					<td><?php echo $this->escape($tmp['dart_training_adult_to'][$key]); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>


		<?php if (!empty($item->dart_training_youth)): ?>
				<tr><td colspan="4"><h3><?php echo JText::_('COM_WICKEDLOCATION_DART_TRAINING_YOUTH'); ?></h3></td></tr>

			<?php
			$registry = new JRegistry;
			$registry->loadString($item->dart_training_youth);
			$tmp = $registry->toArray();

			$days = $tmp['dart_training_youth_days'];
			foreach ($days as $key => $day): ?>
				<tr>
					<td><?php echo $this->escape($tmp['dart_training_youth_days'][$key]); ?></td>
					<td><?php echo $this->escape($tmp['dart_training_youth_from'][$key]); ?></td>
						<td>
						<?php
						if (!empty($tmp['dart_training_youth_from'][$key]) && !empty($tmp['dart_training_youth_to'][$key])):
							echo JText::_('COM_WICKEDLOCATION_DART_TO');
						endif;
						?>
						</td>
					<td><?php echo $this->escape($tmp['dart_training_youth_to'][$key]); ?></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>

	</tbody>
	</table>
	<?php endif; ?>

	<?php if (!empty($item->dart_competitions)): ?>
		<div class="dart-competitions">
			<h3><?php echo JText::_('COM_WICKEDLOCATION_DART_COMPETITIONS'); ?></h3>

			<?php
			$registry = new JRegistry;
			$registry->loadString($item->dart_competitions);
			$tmp = $registry->toArray();

			$competitions = $tmp['dart_competitions_title'];
			foreach ($competitions as $key => $comp): ?>
			<p>
				<strong>
					<?php echo $this->escape($tmp['dart_competitions_title'][$key]); ?>
					</strong>
					 -
					<?php echo $this->escape($tmp['dart_competitions_date'][$key]); ?>
				</p>
				<div class="span10 offset-2">
					<p><?php echo nl2br($this->escape($tmp['dart_competitions_description'][$key])); ?></p>
					<p>&nbsp;</p>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>


	<div class="dart-fotos">
	<?php
		if (!empty($item->dart_foto_folder)):
			$folder = JPATH_BASE . '/images/spielstaetten/'. $item->dart_foto_folder;

			if (JFolder::exists($folder)):

				$fotos = JFolder::files($folder);
				$width	= !empty($item->dart_foto_width) ? $this->escape($item->dart_foto_width) : "100%";
				$height = !empty($item->dart_foto_height) ? $this->escape($item->dart_foto_height) : "auto";

				foreach($fotos as $i => $foto): ?>

						<img
							width	= "<?php echo $width; ?>"
							height	= "<?php echo $height; ?>"
							class	= "img-polaroid"
							style	= "margin: 12px 12px 0 0;"
							src		= "<?php echo $this->baseurl . '/images/spielstaetten/' . $item->dart_foto_folder . '/' . trim($foto); ?>"
							alt		= "<?php echo $this->escape(trim($this->item->title)) . ' Foto' . $i; ?>"
						/>

				<?php endforeach;
			endif;
		endif; ?>
	</div>
	<p><br /><br /></p>
</div>
