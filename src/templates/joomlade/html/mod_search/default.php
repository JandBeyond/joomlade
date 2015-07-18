<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Including fallback code for the placeholder attribute in the search field.
JHtml::_('jquery.framework');
JHtml::_('script', 'system/html5fallback.js', false, true);

if ($width)
{
	$moduleclass_sfx .= ' ' . 'mod_search' . $module->id;
	$css = 'div.mod_search' . $module->id . ' input[type="search"]{ width:auto; }';
	JFactory::getDocument()->addStyleDeclaration($css);
	$width = ' size="' . $width . '"';
}
else
{
	$width = '';
}
?>
<div class="<?php echo $moduleclass_sfx ?>">
	<div class="btn-group dropdown">
		<button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="icon-search"></i></button>
		<ul class="dropdown-menu dropdown-menu-right dropdown-animation">
			<li>
				<form action="<?php echo JRoute::_('index.php');?>" method="post" role="search" class="search-box margin-clear">
					<div class="form-group has-feedback">
						<?php
						$output = '<input name="searchword" id="mod-search-searchword" maxlength="' . $maxlength . '"  class="form-control" type="search"';
						$output .= ' placeholder="' . $text . '" />';
						echo $output;
						?>
						<i class="icon-search form-control-feedback"></i>
					</div>
					<input type="hidden" name="task" value="search" />
					<input type="hidden" name="option" value="com_search" />
					<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
				</form>
			</li>
		</ul>
	</div>
</div>
