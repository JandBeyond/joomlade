<?php
/**
 * @package    Wicked.Team
 *
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 * @author     Christiane Maier-Stadtherr <christiane.maier-stadtherr@wicked-software.de>
 * @copyright  Copyright (C) 2016 Wicked Software Benjamin Trenkle. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Joomla\String\StringHelper;

$params      = $this->state->get('params');
$pageclass   = '-' . htmlspecialchars($params->get('pageclass_sfx', ''));
$active      = JFactory::getApplication()->getMenu()->getActive();
$pageclass   = '-' . htmlspecialchars($params->get('pageclass_sfx', ''));
$listOrder   = $this->escape($this->state->get('list.ordering'));
$listDirn    = $this->escape($this->state->get('list.direction'));
$profileLink = 'index.php?option=com_wickedteam&view=profile&id=';
$editLink    = 'index.php?option=com_wickedteam&task=member.edit&return=' . $this->return_url . '&m_id=';

$user = JFactory::getUser();

// The table titles become sortable, if we have more than title and ID field available
$filter_fields = $this->state->get('filter_fields');

// Remove ID in the counter because that's no table title
$sortable   = is_array($filter_fields) && count(array_diff($filter_fields, array('m.id')));
$showsearch = $params->get('showsearch', 'basic');
$canEdit    = $this->canDo->get('core.edit');
?>
<div id="wickedteam-team" class="wickedteam item-page<?php echo $pageclass; ?>">
	<div class="row">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
		<div class="page-header">
			<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
		</div>
	<?php endif; ?>

	<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>"
		  method="post" name="adminForm" id="adminForm">
		<?php if ($showsearch == 'basic' && !empty($this->searchfields)) : ?>
				<label for="filter_search" class="hidden">
					<?php echo JText::_('COM_WICKEDTEAM_TEAM_FILTER_LABEL'); ?>
				</label>
				<div class="btn-wrapper input-append">
					<?php echo $this->filterForm->getInput('search', 'filter'); ?>
					<button type="submit" class="btn btn-primary hasTooltip" title="<?php echo JHtml::_('tooltipText','JSEARCH_FILTER_SUBMIT'); ?>">
						<i class="fa fa-search"></i>
					</button>
				</div>
		<?php elseif ($showsearch == 'extended') : ?>
				<?php $link = 'index.php?option=com_wickedteam&amp;view=search&amp;id=' . (int) $this->list_id; ?>
				<?php echo JHtml::_('link', JRoute::_($link), JText::_('COM_WICKEDTEAM_TEAM_BACK_TO_SEARCH'), array('class' => 'btn')); ?>
		<?php endif; ?>
		<input type="hidden" name="filter_order" value="" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="limitstart" value="" />
		<input type="hidden" name="task" value="" />
		<?php if ($params->get('showlists', 1) || $params->get('showlistlimit', 1)): ?>
		<div class="btn-wrapper pull-right">
			<?php if ($params->get('showlists', 1)) : ?>
				<?php $this->filterForm->setValue('newlist', 'redirect', JRoute::_('index.php?Itemid=' . (int) $active->id)); ?>
				<?php echo $this->filterForm->getInput('newlist', 'redirect'); ?>
			<?php endif; ?>
			<?php if ($this->params->get('showlistlimit', '1')) : ?>
					<label for="limit" class="element-invisible"><?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?></label>
					<?php echo $this->pagination->getLimitBox(); ?>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="clearfix"></div>
	</form>
	</div>
	<?php $introtext = $params->get('introtext'); ?>
	<?php if ($introtext) : ?>
		<?php if (!empty($this->searchfields) && is_array($this->searchfields)): ?>
			<?php $searchfields = array(); ?>
			<?php if ($showsearch == 'basic') : ?>
				<?php foreach ($this->searchfields as $searchfield) : ?>
					<?php $searchfields[] = '<strong>' . $this->escape($searchfield->title) . '</strong>: ' . $this->escape($searchfield->alias); ?>
				<?php endforeach; ?>
			<?php elseif ($showsearch == 'extended') : ?>
				<?php $searchinput = $this->state->get('filter.extendedsearch'); ?>
				<?php foreach ($this->searchfields as $searchfield) : ?>
					<?php if (isset($searchinput['field-' . (int) $searchfield->id]) && !empty($searchinput['field-' . (int) $searchfield->id])) : ?>
						<?php $searchfields[] = '<strong>' . $this->escape($searchfield->title) . '</strong>: ' . $this->escape($searchinput['field-' . (int) $searchfield->id]); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
			<?php $introtext = sprintf($introtext, implode(', ', $searchfields)); ?>
		<?php endif; ?>
		<div class="memberlist-desc row">
			<div class="col-md-12">
				<p><?php echo JHtml::_('content.prepare', $introtext, '', 'com_wickedteam.team'); ?></p>
			</div>
		</div>
	<?php endif; ?>
	<?php if (empty($this->items)) : ?>
		<div class="alert alert-no-items">
			<?php echo JText::_('COM_WICKEDTEAM_TEAM_NO_MATCHING_RESULTS'); ?>
		</div>
	<?php else : ?>
	<div>
		<?php foreach ($this->items as $i => $item) : ?>
			<div class="dienstleister_container">
				<div class="col-sm-4 nopadding diensleister_infobereich">
					<div class="dienstleister_category">
						<span class="dienstleister_icon"></span>
						<span>Dienstleister</span>
					</div>
					<div class="dienstleister_name">
						<h3>
							<?php foreach ($this->listfields as $field) : ?>
								<?php if ($field->field_id < 0) : ?>
									<?php if ($params->get('linkuser', 0)) : ?>
										<?php $link = $profileLink . (int) $item->id . (!empty($item->alias) ? ':' . $this->escape($item->alias) : ''); ?>
										<?php echo JHtml::_('link', JRoute::_($link), $this->escape($item->title)); ?>
									<?php else : ?>
										<?php echo $this->escape($item->title); ?>
									<?php endif; ?>
									<?php if ($item->published == 0) : ?>
										<span class="list-published label label-warning">
											<?php echo JText::_('JUNPUBLISHED'); ?>
										</span>
									<?php endif; ?>
									<?php if ($canEdit) : ?>
										<?php $text = '<span class="fa fa-edit"></span> '; ?>
										<?php echo JHtml::_(
											'link',
											JRoute::_($editLink . (int) $item->id),
											$text,
											array(
												'class' => 'pull-right hasTooltip',
												'title' => JText::_('JGLOBAL_EDIT'),
											)
										); ?>
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; ?>
						</h3>
					</div>
					<div class="dienstleister_logo">
						<?php foreach ($this->listfields as $field) : ?>
							<?php if ($field->field_id == '3' && isset($this->fields[$field->field_id])) : ?>
								<?php $value = ''; ?>
								<?php if (isset($this->values[$item->id][$field->field_id])) : ?>
										<?php $value = array(); ?>
										<?php foreach ($this->values[$item->id][$field->field_id] as $val) : ?>
											<?php $visibility = in_array($val->visibility, array(0, 1, 2, 3)) ? (int) $val->visibility : 0; ?>
											<?php if ($visibility === 0 || ($visibility === 1 && !$user->guest) || (!$this->params->get('visibility_section', 1) || ($visibility === 2 && $item->samesection))) : ?>
												<?php $value[] = $val->value; ?>
											<?php endif; ?>
										<?php endforeach; ?>
								<?php endif; ?>

								<?php if (is_array($value)) : ?>
									<?php echo call_user_func(
										array(
											$this->fields[$field->field_id]->className,
											'prepareBeforeListOutput',
										),
										$value,
										$this->fields[$field->field_id],
										$item
									); ?>
								<?php endif; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="col-sm-8 nopadding diensleister_contentbereich">
					<?php foreach ($this->listfields as $field) : ?>
						<?php if ($field->id == '96') : ?>
							<?php if (!empty($field->children) && is_array($field->children)) : ?>
								<?php foreach ($field->children as $child) : ?>
									<?php if ($child->id == '97') : ?>
										<div class="dienstleiser_desc">
											<?php if ($child->field_id > 0 && isset($this->fields[$child->field_id])) : ?>
											<h4>Beschreibung</h4>
												<?php $value = ''; ?>
												<?php if (isset($this->values[$item->id][$child->field_id])) : ?>
													<?php $value = array(); ?>
													<?php foreach ($this->values[$item->id][$child->field_id] as $val) : ?>
														<?php $visibility = in_array($val->visibility, array(0, 1, 2, 3)) ? (int) $val->visibility : 0; ?>
														<?php if ($visibility === 0 || ($visibility === 1 && !$user->guest) || (!$this->params->get('visibility_section', 1) || ($visibility === 2 && $item->samesection))) : ?>
															<?php $value[] = $val->value; ?>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
												<?php echo call_user_func(
													array(
														$this->fields[$child->field_id]->className,
														'prepareBeforeListOutput',
													),
													$value,
													$this->fields[$child->field_id],
													$item
												); ?>
											<?php endif; ?>
										</div>
									<?php continue; ?>
									<?php endif; ?>
										<?php if ($child->id == '98') : ?>
											<div class="diensleister_main_offer">
												<?php if ($child->field_id > 0 && isset($this->fields[$child->field_id])) : ?>
													<?php $value = ''; ?>
													<?php if (isset($this->values[$item->id][$child->field_id])) : ?>
														<?php $value = array(); ?>
														<?php foreach ($this->values[$item->id][$child->field_id] as $val) : ?>
															<?php $visibility = in_array($val->visibility, array(0, 1, 2, 3)) ? (int) $val->visibility : 0; ?>
															<?php if ($visibility === 0 || ($visibility === 1 && !$user->guest) || (!$this->params->get('visibility_section', 1) || ($visibility === 2 && $item->samesection))) : ?>
																<?php $value[] = $val->value; ?>
															<?php endif; ?>
														<?php endforeach; ?>
													<?php endif; ?>
													<?php echo call_user_func(array($this->fields[$child->field_id]->className, 'prepareBeforeListOutput'), $value, $this->fields[$child->field_id], $item); ?>
												<?php elseif ($child->field_id == 0 && !empty($child->children) && is_array($child->children)) : ?>
													<h4>Angebot</h4>
													<?php foreach ($child->children as $f) : ?>
														<?php if ($f->field_id > 0 && isset($this->fields[$f->field_id])) : ?>
															<?php $value = ''; ?>
															<?php if (isset($this->values[$item->id][$f->field_id])) : ?>
																<?php $value = array(); ?>
																<?php foreach ($this->values[$item->id][$f->field_id] as $val) : ?>
																	<?php $visibility = in_array($val->visibility, array(0, 1, 2, 3)) ? (int) $val->visibility : 0; ?>
																	<?php if ($visibility === 0 || ($visibility === 1 && !$user->guest) || (!$this->params->get('visibility_section', 1) || ($visibility === 2 && $item->samesection))) : ?>
																		<?php $value[] = $val->value; ?>
																	<?php endif; ?>
																<?php endforeach; ?>
															<?php endif; ?>
															<?php echo call_user_func(
																array(
																	$this->fields[$f->field_id]->className,
																	'prepareBeforeListOutput',
																),
																$value,
																$this->fields[$f->field_id],
																$item
																) . ' '; ?>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
											</div>
										<?php continue; ?>
										<?php endif; ?>
										<?php if ($child->id == '100') : ?>
											<div class="diensleister_seccond_offer">
												<?php if ($child->field_id > 0 && isset($this->fields[$child->field_id])) : ?>
													<?php $value = ''; ?>
													<?php if (isset($this->values[$item->id][$child->field_id])) : ?>
														<?php $value = array(); ?>
														<?php foreach ($this->values[$item->id][$child->field_id] as $val) : ?>
															<?php $visibility = in_array($val->visibility, array(0, 1, 2, 3)) ? (int) $val->visibility : 0; ?>
															<?php if ($visibility === 0 || ($visibility === 1 && !$user->guest) || (!$this->params->get('visibility_section', 1) || ($visibility === 2 && $item->samesection))) : ?>
																<?php $value[] = $val->value; ?>
															<?php endif; ?>
														<?php endforeach; ?>
													<?php endif; ?>
													<?php echo call_user_func(
														array(
															$this->fields[$child->field_id]->className,
															'prepareBeforeListOutput',
														),
														$value,
														$this->fields[$child->field_id],
														$item
													); ?>
												<?php elseif ($child->field_id == 0 && !empty($child->children) && is_array($child->children)) : ?>
													<?php foreach ($child->children as $f) : ?>
														<?php if ($f->field_id > 0 && isset($this->fields[$f->field_id])) : ?>
															<?php $value = ''; ?>
															<?php if (isset($this->values[$item->id][$f->field_id])) : ?>
																<?php $value = array(); ?>
																<?php foreach ($this->values[$item->id][$f->field_id] as $val) : ?>
																	<?php $visibility = in_array($val->visibility, array(0, 1, 2, 3)) ? (int) $val->visibility : 0; ?>
																	<?php if ($visibility === 0 || ($visibility === 1 && !$user->guest) || (!$this->params->get('visibility_section', 1) || ($visibility === 2 && $item->samesection))) : ?>
																		<?php $value[] = $val->value; ?>
																	<?php endif; ?>
																<?php endforeach; ?>
															<?php endif; ?>
															<?php echo call_user_func(
																array(
																	$this->fields[$f->field_id]->className,
																	'prepareBeforeListOutput',
																),
																$value,
																$this->fields[$f->field_id],
																$item
															) . ' '; ?>
														<?php endif; ?>
													<?php endforeach; ?>
												<?php endif; ?>
											</div>
										<?php continue; ?>
										<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						<?php elseif ($field->id == '102') : ?>
							<div class="diensleister_adress">
								<?php if (!empty($field->children) && is_array($field->children)) : ?>
									<h4>Adresse</h4>
									<?php foreach ($field->children as $child) : ?>
										<?php if (!empty($child->title)) : ?>
											<?php echo $this->escape($child->title); ?>
										<?php endif; ?>
										<?php if ($child->field_id > 0 && isset($this->fields[$child->field_id])) : ?>
											<?php $value = ''; ?>
											<?php if (isset($this->values[$item->id][$child->field_id])) : ?>
												<?php $value = array(); ?>
												<?php foreach ($this->values[$item->id][$child->field_id] as $val) : ?>
													<?php $visibility = in_array($val->visibility, array(0, 1, 2, 3)) ? (int) $val->visibility : 0; ?>
													<?php if ($visibility === 0 || ($visibility === 1 && !$user->guest) || (!$this->params->get('visibility_section', 1) || ($visibility === 2 && $item->samesection))) : ?>
														<?php $value[] = $val->value; ?>
													<?php endif; ?>
												<?php endforeach; ?>
											<?php endif; ?>
											<?php echo call_user_func(
												array(
													$this->fields[$child->field_id]->className,
													'prepareBeforeListOutput',
												),
												$value,
												$this->fields[$child->field_id],
												$item
											); ?>
										<?php elseif ($child->field_id == 0 && !empty($child->children) && is_array($child->children)) : ?>
											<?php foreach ($child->children as $f) : ?>
												<?php if ($f->field_id > 0 && isset($this->fields[$f->field_id])) : ?>
													<?php $value = ''; ?>
													<?php if (isset($this->values[$item->id][$f->field_id])) : ?>
														<?php $value = array(); ?>
														<?php foreach ($this->values[$item->id][$f->field_id] as $val) : ?>
															<?php $visibility = in_array($val->visibility, array(0, 1, 2, 3)) ? (int) $val->visibility : 0; ?>
															<?php if ($visibility === 0 || ($visibility === 1 && !$user->guest) || (!$this->params->get('visibility_section', 1) || ($visibility === 2 && $item->samesection))) : ?>
																<?php $value[] = $val->value; ?>
															<?php endif; ?>
														<?php endforeach; ?>
													<?php endif; ?>
													<?php echo call_user_func(
														array($this->fields[$f->field_id]->className,
														'prepareBeforeListOutput',
														),
														$value,
														$this->fields[$f->field_id],
														$item
													) . ' '; ?>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>
