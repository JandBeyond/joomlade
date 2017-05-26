<?php
/**
 * @package    Wicked.Team
 *
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 * @copyright  Copyright (C) 2016 Wicked Software Benjamin Trenkle. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

$active = true;

$tabparams = array();
$params = $this->state->get('params');
$pageclass = '-' . htmlspecialchars($params->get('pageclass_sfx', ''));
?>

<div class="item-page<?php echo $pageclass; ?>">

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'member.cancel' || document.formvalidator.isValid(document.getElementById('adminForm')))
		{
			Joomla.submitform(task);
		}
	}
</script>
	<div id="wickedteam-form" class="wickedteam">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<div class="page-header">
			<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
		</div>
	<?php endif; ?>

		<form action="<?php echo JRoute::_('index.php?option=com_wickedteam&view=form&layout=edit&m_id=' . (int) $this->item->id); ?>" method="post" name="adminForm" enctype="multipart/form-data" id="adminForm" class="form-validate">

			<div class="btn-toolbar pull-right">
				<div class="btn-group">
					<button type="button" class="btn btn-success" onclick="Joomla.submitbutton('member.save')">
						<span class="icon-ok"></span>&#160;<?php echo JText::_('JSAVE') ?>
					</button>
				</div>
				<?php if (!$this->state->get('ownprofile')) : ?>
				<div class="btn-group">
					<button type="button" class="btn" onclick="Joomla.submitbutton('member.cancel')">
						<span class="icon-cancel"></span>&#160;<?php echo JText::_('JCANCEL') ?>
					</button>
				</div>
				<?php endif; ?>
			</div>

			<div class="clearfix"></div>

			<?php
				if (count($this->profiletabs)) :
					$firsttab  = reset($this->profiletabs);
					$tabparams = array('active' => $this->escape($firsttab->alias) . '-page');
				else :
					$tabparams = array('active' => 'system-settings');
				endif;

			?>

			<?php echo JHtml::_('bootstrap.startTabSet', 'editMemberTabs', $tabparams); ?>

			<?php if (count($this->profiletabs)) : ?>

				<?php echo $this->loadTemplate('Fields'); ?>
					<div style="display: none;">
						<?php // Dieses Feld muss gerendert werden sonst gibt es eine Fehlermeldung. ?>
						<?php echo $this->form->renderField('title_format'); ?>
					</div>
			<?php endif; ?>

			<?php echo JHtml::_('bootstrap.endTabSet'); ?>

			<input type="hidden" name="task" value="" />
			<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
			<?php echo JHTML::_('form.token'); ?>
		</form>
	</div>
</div>