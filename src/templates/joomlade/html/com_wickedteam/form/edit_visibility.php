<?php
/**
 * @package    Wicked.Team
 *
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 * @copyright  Copyright (C) 2016 Wicked Software Benjamin Trenkle. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

echo JHtml::_('bootstrap.addTab', 'editMemberTabs', 'system-visibility', JText::_('COM_WICKEDTEAM_FORM_TABS_LABEL_VISIBILITY'));

$options = array();

$options[] = JHtml::_('select.option', 0, JText::_('COM_WICKEDTEAM_FORM_VISIBILITY_ALL'));
$options[] = JHtml::_('select.option', 1, JText::_('COM_WICKEDTEAM_FORM_VISIBILITY_REGISTERED'));

if ($this->params->get('visibility_section', 1)) :
	$options[] = JHtml::_('select.option', 2, JText::_('COM_WICKEDTEAM_FORM_VISIBILITY_SECTION'));
endif;

$options[] = JHtml::_('select.option', 3, JText::_('COM_WICKEDTEAM_FORM_VISIBILITY_NONE'));

?>

<div class="container-fluid form-horizontal">

	<div class="alert alert-info"><?php echo JText::_('COM_WICKEDTEAM_FORM_VISIBILITY_INFO'); ?></div>

<?php foreach ($this->visiblefields as $field) : ?>
<?php $attribs = array('list.select' => $field->visibility); ?>
<div class="control-group">
	<div class="control-label">
	<?php echo $this->escape($field->title); ?>
	</div>
	<div class="controls">
	<?php echo JHtml::_('select.genericlist', $options, 'jform[visibility][' . (int) $field->id . ']', $attribs) ?>
	</div>
</div>
<?php endforeach; ?>

</div>

<?php echo JHtml::_('bootstrap.endTab');
