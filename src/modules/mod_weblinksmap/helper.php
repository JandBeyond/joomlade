<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_weblinks
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_weblinks/helpers/route.php';
require_once JPATH_SITE . '/components/com_weblinks/helpers/category.php';

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_weblinks/models', 'WeblinksModel');

/**
 * Helper for mod_weblinks
 *
 * @package     Joomla.Site
 * @subpackage  mod_weblinks
 */
class ModWeblinksmapHelper
{
    public static function getList($params)
    {
        // Get an instance of the generic articles model
        $model = JModelLegacy::getInstance('Category', 'WeblinksModel', array('ignore_request' => true));

        // Set application parameters in model
        $app = JFactory::getApplication();
        $appParams = $app->getParams();
        $model->setState('params', $appParams);

        // Set the filters based on the module params
        $model->setState('list.start', 0);
        $model->setState('list.limit', (int) $params->get('count', 5));

        $model->setState('filter.state', 1);
        $model->setState('filter.publish_date', true);

        // Access filter
        $access = !JComponentHelper::getParams('com_weblinks')->get('show_noauth');
        $model->setState('filter.access', $access);

        $ordering = $params->get('ordering', 'ordering');
        $model->setState('list.ordering', $ordering == 'order' ? 'ordering' : $ordering);
        $model->setState('list.direction', $params->get('direction', 'asc'));

        $catid	= (int) $params->get('catid', 0);
        $model->setState('category.id', $catid);

        // Create query object
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $case_when1 = ' CASE WHEN ';
        $case_when1 .= $query->charLength('a.alias', '!=', '0');
        $case_when1 .= ' THEN ';
        $a_id = $query->castAsChar('a.id');
        $case_when1 .= $query->concatenate(array($a_id, 'a.alias'), ':');
        $case_when1 .= ' ELSE ';
        $case_when1 .= $a_id.' END as slug';

        $case_when2 = ' CASE WHEN ';
        $case_when2 .= $query->charLength('c.alias', '!=', '0');
        $case_when2 .= ' THEN ';
        $c_id = $query->castAsChar('c.id');
        $case_when2 .= $query->concatenate(array($c_id, 'c.alias'), ':');
        $case_when2 .= ' ELSE ';
        $case_when2 .= $c_id.' END as catslug';

        $model->setState(
            'list.select',
            'a.*, c.published AS c_published,' . $case_when1 . ',' . $case_when2 . ',' . 'DATE_FORMAT(a.created, "%Y-%m-%d") AS created'
        );

        $model->setState('filter.c.published', 1);

        // Filter by language
        $model->setState('filter.language', $app->getLanguageFilter());

        $items = $model->getItems();

        if ($items)
        {
            foreach ($items as $item)
            {

                $item->link = $item->url;

            }
            return $items;
        }
        else
        {
            return;
        }
    }

    public static function drawChart($chart_data)
    {

        $chart_data= json_encode($chart_data);

        $doc =& JFactory::getDocument();

        $doc->addScript('https://www.google.com/jsapi');

        $chart = '
            google.load(\'visualization\', \'1\', {\'packages\': [\'geomap\'], \'language\': \'de\'});
            google.setOnLoadCallback(drawRegionsMap);

            var chart;
            var options;
            var objects = [];
            var results;
            var data;

            objects.push('. $chart_data.');

            function drawRegionsMap() {
                data = new google.visualization.DataTable();
                data.addColumn(\'string\', \'City\');
                data.addColumn(\'number\', \'Value\');
                data.addColumn({type:\'string\', role:\'tooltip\'});

                for (var i = 0; i < objects[0].length; i++) {
                    data.addRow([objects[0][i].metadesc,0,"JUG " + objects[0][i].title]);
                }

                options = {
                    region: \'155\',
                    displayMode: \'markers\',
                    enableRegionInteractivity: false,
                    backgroundColor: {fill: \'#123\', stroke: \'#c1c1c1\'},
                    datalessRegionColor: \'fff\',
                    markerOpacity: \'0.7\',
                    defaultColor: \'#345\',
                    colorAxis: {colors:[\'#f9b431\',\'#f9b431\']},
                    legend: \'none\',
                    keepAspectRatio: true,
                    tooltip: {textStyle: {color: \'#484848\', fontSize: \'15\'}, showColorCode: true, trigger: \'focus\'},
                };

                chart = new google.visualization.GeoChart(document.getElementById(\'chart_div\'));
                chart.draw(data, options);

                google.visualization.events.addListener(chart, \'select\', function() {

                    var selectedItem = chart.getSelection();

                    if (selectedItem.length > 0) {
                        var row = selectedItem[0].row;
                        var elementId = data.getValue(row,0);
                        var defaultColor = document.getElementById(elementId).style.color;

                        window.location = \'#\' + elementId;

                        document.getElementById(elementId).style.backgroundColor = \'#85c03c;\';
                        document.getElementById(elementId).style.fontWeight = \'bold\';
                        document.getElementById(elementId).style.color = \'#fff;\';

                        jQuery(\'#\' + elementId).children(\'.hidden-phone\').tooltip(\'show\');

                        setTimeout(function(){
                            document.getElementById(elementId).style.backgroundColor = defaultColor;
                            document.getElementById(elementId).style.fontWeight = \'normal\';
                            jQuery(\'#\' + elementId).children(\'.hidden-phone\').tooltip(\'hide\');
                        }, 1500);

                    }
                });

            }

            jQuery(document).ready(function () {
                jQuery(window).resize(function(){
                    drawRegionsMap();
                });
            });


        ';

        $doc->addScriptDeclaration($chart);
    }
}
