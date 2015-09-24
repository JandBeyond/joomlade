<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_weblinks
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$class = ' class="first"'; ?>

<ul>
    <?php foreach ($this->weblinks as $id => $child) :

        if (!isset($this->weblinks[$id + 1]))
        {
            $class = ' class="last"';
        }
        ?>
        <li<?php echo $class; ?>>
            <?php $class = ''; ?>
            <span class="item-title"><a target="_blank" href="<?php echo JRoute::_(WeblinksHelperRoute::getWeblinkRoute($child->id, $child->catid)); ?>">
                    <?php echo $this->escape($child->title); ?></a>
            </span>
        </li>

    <?php endforeach; ?>
</ul>