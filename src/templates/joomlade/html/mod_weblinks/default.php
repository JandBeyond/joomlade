<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_weblinks
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
?>

<style>
.tooltip.in {
	opacity: 0.8;
	filter: alpha(opacity=80);
}
.tooltip.top {
	margin-top: -3px;
}
.tooltip.right {
	margin-left: 3px;
}
.tooltip.bottom {
	margin-top: 3px;
}
.tooltip.left {
	margin-left: -3px;
}
.tooltip-inner {
	max-width: 200px;
	padding: 3px 8px;
	color: #fff;
	text-align: center;
	text-decoration: none;
	background-color: #fff;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
}
.tooltip-arrow {
	position: absolute;
	width: 0;
	height: 0;
	border-color: transparent;
	border-style: solid;
}
.tooltip.top .tooltip-arrow {
	bottom: 0;
	left: 50%;
	margin-left: -5px;
	border-width: 5px 5px 0;
	border-top-color: #fff;
}
.tooltip.right .tooltip-arrow {
	top: 50%;
	left: 0;
	margin-top: -5px;
	border-width: 5px 5px 5px 0;
	border-right-color: #fff;
}
.tooltip.left .tooltip-arrow {
	top: 50%;
	right: 0;
	margin-top: -5px;
	border-width: 5px 0 5px 5px;
	border-left-color: #fff;
}
.tooltip.bottom .tooltip-arrow {
	top: 0;
	left: 50%;
	margin-left: -5px;
	border-width: 0 5px 5px;
	border-bottom-color: #fff;
}
</style>






<ul class="weblinks<?php echo $moduleclass_sfx; ?>">
<?php foreach ($list as $item) :	?>
<?php $images = json_decode($item->images);?>
<li class="withtooltip" id="<?php echo $item->metadesc; ?>" >
	<?php
	$link = $item->link;
	switch ($params->get('target', 3))
	{
		case 1:
			// open in a new window
			echo '<a href="'. $link .'" target="_blank" title="JUG '.$item->title.'">'.
			htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8') .'</a>';
			break;

		

		case 2:
			// open in a popup window
			echo "<a href=\"#\" onclick=\"window.open('". $link ."', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\">".
				htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8') .'</a>';
			break;

		default:
			// open in parent window
			echo '<a href="'. $link .'" rel="'.$params->get('follow', 'nofollow').'">'.
				htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8') .'</a>';
			break;
	}
	?>
	<?php if ($params->get('description', 0)) : ?>
		<?php echo nl2br($item->description); ?>
	<?php endif; ?>

	<?php if ($params->get('hits', 0)) : ?>
		<?php echo '(' . $item->hits . ' ' . JText::_('MOD_WEBLINKS_HITS') . ')'; ?>
	<?php endif; ?>
</li>
<?php endforeach; ?>
</ul>

<script type="text/javascript">
	jQuery(function () {
		jQuery("[rel='tooltip']").tooltip({selector: true});
    });
</script>
