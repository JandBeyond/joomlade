<?php
/**
 * @package     JoomlaDE
 * @subpackage  mod_weblinksmap
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters and Christian Hent. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$list = ModWeblinksmapHelper::getList($params);

// Chart

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