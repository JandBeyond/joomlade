<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_latest
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<ul class="list-link">
<?php foreach ($list as $item) :  ?>
	<li itemscope itemtype="https://schema.org/Article">
		<?php echo JLayoutHelper::render('joomla.hundeklick.youtube_video', $item); ?>
	</li>
<?php endforeach; ?>
</ul>
