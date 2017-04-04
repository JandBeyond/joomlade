<?php
/**
 * @package    Wicked.Team
 *
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 * @copyright  Copyright (C) 2016 Wicked Software Benjamin Trenkle. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$params = $this->state->get('params');
$pageclass = '-' . htmlspecialchars($params->get('pageclass_sfx', ''));
?>

<div id="wickedteam-profile" class="wickedteam item-page<?php echo $pageclass; ?>">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<div class="page-header">
		<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
	</div>
<?php endif; ?>
<?php if ($this->params->get('show_title', 1)) : ?>
	<div class="page-header">
		<h2 itemprop="name">
			<?php echo $this->escape($this->item->title); ?>
		</h2>
	</div>
<?php endif; ?>
<?php if (count($this->profiletabs) /*|| $this->canDo->get('core.edit.state') || $this->canDo->get('core.edit.state')*/) :

	$active = reset($this->profiletabs);

	if (count($this->profiletabs) > 1) :
		echo JHtml::_('bootstrap.startTabSet', 'profile-tabs', array('active' => 'cat-' . $active->alias));
	endif;

	echo $this->loadTemplate('profile');

	if (count($this->profiletabs) > 1) :
		echo JHtml::_('bootstrap.endTabSet');
	endif;
endif; ?>
</div>