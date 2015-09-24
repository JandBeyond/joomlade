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

<ul>
    <?php foreach ($this->weblinks as $id => $child) :

        $child_images = json_decode($child->images);

        if (!isset($this->weblinks[$id + 1]))
        {
            $class = ' class="last"';
        }
        ?>
        <li<?php echo $class; ?>>
            <?php $class = ''; ?>
            <?php if($child_images && $child_images->image_first != '') : ?>
                <figure>
                    <img src="<?php echo $child_images->image_first; ?>" alt="<?php echo $child_images->image_first_alt; ?>" />
                    <?php if($child_images->image_first_caption != '') : ?>
                        <figcaption><?php echo $this->escape($child_images->image_first_caption); ?></figcaption>
                    <?php endif; ?>
                </figure>
            <?php endif; ?>
            <span class="item-title"><a target="_blank" href="<?php echo JRoute::_(WeblinksHelperRoute::getWeblinkRoute($child->id, $child->catid)); ?>">
                    <?php echo $this->escape($child->title); ?></a>
            </span>
            <?php if ($child->description) : ?>
                <details class="category-desc">
                    <?php echo JHtml::_('content.prepare', $child->description, '', 'com_weblinks.categories'); ?>
                </details>
            <?php endif; ?>
        </li>

    <?php endforeach; ?>
</ul>