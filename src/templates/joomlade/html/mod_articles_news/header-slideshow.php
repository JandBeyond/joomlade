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

    
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
      <?php foreach ($list as $key=>$item): ?>
    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $key; ?>" class="<?php if($key == 0) ? 'active':''; ?>"></li>
    <li data-target="#carousel-example-generic" data-slide-to="<?php echo $key; ?>"></li>

      <?php enforeach; ?>
  </ol>
    
    <div class="carousel-inner" role="listbox">
        <?php foreach ($list as $key=>$item): ?>
            <div class="item" class="<?php if($key == 0) ? 'active':''; ?>">
            <?php $images = json_decode($item->images);?>
            <?php echo htmlspecialchars($images->image_intro); ?>
            
        <div class="carousel-caption">
            <?php echo $item->introtext; ?>
        </div>
            
        </div>
        <?php enforeach; ?>
    </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>