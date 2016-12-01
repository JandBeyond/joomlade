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
    <?php
    $item   = $list[0];
    $images = json_decode($item->images);
    ?>
    <div class="curtain">
        <div class="curtain-wrapper">
            <input type="checkbox" checked>
            <div class="curtain-panel curtain-panel-left">
                <?php if (!empty($item->publish_up) && $item->publish_up != JFactory::getDbo()->getNullDate()) : ?>
                    <?php echo JHtml::_('date', $item->publish_up, 'd', false)[0]; ?>
                <?php endif; ?>
            </div>
            <div class="curtain-body">
                <div class="row">
                    <?php if(!empty($images->image_intro)) : ?>
                    <div class="col-md-3 text-center hidden-xs hidden-sm">
                        <div class="pull-none item-image">
                            <img src="<?php echo $images->image_intro; ?>" alt="<?php echo $images->image_intro_alt; ?>" class="img-rounded">
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-xs-12 col-md-<?php echo (empty($images->image_intro)) ? '12' : '8'; ?>">
                        <h4><?php echo $item->title; ?></h4>

                        <?php if (!$params->get('intro_only')) : ?>
                            <?php echo $item->afterDisplayTitle; ?>
                        <?php endif; ?>

                        <?php echo $item->beforeDisplayContent; ?>

                        <?php echo $item->introtext; ?>

                        <?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) : ?>
                            <?php echo '<a class="readmore" href="' . $item->link . '">' . $item->linkText . '</a>'; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="curtain-panel curtain-panel-right">
                <?php if (!empty($item->publish_up) && $item->publish_up != JFactory::getDbo()->getNullDate()) : ?>
                    <?php echo JHtml::_('date', $item->publish_up, 'd', false)[1]; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
