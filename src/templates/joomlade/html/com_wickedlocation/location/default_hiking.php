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

<div id="cbf-rw" class="cbf-rw row_fluid">

	<?php if (!empty($item->hiking_fotos)):
		$fotos = explode(',', $item->hiking_fotos); ?>
		<div class="row-fluid">
			<?php foreach ($fotos as $i => $foto) : ?>
					<img class="span6"
						src="<?php echo $this->baseurl ."/images/rw/" . trim(str_replace('.jpg', '', $foto)) .".jpg"; ?>"
						alt="<?php echo $this->escape(trim($this->item->title)) . ' Foto' . $i; ?>"/>
				<?php if ($i % 2 == 1) : ?>
					</div><div class="row-fluid">
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div class="description">

            <table class="table-condensed table-hover">

		<?php  if (!empty($item->hiking_start)):?>
		<tr>
			<td class="rw-col1"><strong>Startpunkt:</strong></td>
			<td><?php echo trim($item->hiking_start); ?> </td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->hiking_end)):?>
		<tr>
			<td class="rw-col1"><strong>Ziel:</strong></td>
			<td><?php echo trim($item->hiking_end); ?> </td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->hiking_length)):?>
		<tr>
			<td class="rw-col1"><strong>Streckenlänge:</strong></td>
			<td><?php echo trim($item->hiking_length); ?> </td>
		</tr>
		<?php endif; ?>

		<?php  if (!empty($item->hiking_difficulty)):?>
		<tr>
			<td class="rw-col1"><strong>Schwierigkeitsgrad:</strong></td>
			<td><?php echo $item->hiking_difficulty; ?> </td>
		</tr>
		<?php endif; ?>
            </table>
            <p></p>
            <p></p>


            <?php  if (!empty($item->hiking_description)):?>
            <p><?php echo $item->hiking_description; ?> </p>
            <?php endif; ?>

            <div class="row-fluid hiking-dates">
                <p><strong>Wir waren dort!</strong><p>
                <p>
                <?php
                if (!empty($item->hiking_dates)):
                        $registry = new Registry;
                        $registry->loadString($item->hiking_dates);
                        $tmp = $registry->toArray();

                        $rwdates = $tmp['hiking_dates'];
                        $rwnum = $tmp['hiking_participants'];

                        foreach ($rwdates as $key => $rw):
                                echo '<p>' . $rwdates[$key] . ', Teilnehmer: ' . $rwnum[$key] . '</p>';
                        endforeach;
                endif; ?>
                </p>
            </div>

            <?php if (!empty($item->hiking_wc)): ?>
            <div class="row-fluid hiking-wcs">
                    <p><strong>Rollitoiletten</strong><p>
                    <p>
                    <?php
                            $registry = new Registry;
                            $registry->loadString($item->hiking_wc);
                            $tmp = $registry->toArray();
                            $wcs = $tmp['hiking_wc'];
                            $wcnames = $tmp['hiking_wcname'];

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

            <?php if (!empty($item->hiking_gastro)): ?>
            <div class="row-fluid hiking-gastros">
                    <p><strong>Hier kann man sich stärken</strong><p>
                    <p>
                            <?php
                            $registry = new Registry;
                            $registry->loadString($item->hiking_gastro);
                            $tmp = $registry->toArray();
                            $gastros = $tmp['hiking_gastro'];
                            $gastronames = $tmp['hiking_gastroname'];

                            foreach ($gastros as $key => $gastro):
                                    $link = JRoute::_('index.php?option=com_wickedlocation&view=location'
											. '&catid=' . $this->item->catslug
											. '&type=' . 'gastro'
											. '&id=' . $gastros[$key]);
                                    echo '<br>' . JHtml::_('link', $link, $gastronames[$key], array('class' => 'btn btn-success'));
                            endforeach; ?>
                    </p>
            </div>
            <?php endif; ?>

            <?php  if (!empty($item->hiking_sightseeing)):?>
                    <p><strong>Sehenswürdiges und Denkwürdiges unterwegs</strong><p>
                    <p><?php echo  $item->hiking_sightseeing; ?></p>
            <?php endif; ?>

            <?php  if (!empty($item->hiking_idea)):?>
                    <p><strong>Unser Dank für die Anregung zu dieser Wanderung gilt:</strong><p>
                    <p><?php echo  $item->hiking_idea; ?></p>
            <?php endif; ?>
	</div>
</div>