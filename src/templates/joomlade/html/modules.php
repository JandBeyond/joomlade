<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.joomlade
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

function modChrome_joomlade ($module, &$params, &$attribs)
{
	$moduleTag      = $params->get('module_tag', 'div');
	$headerTag      = htmlspecialchars($params->get('header_tag', 'h3'));

	// Temporarily store header class in variable
	$headerClass	= $params->get('header_class');
	$headerClass	= !empty($headerClass) ? htmlspecialchars($headerClass) : 'moduleheading';

	// Temporarily store box class in variable
	$boxClass = htmlspecialchars($params->get('moduleclass_sfx'));
	$boxClass .= !empty($attribs['width']) ? ' ' . $attribs['width'] : '';

	if (!empty ($module->content)) : ?>
		<<?php echo $moduleTag; ?> class="moduletable<?php echo $boxClass ?>">
		<?php if ((bool) $module->showtitle) :?>
			<<?php echo $headerTag . ' class="'. $headerClass . '"">' . $module->title; ?></<?php echo $headerTag; ?>>
		<?php endif; ?>
		<?php echo $module->content; ?>
		</<?php echo $moduleTag; ?>>
	<?php endif;	
}