<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

JHtml::_('behavior.caption');
?>

<style>
    .carousel-inner .active.left { left: -33%; }
.carousel-inner .next        { left:  33%; }
.carousel-inner .prev        { left: -33%; }
.carousel-control.left,.carousel-control.right {background-image:none;}
</style>
<script>
    $('#myCarousel').carousel({
  interval: 10000
})

$('.carousel .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
  }
  next.children(':first-child').clone().appendTo($(this));
  
  if (next.next().length>0) {
    next.next().children(':first-child').clone().appendTo($(this));
  }
  else {
  	$(this).siblings(':first').children(':first-child').clone().appendTo($(this));
  }
});
</script>


<div class="blog<?php echo $this->pageclass_sfx; ?> col-md-12" itemscope itemtype="http://schema.org/Blog">
    <div class="carousel slide" id="myCarouselblogcarousel">
        <div class="carousel-inner">
	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
			<?php foreach ($this->lead_items as &$item) : ?>
                    
                        <div class="item <?php ($leadingcount == 0 ? 'active' : '') ?>" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
                            <div class="col-md-4">
                                <?php
                                $this->item = & $item;
                                echo $this->loadTemplate('item');
                                ?>
				            
				        </div>
				    </div>
				<?php $leadingcount++; ?>
			<?php endforeach; ?>
            </div>
	<?php endif; ?>
        <a class="left carousel-control" href="#myCarouselblogcarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a>
      <a class="right carousel-control" href="#myCarouselblogcarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a>
    </div>
</div>
