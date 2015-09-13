<?php

// TODO styling
// TODO prepare the results

defined('_JEXEC') or die;

// Require the module helper file
require_once __DIR__ . '/helper.php';

// Get a new ModGCalendarHelper instance
$gcalenderHelper = new ModGCalendarHelper($params);

// Setup joomla cache
$cache = JFactory::getCache();
$cache->setCaching(true);
$cache->setLifeTime($params->get('api_cache_time', 60));

// Get the next events
$events = $cache->call(
	array($gcalenderHelper, 'nextEvents'),
	(int) $params->get('max_list_events', 5)
);

require JModuleHelper::getLayoutPath('mod_gcalendar', $params->get('layout', 'default'));
