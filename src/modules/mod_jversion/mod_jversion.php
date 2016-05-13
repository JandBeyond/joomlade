<?php

defined('_JEXEC') or die;

try {
    // Require the module helper file
    require_once __DIR__ . '/helper.php';

    // Setup joomla cache
    $helper = new ModJVersionHelper;
    $cache  = JFactory::getCache();
    $cache->setCaching(true);
    $cache->setLifeTime($params->get('cache_time', 360));

    // Get the latest version
    $release = $cache->call(array($helper, 'latestRelease'));

    require JModuleHelper::getLayoutPath('mod_jversion', $params->get('layout', 'default'));
} catch (Exception $e) {
    JFactory::getApplication()->enqueueMessage(
        'JVersion error: ' . $e->getMessage(), 'error'
    );
}

