<?php
/**
 * @package    Wicked.Location
 *
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-chick.de>
 * @author     Christiane Maier-Stadtherr <christiane.maier-stadtherr@wicked-chick.de>
 * @copyright  Copyright (C) 2015 Wicked Software Benjamin Trenkle. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Joomla\String\StringHelper;
use Joomla\Registry\Registry;

$item = $this->item;

if (strlen($item->latitude) && strlen($item->longitude)
	&& $item->latitude <= 90 && $item->latitude >= -90
	&& $item->longitude <= 180 &&  $item->longitude >= -180
	&& $this->params->get('enable_map', '1')):

	$options = new Registry;

	$options->set('mapclass', 'wickedlocation-map');

	$google = new JGoogle($options);

	$map = $google->embed('Maps');

	$map->setKey($this->params->get('googlemap_apikey'));

	$map->setCenter(array($item->latitude, $item->longitude), StringHelper::substr(json_encode($this->escape($item->title), JSON_HEX_APOS), 1, -1));

	$map->setZoom((int) $item->zoom);

	$map->setAutoload();

	$map->echoHeader();

	$map->echoBody();

endif;
