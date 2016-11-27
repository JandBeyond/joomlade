<?php
/**
 * @package    Joomla.Site
 * @subpackage mod_articles_news
 *
 * @copyright  Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die; ?>
<?php if (isset($list[0])) : ?>
    <div class="curtain">
        <div class="curtain-wrapper">
            <input type="checkbox" checked>
            <div class="curtain-panel curtain-panel-left">
                <?php if(!empty($list[0]->publish_up) && $list[0]->publish_up != JFactory::getDbo()->getNullDate()) : ?>
                    Tür <?php echo JHtml::_('date', $list[0]->publish_up, 'j'); ?>
                <?php else : ?>
                    <?php echo $list[0]->title; ?>
                <?php endif; ?>
            </div>
            <div class="curtain-body">
                <h3><?php echo $list[0]->title; ?></h3>

                <?php if (!$params->get('intro_only')) : ?>
                    <?php echo $list[0]->afterDisplayTitle; ?>
                <?php endif; ?>

                <?php echo $list[0]->beforeDisplayContent; ?>

                <?php echo $list[0]->introtext; ?>

                <?php if (isset($list[0]->link) && $list[0]->readmore != 0 && $params->get('readmore')) : ?>
                    <?php echo '<a class="readmore" href="' . $list[0]->link . '">' . $list[0]->linkText . '</a>'; ?>
                <?php endif; ?>
            </div>
            <div class="curtain-panel curtain-panel-right">&nbsp;öffnen</div>
        </div>
    </div>
<?php endif; ?>
