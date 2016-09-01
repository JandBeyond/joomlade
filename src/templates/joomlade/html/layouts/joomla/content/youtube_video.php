<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $displayData->params;
$canEdit = $displayData->params->get('access-edit');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
require_once JPATH_SITE . '/components/com_contact/helpers/route.php';
$urls = json_decode($displayData->urls);
$attribs = json_decode($displayData->attribs);
if (isset($attribs->youtube_id) && !empty($attribs->youtube_id)) :
	$youtube = $attribs->youtube_id;
	$youtube = str_replace('https://youtu.be/','',$youtube);
	?>
	<div class="articleVideo">
		<div class="youtube_container" style="position: relative; width: 100%; padding-bottom: 60%; height: 0;">
			<iframe style="position: absolute; top: 0; left:0; width: 100%; height: 100%;" width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $youtube; ?>?wmode=opaque&amp;autoplay=0&amp;autohide=2&amp;border=0&amp;cc_load_policy=0&amp;cc_lang_pref=en&amp;hl=en&amp;color=red&amp;color1=&amp;color2=&amp;controls=1&amp;fs=1&amp;hd=0&amp;iv_load_policy=1&amp;modestbranding=1&amp;showinfo=1&amp;rel=0&amp;theme=dark" scrolling="no" frameborder="0" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" allowtransparency="true"></iframe>
		</div>
	</div>
<?php endif; ?>