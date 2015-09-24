<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_weblinks
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

$class = ' first';

if (count($this->items[$this->parent->id]) > 0 && $this->maxLevelcat != 0) :
    ?>
    <?php foreach ($this->items[$this->parent->id] as $id => $item) :

    // Get an instance of the generic articles model
    $model = JModelLegacy::getInstance('Category', 'WeblinksModel', array('ignore_request' => true));

    // Set application parameters in model
    $app       = JFactory::getApplication();
    $appParams = $app->getParams();
    $model->setState('params', $appParams);

    // Set the filters based on the module params
    $model->setState('list.start', 0);
    $model->setState('list.limit', (int) $appParams->get('history_limit', 5));

    $model->setState('filter.state', 1);
    $model->setState('filter.publish_date', true);

    // Access filter
    $access = !JComponentHelper::getParams('com_weblinks')->get('show_noauth');
    $model->setState('filter.access', $access);

    $catid = (int) $item->id;
    $model->setState('category.id', $catid);

    // Create query object
    $db    = JFactory::getDbo();
    $query = $db->getQuery(true);

    $case_when1 = ' CASE WHEN ';
    $case_when1 .= $query->charLength('a.alias', '!=', '0');
    $case_when1 .= ' THEN ';
    $a_id = $query->castAsChar('a.id');
    $case_when1 .= $query->concatenate(array($a_id, 'a.alias'), ':');
    $case_when1 .= ' ELSE ';
    $case_when1 .= $a_id . ' END as slug';

    $case_when2 = ' CASE WHEN ';
    $case_when2 .= $query->charLength('c.alias', '!=', '0');
    $case_when2 .= ' THEN ';
    $c_id = $query->castAsChar('c.id');
    $case_when2 .= $query->concatenate(array($c_id, 'c.alias'), ':');
    $case_when2 .= ' ELSE ';
    $case_when2 .= $c_id . ' END as catslug';

    $model->setState(
        'list.select',
        'a.*, c.published AS c_published,' . $case_when1 . ',' . $case_when2 . ',' . 'DATE_FORMAT(a.created, "%Y-%m-%d") AS created'
    );

    $model->setState('filter.c.published', 1);

    // Filter by language
    $model->setState('filter.language', $app->getLanguageFilter());

    $childs = $model->getItems();

    if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) :
        if (!isset($this->items[$this->parent->id][$id + 1]))
        {
            $class = ' last';
        }
        ?>
        <div  class="link-list category<?php echo $class; ?> clearfix" >
            <?php $class = ''; ?>
            <h2 class="page-header item-title">
                <?php echo $this->escape($item->title); ?>
                <?php if ($this->params->get('show_cat_num_articles_cat') == 1) : ?>
                    <span class="badge badge-info tip hasTooltip" title="<?php echo JHtml::tooltipText('COM_WEBLINKS_NUM_ITEMS'); ?>">
							<?php echo $item->numitems; ?>
						</span>
                <?php endif; ?>
            </h2>
            <?php if ($this->params->get('show_description') && $item->description != '') : ?>
                <details class="category-desc">
                    <?php echo JHtml::_('content.prepare', $item->description, '', 'com_weblinks.categories'); ?>
                </details>
            <?php endif; ?>

            <?php if (count($childs) > 0) :
                $this->weblinks = $childs;
                echo $this->loadTemplate('childs');
            endif; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
