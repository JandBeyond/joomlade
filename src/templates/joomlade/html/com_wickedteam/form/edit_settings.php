<?php
/**
 * @package    Wicked.Team
 *
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 * @copyright  Copyright (C) 2016 Wicked Software Benjamin Trenkle. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$user = JFactory::getUser();
$isNew = !($this->item->id > 0);

$canCreateUser = $this->form->getValue('user_id') <= 0 && $this->canCreateUser;

echo JHtml::_('bootstrap.addTab', 'editMemberTabs', 'system-settings', JText::_('COM_WICKEDTEAM_FORM_TABS_LABEL_SETTINGS'));

$sections = $this->form->getValue('sections', null, array());

if (!is_array($sections)) :
	$sections = array();
endif;

?>
<div class="container-fluid">
	<div class="row-fluid">
		<?php if (count($this->sections)) : ?>
		<div class="span6">
			<fieldset>
				<legend><?php echo JText::_('COM_WICKEDTEAM_FORM_CATEGORIES_TITLE'); ?></legend>
				<?php foreach ($this->sections as $maincat) : ?>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th width="90%"><?php echo $this->escape($maincat->title); ?></th>
							<th><?php echo JText::_('COM_WICKEDTEAM_FORM_ASSIGN_CATEGORIES'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($maincat->children as $subcat) : ?>
						<?php if ($isNew && !$user->authorise('member.create', 'com_wickedteam.member.category.' . $subcat->id)) :
							continue;
						endif; ?>
						<tr>
							<td>
								<label for="section-<?php echo (int) $subcat->id; ?>">
									<?php echo $this->escape($subcat->title); ?>
								</label>
							</td>
							<td>
							<?php
								$active = array_search($subcat->id, $sections);
							?>
							<?php if ($isNew) : ?>
							<?php
								// Special check for values in user state (if form was submitted with an error e.g.)
								if ($active === false) :
							?>
								<input type="checkbox" id="section-<?php echo (int) $subcat->id; ?>" name="jform[sections][]" value="<?php echo (int) $subcat->id; ?>" />
							<?php else : ?>
								<input type="checkbox" id="section-<?php echo (int) $subcat->id; ?>" name="jform[sections][]" value="<?php echo (int) $subcat->id; ?>" checked="checked" />
							<?php endif; ?>
							<?php elseif ($subcat->active) : ?>
								<?php if ($user->authorise('member.unassign', 'com_wickedteam.member.category.' . $subcat->id)) : ?>
								<?php
									// Special check for values in user state (if form was submitted with an error e.g.)
									if ($active === false) :
								?>
									<input type="checkbox" id="section-<?php echo (int) $subcat->id; ?>" name="jform[sections][]" value="<?php echo (int) $subcat->id; ?>" />
								<?php else : ?>
									<input type="checkbox" id="section-<?php echo (int) $subcat->id; ?>" name="jform[sections][]" value="<?php echo (int) $subcat->id; ?>" checked="checked" />
								<?php endif; ?>
								<?php else : ?>
								X
								<?php endif; ?>
							<?php else : ?>
								<?php if ($user->authorise('member.assign', 'com_wickedteam.member.category.' . $subcat->id)) : ?>
								<?php
									// Special check for values in user state (if form was submitted with an error e.g.)
									if ($active !== false) :
								?>
								<input type="checkbox" id="section-<?php echo (int) $subcat->id; ?>" name="jform[sections][]" value="<?php echo (int) $subcat->id; ?>" checked="checked" />
								<?php else : ?>
									<input type="checkbox" id="section-<?php echo (int) $subcat->id; ?>" name="jform[sections][]" value="<?php echo (int) $subcat->id; ?>" />
								<?php endif; ?>
								<?php else : ?>
								&nbsp;
								<?php endif; ?>
							<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<?php endforeach; ?>
			</fieldset>
		</div>
		<?php endif; ?>
		<?php if ($this->canDo->get('core.edit.state')) : ?>
		<div class="span6 form-horizontal">
			<fieldset>
				<legend><?php echo JText::_('COM_WICKEDTEAM_FORM_SETTINGS'); ?></legend>
				<?php echo $this->form->renderField('published'); ?>
				<?php echo $this->form->renderField('title_format'); ?>
			</fieldset>
			<?php /** 
			<fieldset>
				<legend><?php echo JText::_('COM_WICKEDTEAM_FORM_ASSIGN_USER'); ?></legend>
				<?php if ($canCreateUser) : ?>
				<div class="accordion" id="wickedteamusercreation">
					<div class="accordion-group">
						<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#wickedteamusercreation" href="#collapseOne">
						<?php echo JText::_('COM_WICKEDTEAM_FORM_ASSIGN_USER'); ?>
						</a>
					</div>
					<div id="collapseOne" class="accordion-body collapse in">
						<div class="accordion-inner">
				<?php endif; ?>
						<?php echo $this->form->renderField('user_id'); ?>
				<?php if ($canCreateUser) : ?>
						</div>
					</div>
				</div>
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle" data-toggle="collapse" data-parent="#wickedteamusercreation" href="#collapseTwo">
							<?php echo JText::_('COM_WICKEDTEAM_FORM_CREATE_USER'); ?>
							</a>
						</div>
						<div id="collapseTwo" class="accordion-body collapse">
							<div class="accordion-inner">
								<?php echo $this->form->renderField('username'); ?>
								<?php echo $this->form->renderField('useremail'); ?>
								<?php echo $this->form->renderField('userpassword'); ?>
								<h4><?php echo JText::_('JLIB_RULES_GROUPS'); ?></h4>
								<?php echo JHtml::_('access.usergroups', 'jform[usergroups]', array($this->userConfig->get('new_usertype', 0)), true); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</fieldset>**/ ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<?php echo JHtml::_('bootstrap.endTab');
