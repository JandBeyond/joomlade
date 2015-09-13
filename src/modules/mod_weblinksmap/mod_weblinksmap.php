<?php

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$list = ModWeblinksmapHelper::getList($params);

// chart

$chart_data = array();

foreach ($list as $item)
{
    $image = json_decode($item->images);

    $chart_data[] = array('metadesc' => $item->metadesc, 'title' =>$item->title, 'link' => $item->link);
}

ModWeblinksmapHelper::drawChart($chart_data);

if (!count($list))
{
    return;
}

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_weblinksmap', $params->get('layout', 'default'));