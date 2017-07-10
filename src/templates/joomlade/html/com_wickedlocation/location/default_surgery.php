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

<div id="cbf-surgery" class="cbf-surgery row_fluid">
	<table class="table-condensed table-hover">

		<?php if (!empty($item->surgery_medical_centre)): ?>
		<tr>
            <td colspan="2"><?php echo $this->escape($item->surgery_medical_centre); ?></td>
		</tr>
		<?php endif; ?>

		<tr><td colspan="2"><strong>Eingangsbereich</strong></td></tr>

		<?php $not = $item->surgery_main_entrance ? '' : '<strong> nicht </strong>'; ?>
		<tr><td colspan="2">Rollstuhlfahrer können <strong> nicht </strong> den Haupteingang benutzen </td></tr>
        <tr><td colspan="2"><strong>Hauseingang</strong></td></tr>

		<tr><td>Stufen</td><td><?php
                if (!empty($item->surgery_main_entrance_steps)):
                    echo $item->surgery_main_entrance_steps;
                else:
                    echo 'keine';
            ?></td></tr>
		<?php endif; ?>

		<tr><td colspan="2"><?php echo $item->surgery_main_entrance_door; ?></td>
		</tr>
		<?php  if (!empty($item->surgery_main_entrance_step)):?>
		<tr>
			<td>Stufe</td>
            <td><?php echo $item->surgery_main_entrance_step; ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_main_entrance_doorstep)):?>
		<tr>
			<td>Schwelle</td>
            <td><?php echo $item->surgery_main_entrance_doorstep; ?> cm</td></tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_ramp_length)):?>
		<tr>
			<td> Rampe </td>
			<td>
				Länge: <?php echo trim($item->surgery_ramp_length); ?> m
				<br />
				<?php if (!empty($item->surgery_ramp_height)):
					echo ' Höhe: ' . trim($item->surgery_ramp_height) . ' cm <br />';
				endif; ?>
				Steigung: <?php echo trim($item->surgery_ramp_incline); ?> %
			</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->surgery_door1_width)):?>
		<tr>
			<td><strong>Türbreite</strong></td>
            <td><?php echo $item->surgery_door1_width; ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->surgery_door1_opens) && $item->surgery_door1_opens != 'nz' ):?>
		<tr>
			<td>Türe öffnet nach</td>
			<td>
				<?php
				switch ($item->surgery_door1_opens):
				 case 'auto':
					 echo 'Automatiktür';
					 break;
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
					 echo $item->surgery_door1_opens;
					 break;
				endswitch; ?>
			</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->surgery_door1_grip)):?>
		<tr>
			<td>Höhe des Türgriffs</td>
            <td><?php echo $item->surgery_door1_grip; ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->surgery_bell)):?>
		<tr>
			<td>Höhe der Türklingel</td>
            <td><?php echo $item->surgery_bell; ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->surgery_floor)):?>
		<tr>
			<td>Stockwerk</td>
            <td><?php echo $item->surgery_floor; ?></td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_main_entrance_step)):?>
		<tr>
			<td>Stufe</td>
            <td><?php echo $item->surgery_main_entrance_step; ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->surgery_step_inside)):?>
		<tr>
			<td>Weitere Stufen</td>
            <td><?php echo $item->surgery_more_step_inside; ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->surgery_doorstep_inside)):?>
		<tr>
			<td>Weitere Stufe</td>
            <td><?php echo $item->surgery_surgery_doorstep_inside; ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->surgery_step4)):?>
		<tr>
			<td>Weitere Stufe</td>
            <td><?php echo $item->surgery_step4; ?> cm</td>
		</tr>
		<?php endif; ?>

        <?php if (!empty($item->surgery_lift)): ?>
            <tr>
                <td colspan="2"><strong>Aufzug</strong></td>
            </tr>
            <tr colspan="2"><td>
            <?php
				switch ($item->surgery_lift):
				 case '1':
					 echo 'Lift entsprechend DIN';
					 break;
				 case '2':
					 echo 'Lift kleiner als DIN';
					 break;
				 case '0':
					 echo 'Kein Lift benötigt, da im Erdgeschoß';
					 break;
				endswitch; ?>
            </td></tr>
			<?php if (!empty($item->surgery_lift_door)): ?>
            <tr>
                <td>Türbreite</td>
                <td><?php echo $item->surgery_lift_door; ?> cm</td>
            </tr>
			<?php endif; ?>
			<?php if (!empty($item->surgery_lift_width)): ?>
            <tr>
                <td>Breite</td>
                <td><?php echo $item->surgery_lift_width; ?> cm</td>
            </tr>
			<?php endif; ?>
			<?php if (!empty($item->surgery_lift_depth)): ?>
            <tr>
                <td>Tiefe</td>
                <td><?php echo $item->surgery_lift_depth; ?> cm</td>
            </tr>
			<?php endif; ?>
			<?php if (!empty($item->surgery_lift_call_knob)): ?>
            <tr>
                <td>Rufknopf</td>
                <td><?php echo $item->surgery_lift_call_knob; ?>cm</td>
            </tr>
			<?php endif; ?>
			<?php if (!empty($item->surgery_lift_floor_knob)): ?>
            <tr>
                <td>Kopf zum Praxistockwerk</td>
                <td><?php echo $item->surgery_lift_floor_knob; ?> cm</td>
            </tr>
			<?php endif; ?>
        <?php endif; ?>

		<tr>
            <td colspan="2" style="background-color: #DDF0FB;"><strong>Praxiseingang</strong></td>
		</tr>
        <?php  if (!empty($item->surgery_door2)):?>
		<tr>
            <td>Türbreite</td>
			<td colspan="2"><?php echo $item->surgery_door2 ?> cm</td>
		</tr>
        <?php endif; ?>

		<?php  if (!empty($item->surgery_door2_type)):?>
		<tr>
			<td>Türtyp</td>
            <td><?php echo $item->surgery_door2_type; ?></td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->surgery_door2_opens) && $item->surgery_door2_opens != 'nz' ):?>
		<tr>
			<td>Türe öffnet nach</td>
			<td>
				<?php
				switch ($item->surgery_door2_opens):
				 case 'auto':
					 echo 'Automatiktür';
					 break;
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

		<?php if (!empty($item->surgery_door2_bell)):?>
		<tr>
			<td>Klingel</td>
            <td><?php echo $item->surgery_door2_bell; ?> cm</td>
		</tr>
		<?php endif; ?>
		<?php if (!empty($item->surgery_door2_grip)):?>
		<tr>
			<td>Höhe des Türgriffs</td>
            <td><?php echo $item->surgery_door2_grip; ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_general_info)):?>
		<tr>
            <td colspan="2" style="background-color: #DDF0FB;"><strong>Was es sonst zu sagen gibt:</strong></td>
		</tr>
		<tr>
            <td colspan="2"><?php echo $item->surgery_general_info; ?></td>
		</tr>
		<?php endif; ?>


        <?php
        // If there's no plan, there' no toilet

        if (!empty($item->surgery_wc_plan)): ?>
		<tr>
            <td colspan="2" style="background-color: #DDF0FB;"><strong>Toilette</strong></td>
		</tr>

		<?php  if (!empty($item->wc_wheelchair)):?>
			<tr>
				<td colspan="2">Die Praxis besitzt ein Rolli-WC</td>
			</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_wc_additional_info)):?>
			<tr>
				<td colspan="2"><?php echo $item->surgery_wc_additional_info; ?></td>
			</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_wc_additional_info)):?>
			<tr>
				<td colspan="2"><?php echo $item->surgery_wc_additional_info; ?></td>
			</tr>
		<?php endif; ?>

        <?php  if (!empty($item->surgery_wc_wheelchair)):?>
		<tr>
			<td colspan="2"><?php echo $item->surgery_wc_wheelchair ?> cm</td>
		</tr>
        <?php endif; ?>

		<?php if (!empty($item->surgery_wc_door_grip)):?>
		<tr>
			<td class="cbf-col1">Höhe des Türgriffs</td>
			<td><?php echo $this->escape(trim($item->surgery_wc_door_grip)); ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php if (!empty($item->surgery_wc_door_opens) && $item->surgery_wc_door_opens != 'nz' ):?>
		<tr>
			<td class="cbf-col1">Türe öffnet nach</td>
			<td>
				<?php
				switch ($item->surgery_wc_door_opens):
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

		<?php if (!empty($item->surgery_wc_door_width)):?>
		<tr>
			<td class="cbf-col1">Türbreite</td>
			<td><?php echo $this->escape(trim($item->surgery_wc_door_width)); ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_wc_room_width)):?>
			<tr>
				<td class="cbf-col1">Raum Breite</td>
				<td><?php echo $item->surgery_wc_room_width; ?> cm</td>
			</tr>
		<?php endif; ?>
		<?php  if (!empty($item->surgery_wc_room_depth)):?>
			<tr>
				<td class="cbf-col1">Raum Tiefe</td>
				<td><?php echo $item->surgery_wc_room_depth; ?> cm</td>
			</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_wc_diameter)):?>
			<tr>
				<td class="cbf-col1">Bewegungsfläche</td>
				<td><?php echo $item->surgery_wc_diameter; ?> cm</td>
			</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_wc_seat)):?>
		<tr>
			<td class="cbf-col1">WC Sitzhöhe</td>
			<td><?php echo $this->escape(trim($item->surgery_wc_seat)); ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_wc_access_li)):?>
		<tr>
			<td class="cbf-col1">Rückwärts anfahrbar von links</td>
			<td><?php echo $this->escape(trim($item->surgery_wc_access_li)); ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_wc_access_re)):?>
		<tr>
			<td class="cbf-col1">Rückwärts anfahrbar von rechts</td>
			<td><?php echo $this->escape(trim($item->surgery_wc_access_re)); ?> cm</td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_wc_grip_num)):?>
		<tr>
			<td class="cbf-col1">Anzahl Bügel</td>
			<td><?php echo $this->escape(trim($item->surgery_wc_grip_num)); ?></td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_wc_grip_text)):?>
		<tr>
			<td class="cbf-col1">Bügel</td>
			<td><?php echo $item->surgery_wc_grip_text; ?></td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->surgery_wc_grip_where) && $item->surgery_wc_grip_where != 'none' && $item->wc_wheregrip != ''):
		?>
		<tr>
			<td class="cbf-col1">Bewegliche Bügel</td>
			<td>
			<?php
			 switch ($item->surgery_wc_grip_where):
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

        <?php if (!empty($item->wc_plan)):
            $foto = trim(str_replace('.jpg', '', $item->wc_plan));
            $alt = $this->escape(trim($this->item->title)) . ' Plan'; ?>
            <img src="<?php echo $this->baseurl ."/images/surgery-wc/" . $foto .".jpg"; ?>"
                 alt="<?php echo $alt; ?>" />
        <?php endif; ?>

        <?php endif; ?>

	</table>
</div>