<?php
/**
 * @copyright   Copyright (C) 2018 Benjamin Trenkle. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

?>
<div id="mod_jugbanner-<?php echo (int) $module->id; ?>" class="mod_jugbanner">
<?php foreach ($banners as $banner) : ?>
	<div class="mod_jugbanner-banner">
	<?php
	$img = HTMLHelper::_('image', $banner->image, '');

	if ($banner->link) :
		echo HTMLHelper::_('link', $banner->link, $img, ['target' => '_blank']);
	else :
		echo $img;
	endif;
	?>
	</div>
<?php endforeach; ?>
</div>