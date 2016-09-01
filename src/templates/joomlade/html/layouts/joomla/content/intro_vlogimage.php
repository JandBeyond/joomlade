<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;
$params = $displayData->params;

$youtube = $displayData->attribs->get('youtube_id', false);
$introimage = false;

if ($youtube)
{
	$youtube = str_replace('https://youtu.be/','',$youtube);
	$introimage = 'https://img.youtube.com/vi/' . $youtube .'/hqdefault.jpg';
}
?>
	<div class="pull-none item-image">
		<?php if ($params->get('link_titles') && $params->get('access-view')) : ?>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($displayData->slug, $displayData->catid, $displayData->language)); ?>">
				<?php echo JHtml::_('image', ($introimage) ? $introimage :'https://placehold.it/400x400&text=VideoImage fehlt', htmlspecialchars($displayData->title) , array('itemprop' => 'image', 'class' => 'img-responsive')); ?>
			</a>
		<?php else : ?>
			<?php echo JHtml::_('image', ($introimage) ? $introimage :'https://placehold.it/400x400&text=VideoImage fehlt', htmlspecialchars($displayData->title) , array('itemprop' => 'image', 'class' => 'img-responsive')); ?>
		<?php endif; ?>
	</div>

