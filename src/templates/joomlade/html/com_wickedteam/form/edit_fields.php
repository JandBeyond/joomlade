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

$open = false;

foreach ($this->profiletabs as $tab) :

	echo JHtml::_('bootstrap.addTab', 'editMemberTabs', $this->escape($tab->alias) . '-page', $this->escape($tab->title));

?>
<div class="container-fluid">
<?php
	$j = 0;
	foreach ($tab->children as $fieldset) :
		if (count($this->fields[$fieldset->id])) : ?>
		<?php if ($j > 0 && $j % 2 == 0) : ?>
		</div>
		<div class="row-fluid">
		<?php endif; ?>
			<div class="span6">
				<?php for ($i = 0; $i <= $fieldset->maxinstance; ++$i) : ?>
				<div class="wickedteamFieldset-<?php echo (int) $fieldset->id; ?> <?php echo $fieldset->params->get('formstyle', 'form-vertical'); ?>">
					<fieldset class="wt-<?php echo $this->escape($fieldset->alias); ?>">
                          <?php if ($fieldset->alias == 'karte') : ?>
                            <?php continue; ?>
                          <?php endif; ?>
                      <legend>

						<?php
							echo $this->escape($fieldset->title);

							$attribs = array();

							$attribs['class'] = 'btn pull-right ';
							$icon = 'icon-';

							if ($fieldset->params->get('duplicable', 0)) :
								if ($i > 0) :
									$attribs['class'] .= 'btn-warning removeFieldset';
									$icon .= 'minus';
								else :
									$attribs['class'] .= 'btn-info duplicateFieldset';
									$icon .= 'plus';
								endif;

								echo JHtml::_('link', '#', '<i class="' . $icon . '"></i>', $attribs);
							endif;
						?>
						</legend>
						<?php foreach ($this->fields[$fieldset->id] as $field) : ?>
						<?php
						if (!class_exists($field->className)
							|| !((!$this->item->id && $user->authorise('core.create', 'com_wickedteam.field.' . (int) $field->id))
							|| ($this->item->id
							&& (($user->authorise('core.edit', 'com_wickedteam.field.' . (int) $field->id))
							|| ($user->authorise('core.edit.own', 'com_wickedteam.field.' . (int) $field->id) && $user->id == $this->item->user_id))))) :
							continue;
						endif;

						if (!$this->form->getField('field-' . (int) $field->id . '_' . 0 . '_' . 0)->hidden) : ?>
						<div class="control-group" data-fieldtype="<?php echo $this->escape($field->element); ?>">
							<div class="control-label">
								<?php echo $this->form->getLabel('field-' . $field->id . '_' . 0 . '_' . 0); ?>
							</div>
							<?php
								$maxinstance = isset($this->values[$i][$field->id]) ? (int) $this->values[$i][$field->id] : 0;

								for ($c = 0; $c <= $maxinstance; ++$c) :
							?>
								<div class="controls">
								<?php echo call_user_func(array($field->className, 'outputForm'), $field, $this->form, $i, $c, $this->item->id); ?>
								</div>
							<?php
								endfor;
							?>
						</div>
						<?php else : ?>
							<?php
								$maxinstance = isset($this->values[$i][$field->id]) ? (int) $this->values[$i][$field->id] : 0;

								for ($c = 0; $c <= $maxinstance; ++$c) :
							?>
							<?php echo call_user_func(array($field->className, 'outputForm'), $field, $this->form, $i, $c, $this->item->id); ?>
							<?php
								endfor;
							?>
						<?php endif; ?>
					<?php endforeach; ?>
					</fieldset>
				</div>
				<?php endfor; ?>
			</div>
		<?php endif;
		++$j;
	endforeach;
?></div><?php
echo JHtml::_('bootstrap.endTab');
endforeach;
