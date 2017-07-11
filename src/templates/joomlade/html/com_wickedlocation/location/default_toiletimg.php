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
$af = array('a', 'b', 'c', 'd', 'e', 'f');
$gm = array('g', 'h', 'i', 'j', 'k', 'l', 'm');
$nz = array('n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
?>


<div id="cbf-toiletimg" class="row_fluid">
	<?php if (!empty($item->wc_plan)):
		$foto = trim(str_replace('.jpg', '', $item->wc_plan));
		$first = substr($foto, 0, 1);
		$folder = 'af/';
		if (in_array($first, $af)):
			$folder = 'af/';
		elseif (in_array($first, $gm)):
			$folder = 'gm/';
		elseif (in_array($first, $nz)):
			$folder = 'nz/';
		endif;
		$alt = $this->escape(trim($this->item->title)) . ' Plan'; ?>

		<img src="<?php echo $this->baseurl ."/images/wc-s-" . $folder . $foto . ".jpg"; ?>"
			 alt="<?php echo $alt; ?>" />
	<?php endif; ?>

	<?php if (!empty($item->wc_fotos)):
		$fotos = explode(',', $item->wc_fotos); ?>
		<?php foreach ($fotos as $i => $foto) :
			$foto = trim(str_replace('.jpg', '', $this->escape($foto))) .".jpg";
			$first = substr($foto, 0, 1);
			$folder = 'af/';
			if (in_array($first, $af)):
				$folder = 'af/';
			elseif (in_array($first, $gm)):
				$folder = 'gm/';
			elseif (in_array($first, $nz)):
				$folder = 'nz/';
			endif;
		?>
		<img width="200px"
			src="<?php echo $this->baseurl . "/images/wc-" . $folder . $foto; ?>"
			alt="<?php echo $this->escape(trim($this->item->title)) . ' Foto' . $i; ?>"/>
		<?php endforeach; ?>
	<?php endif; ?>
</div>