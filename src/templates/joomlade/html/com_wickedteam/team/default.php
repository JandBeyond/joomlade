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

$params = $this->state->get('params');
$pageclass = '-' . htmlspecialchars($params->get('pageclass_sfx', ''));

$active = JFactory::getApplication()->getMenu()->getActive();

$pageclass = '-' . htmlspecialchars($params->get('pageclass_sfx', ''));

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));

$profileLink	= 'index.php?option=com_wickedteam&view=profile&id=';
$editLink		= 'index.php?option=com_wickedteam&task=member.edit&return=' . $this->return_url . '&m_id=';

$user = JFactory::getUser();

// The table titles become sortable, if we have more than title and ID field available
$filter_fields = $this->state->get('filter_fields');

// Remove ID in the counter because that's no table title
$sortable = is_array($filter_fields) && count(array_diff($filter_fields, array('m.id')));

$showsearch = $params->get('showsearch', 'basic');

$canEdit = $this->canDo->get('core.edit');
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
			<?php
				$link = 'index.php?option=com_wickedteam&amp;view=search&amp;id=' . (int) $this->list_id;

				echo JHtml::_('link', JRoute::_($link), JText::_('COM_WICKEDTEAM_TEAM_BACK_TO_SEARCH'), array('class' => 'btn'));
			?>
		<?php endif; ?>

		<input type="hidden" name="filter_order" value="" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="limitstart" value="" />
		<input type="hidden" name="task" value="" />

		<?php if ($params->get('showlists', 1) || $params->get('showlistlimit', 1)): ?>
		<div class="btn-wrapper pull-right">
			<?php
			if ($params->get('showlists', 1)):
				$this->filterForm->setValue('newlist', 'redirect', JRoute::_('index.php?Itemid=' . (int) $active->id));
				echo $this->filterForm->getInput('newlist', 'redirect');
			endif; ?>
			<?php if ($this->params->get('showlistlimit', '1')) : ?>
					<label for="limit" class="element-invisible"><?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?></label>
					<?php echo $this->pagination->getLimitBox(); ?>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="clearfix"></div>
	</form>
	</div>
	<?php
		$introtext = $params->get('introtext');
		if ($introtext) :
			if (!empty($this->searchfields) && is_array($this->searchfields)):
				$searchfields = array();
				if ($showsearch == 'basic') :
					foreach ($this->searchfields as $searchfield) :
						$searchfields[] = '<strong>' . $this->escape($searchfield->title) . '</strong>: ' . $this->escape($searchfield->alias);
					endforeach;
				elseif ($showsearch == 'extended') :
					$searchinput = $this->state->get('filter.extendedsearch');
					foreach ($this->searchfields as $searchfield) :
						if (isset($searchinput['field-' . (int) $searchfield->id]) && !empty($searchinput['field-' . (int) $searchfield->id])):
							$searchfields[] = '<strong>' . $this->escape($searchfield->title) . '</strong>: ' . $this->escape($searchinput['field-' . (int) $searchfield->id]);
						endif;
					endforeach;
				endif;
				$introtext = sprintf($introtext, implode(', ', $searchfields));
			endif;
	?>
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
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped" id="memberList">
				<thead>
					<tr>
					<?php foreach ($this->listfields as $field) : ?>
						<?php if ($field->field_id < 0) : ?>
						<th>
						<?php
							$title = StringHelper::strlen(trim($field->title)) ? $this->escape($field->title) : JText::_('JGLOBAL_TITLE');

							if ($lang->hasKey($title)) :
								$title = JText::_($title);
							endif;

							if ($sortable && in_array('m.title', $filter_fields)) :
								echo JHtml::_('grid.sort', $this->escape($title), 'm.title', $listDirn, $listOrder);
							else :
								echo $this->escape($title);
							endif;
						?>
						</th>
						<?php elseif ($field->field_id > 0 && isset($this->fields[$field->field_id])) : ?>
						<th>
						<?php
							$title = !empty($field->title) ? $field->title : $this->fields[$field->field_id]->title;

							if ($lang->hasKey($title)) :
								$title = JText::_($title);
							endif;

							if ($sortable && in_array('field-' . $field->field_id . '.value', $filter_fields)) :
								echo JHtml::_('grid.sort', $this->escape($title), 'field-' . $field->field_id . '.value', $listDirn, $listOrder);
							else :
								echo $this->escape($title);
							endif;
						?>
						</th>
						<?php else : ?>
						<th>
						<?php
							$title = $field->title;

							if ($lang->hasKey($title)) :
								$title = JText::_($title);
							endif;

							echo $this->escape($title);
						?>
						</th>
						<?php endif; ?>
					<?php endforeach; ?>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="<?php echo count($this->listfields); ?>">

						<div class="pagination text-center">
							<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
							<?php echo $this->pagination->getPagesLinks(); ?>
						</div>

						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php foreach ($this->items as $i => $item) : ?>
					<tr class="row<?php echo ($i % 2) . ($item->published == 0 ? ' system-unpublished' : ''); ?>">
					<?php foreach ($this->listfields as $field) : ?>
						<td>
						<?php if ($field->field_id < 0) : ?>
							<?php
								if ($params->get('linkuser', 0)) :
									$link = $profileLink . (int) $item->id . (!empty($item->alias) ? ':' . $this->escape($item->alias) : '');
									echo JHtml::_('link', JRoute::_($link), $this->escape($item->title));
								else :
									echo $this->escape($item->title);
								endif;
							?>
							<?php if ($item->published == 0) : ?>
								<span class="list-published label label-warning">
									<?php echo JText::_('JUNPUBLISHED'); ?>
								</span>
							<?php endif; ?>
							<?php if ($canEdit) :
								$text = '<span class="fa fa-edit"></span> ' /*. JText::_('JGLOBAL_EDIT') */;

								echo JHtml::_('link', JRoute::_($editLink . (int) $item->id), $text, array('class' => 'pull-right hasTooltip', 'title' => JText::_('JGLOBAL_EDIT')));
							endif; ?>
						<?php elseif ($field->field_id > 0 && isset($this->fields[$field->field_id])) : ?>
						<?php
							$value = '';
							if (isset($this->values[$item->id][$field->field_id])) :
									$value = array();
									foreach ($this->values[$item->id][$field->field_id] as $val) :
										$visibility = in_array($val->visibility, array(0, 1, 2, 3)) ? (int) $val->visibility : 0;
										if ($visibility === 0 || ($visibility === 1 && !$user->guest) || (!$this->params->get('visibility_section', 1) || ($visibility === 2 && $item->samesection))) :
											$value[] = $val->value;
										endif;
									endforeach;
							endif;

							echo call_user_func(array($this->fields[$field->field_id]->className, 'prepareBeforeListOutput'), $value, $this->fields[$field->field_id], $item);
						?>
						<?php else : ?>
						<?php
							if (!empty($field->children) && is_array($field->children)) :
								foreach ($field->children as $child) :
						?>
								<div class="row">
									<div class="col-md-12">
									<?php
										if (!empty($child->title)) :

											$title = $child->title;

											if ($lang->hasKey($title)) :
												$title = JText::_($title);
											endif;

											echo '<span class="wickedteam-member-subheadline">' . $this->escape($title) . '</span>';
										endif;

										if ($child->field_id > 0 && isset($this->fields[$child->field_id])) :
											$value = '';

											if (isset($this->values[$item->id][$child->field_id])) :
												$value = array();
												foreach ($this->values[$item->id][$child->field_id] as $val) :
													$visibility = in_array($val->visibility, array(0, 1, 2, 3)) ? (int) $val->visibility : 0;
													if ($visibility === 0 || ($visibility === 1 && !$user->guest) || (!$this->params->get('visibility_section', 1) || ($visibility === 2 && $item->samesection))) :
														$value[] = $val->value;
													endif;
												endforeach;
											endif;

											echo call_user_func(array($this->fields[$child->field_id]->className, 'prepareBeforeListOutput'), $value, $this->fields[$child->field_id], $item);
										elseif ($child->field_id == 0 && !empty($child->children) && is_array($child->children)) :
											foreach ($child->children as $f) :
												if ($f->field_id > 0 && isset($this->fields[$f->field_id])) :
													$value = '';
													if (isset($this->values[$item->id][$f->field_id])) :
														$value = array();
														foreach ($this->values[$item->id][$f->field_id] as $val) :
															$visibility = in_array($val->visibility, array(0, 1, 2, 3)) ? (int) $val->visibility : 0;
															if ($visibility === 0 || ($visibility === 1 && !$user->guest) || (!$this->params->get('visibility_section', 1) || ($visibility === 2 && $item->samesection))) :
																$value[] = $val->value;
															endif;
														endforeach;
													endif;

													if (strlen($f->title)) :

														$title = $f->title;

														if ($lang->hasKey($title)) :
															$title = JText::_($title);
														endif;
														echo '<span class="wickedteam-member-secondsubheadline">' . $this->escape($title) . '</span>';
													endif;

													echo call_user_func(array($this->fields[$f->field_id]->className, 'prepareBeforeListOutput'), $value, $this->fields[$f->field_id], $item) . ' ';
												endif;
											endforeach;
										endif;
									?>
									</div>
								</div>
						<?php
								endforeach;
							endif;
						?>
						<?php endif; ?>
						</td>
					<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php endif; ?>
</div>
