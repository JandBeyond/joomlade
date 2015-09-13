<?php

// TODO caching
// TODO styling
// TODO

defined('_JEXEC') or die;

// Require the module helper file
require_once __DIR__ . '/helper.php';

// Get a new ModGCalendarHelper instance
$gcalenderHelper = new ModGCalendarHelper($params);

// Get the next events
$events = $gcalenderHelper->nextEvents();

require JModuleHelper::getLayoutPath('mod_gcalendar', $params->get('layout', 'list'));
