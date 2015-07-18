<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$class        = $item->anchor_css ? 'class="' . $item->anchor_css . '" ' : '';
$title        = $item->anchor_title ? 'title="' . $item->anchor_title . '" ' : '';
$joomladeslidertitle  = $item->params->get('joomladeslider_title','');
$text         = $item->params->get('joomladeslider_text','');
$linktext     = $item->params->get('joomladeslider_linktext','Zum Beitrag');
$imagesrc     = ($imagesrc = $item->params->get('joomladeslider_image',false)) ? $imagesrc : 'https://placehold.it/1920x720&text=Bild';
$linktitle    = $item->params->get('joomladeslider_title',$item->title);
switch ($item->browserNav)
{
	default:
	case 0:
		$link ='<a class="btn uppercase strong btn-primary btn-add-to-cart btn-action" ' . $title . 'href="'. $item->flink . '">';
		break;
	case 1:
		$link ='<a class="btn uppercase strong btn-primary btn-add-to-cart btn-action" ' . $title . 'href="'. $item->flink . '" target="_blank">';
		break;
}

$items .= '<div class="item" style="background-image: url(' . $imagesrc . ')"><div class="container"><div class="caption vertical-center text-center"><div class="big-text fadeInDown-1" style="opacity: 0;">';
$items .= $joomladeslidertitle;
$items .= '</div><div class="fadeInDown-2 hidden-xs text" style="opacity: 0;">';
$items .= $text;
$items .= '</div><div class="button-holder fadeInDown-3" style="opacity: 0;">';
$items .= $link.$linktext.'</a>';
$items .= '</div><!-- /.button-holder --></div><!-- /.caption --></div><!-- /.container --></div><!-- /.item -->';
?>
