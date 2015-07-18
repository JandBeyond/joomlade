<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

    
<div id="carousel-example-generic<?php echo $moduleclass_sfx; ?>" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <?php foreach ($list as $key=>$item): ?>
    <li data-target="#carousel-example-generic<?php echo $moduleclass_sfx; ?>" data-slide-to="<?php echo $key; ?>" <?php echo ($key == '0' ? 'class="active"' : ''); ?>></li>
    <?php endforeach; ?>
  </ol>
    
    <div class="carousel-inner" role="listbox">
        <?php foreach ($list as $key=>$item): ?>
        <div class="item <?php echo ($key == '0' ? 'active' : ''); ?>">
            <?php $images = json_decode($item->images);?>
            <img class="slide" src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="slide">
            <div class="carousel-caption">
                <?php echo $item->introtext; ?>
            </div>  
        </div>
        <?php endforeach; ?>
    </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic<?php echo $moduleclass_sfx; ?>" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic<?php echo $moduleclass_sfx; ?>" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>