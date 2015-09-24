<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_weblinks
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$class = ' first';
$child_images = false; ?>

<?php foreach ($this->weblinks as $id => $child) :
    $child_images = json_decode($child->images);
        if (!isset($this->weblinks[$id + 1]))
        {
            $class = ' last"';
        }
        ?>
    <div class="row<?php echo $class; ?>">
        <?php $class = ''; ?>
        <div class="col-xs-12 col-sm-3">
            <?php if($child_images && $child_images->image_first != '') : ?>
                <?php if($child_images->image_first_caption != '') : ?>
                <figure>
                <?php else : ?>
                <div class="figure">
                <?php endif; ?>
                    <img src="<?php echo $child_images->image_first; ?>" alt="<?php echo $child_images->image_first_alt; ?>" class="img-circle img-responsive link-list"/>
                    <?php if($child_images->image_first_caption != '') : ?>
                        <figcaption><?php echo $this->escape($child_images->image_first_caption); ?></figcaption>
                    <?php endif; ?>
                <?php if($child_images->image_first_caption != '') : ?>
                </figure>
                <?php else : ?>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="col-xs-12 col-sm-9">
            <h3 class="item-title link-list">
                <a target="_blank" href="<?php echo JRoute::_(WeblinksHelperRoute::getWeblinkRoute($child->id, $child->catid)); ?>"><?php echo $this->escape($child->title); ?></a>
            </h3>
            <?php if ($child->description) : ?>
                <?php echo JHtml::_('content.prepare', $child->description, '', 'com_weblinks.categories'); ?>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
