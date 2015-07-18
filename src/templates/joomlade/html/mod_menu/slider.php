<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
	$items = '';
?>
<?php
foreach ($list as $i => &$item) :
	require JModuleHelper::getLayoutPath('mod_menu', 'slider_item');
endforeach;
?>
<div id="hero">
	<div id="owl-main" class="owl-carousel home-page-carousel height-lg owl-inner-nav owl-ui-lg owl-theme">
		<?php echo $items; ?>
	</div><!-- /.owl-carousel -->
</div><!-- /#hero -->