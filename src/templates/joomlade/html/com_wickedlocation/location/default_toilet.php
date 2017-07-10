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


<div id="cbf-wc" class="cbf-wc description row_fluid">

	<table class="table-condensed table-hover">

		<?php  if (!empty($item->wc_location)):?>
		<tr>
			<td colspan="2"><?php echo  $item->wc_location; ?></td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->wc_ramp_length)):?>
		<tr>
			<td class="wc-col1"> Rampe </td>
			<td>
				Länge: <?php echo trim($item->wc_ramp_length); ?> m
				<br />
				Steigung: <?php echo trim($item->wc_ramp_incline); ?> %
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td colspan="2"><strong><br />Allgemeine Information zum WC</strong></td>
		</tr>
		<?php  if (!empty($item->wc_infos)):?>
		<tr>
			<td colspan="2"><?php echo $item->wc_infos; ?></td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->wc_doortaster)):?>
		<tr>
			<td class="wc-col1">Höhe des Tasters</td>
			<td><?php echo $this->escape(trim($item->wc_doortaster)); ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->wc_doorknob)):?>
		<tr>
			<td class="wc-col1">Höhe des Türgriffs</td>
			<td><?php echo $this->escape(trim($item->wc_doorknob)); ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php  if (isset($item->wc_doorsensor)):?>
			<tr>
				<td colspan="2">Tür öffnet automatisch</td>
			</tr>
		<?php endif; ?>

		<?php  if (!empty($item->wc_door_width)):?>
		<tr>
			<td class="wc-col1">Türbreite</td>
			<td><?php echo $this->escape(trim($item->wc_door_width)); ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->wc_dooropens) && $item->wc_dooropens != 'nz' ):?>
		<tr>
			<td class="wc-col1">Türe öffnet nach</td>
			<td>
				<?php
				switch ($item->wc_dooropens):
				 case 'sl':
					 echo 'links, Schiebetür';
					 break;
				 case 'sr':
					 echo 'rechts, Schiebetür';
					 break;
				 case 'al':
					 echo 'außen, Anschlag links';
					 break;
				 case 'ar':
					 echo 'außen, Anschlag rechts';
					 break;
				 case 'il':
					 echo 'innen, Anschlag links';
					 break;
				 case 'ir':
					 echo 'innen, Anschlag rechts';
					 break;
				 default:
					 echo 'nicht bekannt';
					 break;
				endswitch; ?>
			</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->wc_doorautopen) && $item->wc_doorautopen != 'nz' ):?>
		<tr>
			<td class="wc-col1">Automatiktür nach</td>
			<td>
				<?php
				switch ($item->wc_doorautopen):
				 case 'sl':
					 echo 'Schiebetür';
					 break;
				 case 'al':
					 echo 'außen, Anschlag links';
					 break;
				 case 'ar':
					 echo 'außen, Anschlag rechts';
					 break;
				 case 'il':
					 echo 'innen, Anschlag links';
					 break;
				 case 'ir':
					 echo 'innen, Anschlag rechts';
					 break;
				 default:
					 echo 'nicht bekannt';
					 break;
				endswitch; ?>
			</td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->wc_roominfos)):?>
			<tr>
				<td colspan="2"><?php echo $item->wc_roominfos; ?></td>
			</tr>
		<?php endif; ?>

		<?php  if (!empty($item->wc_room_diameter)):?>
			<tr>
				<td class="wc-col1">Bewegungsfläche</td>
				<td><?php echo $this->escape(trim($item->wc_room_diameter)); ?> cm</td>
			</tr>
		<?php endif; ?>
		<tr>
			<td colspan="2"><strong><br />Informationen zum WC-Becken</strong></td>
		</tr>

		<?php  if (!empty($item->wc_seat)):?>
		<tr>
			<td class="wc-col1">Sitzhöhe</td>
			<td><?php echo $this->escape(trim($item->wc_seat)); ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->wc_accessleft)):?>
		<tr>
			<td class="wc-col1">Anfahrt links</td>
			<td><?php echo $this->escape(trim($item->wc_accessleft)); ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->wc_accessright)):?>
		<tr>
			<td class="wc-col1">Anfahrt rechts</td>
			<td><?php echo $this->escape(trim($item->wc_accessright)); ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->wc_numgrip)):?>
		<tr>
			<td class="wc-col1">Anzahl Bügel</td>
			<td><?php echo $this->escape(trim($item->wc_numgrip)); ?></td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->wc_wheregrip) && $item->wc_wheregrip != 'none' && $item->wc_wheregrip != ''):
			?>
		<tr>
			<td class="wc-col1">Bewegliche Bügel</td>
			<td>
			<?php
			 switch ($item->wc_wheregrip):
				 case 'none':
					 echo '';
					 break;
				 case 'fr':
					 echo 'keine, nur ein fester Griff rechts';
					 break;
				 case 'fl':
					 echo 'keine, nur ein fester Griff links';
					 break;
				 case 'r':
					 echo 'rechts';
					 break;
				 case 'l':
					 echo 'links';
					 break;
				 case 'flr':
					 echo 'keine, aber zwei feste Griffe';
					 break;
				 case 'rfl':
					 echo 'rechts, links ist ein fester Griff';
					 break;
				 case 'lfr':
					 echo 'links, rechts ist ein fester Griff';
					 break;
				 case 'lr':
					 echo 'rechts und links';
					 break;
				 default:
					 echo 'nicht bekannt';
					 break;
			endswitch; ?>
			</td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->wc_addinfo)):?>
			<tr>
				<td colspan="2"><?php echo $item->wc_addinfo; ?></td>
			</tr>
		<?php endif; ?>
	</table>
</div>