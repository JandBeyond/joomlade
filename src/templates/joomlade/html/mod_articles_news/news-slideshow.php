<?php
/**
* @package Joomla.Site
* @subpackage mod_articles_news
*
* @copyright Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
*/
defined('_JEXEC') or die;
?>
<div class="area-joomla">
    <h3 class="moduleheading fullwidth"><?php echo JText::_('TPL_JOOMLADE_HEADING_NEWS'); ?></h3>

    <div id="carousel-slideshow-<?php echo $module->id; ?>" class="<?php echo $moduleclass_sfx; ?> carousel slide news" data-ride="carousel">
        <div class="carousel-inner" role="listbox">
            <?php for($i = 0; $i < count($list); $i = $i + 3): ?>
            <div class="item <?php if($i == 0) { echo 'active'; } ?>">
                <?php foreach(array_slice($list, $i, 3) as $item): ?>
                    <div class="col-md-4">
                        <?php $images = json_decode($item->images); ?>

                        <?php if($images->image_intro): ?>
                            <a href="<?php echo $item->link; ?>">
                                <img src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo $item->title; ?>" class="intro"/>
                            </a>
                        <?php endif; ?>

                        <h4><?php echo $item->title; ?></h4>

                        <?php echo substr(strip_tags($item->introtext), 0, 180); ?>...

                        <?php $tagLayout = new JLayoutFile('joomla.content.tags'); ?>
                        <?php echo $tagLayout->render($item->tags->itemTags); ?>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-slideshow-<?php echo $module->id; ?>" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only"><?php echo JText::_('JPREV'); ?></span>
        </a>
        <a class="right carousel-control" href="#carousel-slideshow-<?php echo $module->id; ?>" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only"><?php echo JText::_('JNEXT'); ?></span>
        </a>
    </div>
</div>