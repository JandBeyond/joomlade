<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_weblinks
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$class = ' class="first"';
$child_images = false; ?>

<style>
    img.linksammlung {width: 220px; height: 200px;}
    .item-title-linksammlung {font-weight: bold; font-size: 16px;}
    .item-title-linksammlung a{color: #000;}
</style>

<div class="row">
    <?php foreach ($this->weblinks as $id => $child) :
        $child_images = json_decode($child->images);
            if (!isset($this->weblinks[$id + 1]))
            {
                $class = ' class="last"';
            }
            ?>
        
            <div class="col-xs-3">
                <?php $class = ''; ?>
                <?php if($child_images && $child_images->image_first != '') : ?>
                    <figure>
                        <img src="<?php echo $child_images->image_first; ?>" alt="<?php echo $child_images->image_first_alt; ?>" class="img-circle linksammlung"/>
                        <?php if($child_images->image_first_caption != '') : ?>
                            <figcaption><?php echo $this->escape($child_images->image_first_caption); ?></figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endif; ?>
            </div>
            <div class="col-xs-9">
                <span class="item-title-linksammlung"><a target="_blank" href="<?php echo JRoute::_(WeblinksHelperRoute::getWeblinkRoute($child->id, $child->catid)); ?>"><?php echo $this->escape($child->title); ?></a>
                </span>
                <?php if ($child->description) : ?>    
                    <?php echo JHtml::_('content.prepare', $child->description, '', 'com_weblinks.categories'); ?>                   
                <?php endif; ?>
            </div>
    <?php endforeach; ?>
</div>