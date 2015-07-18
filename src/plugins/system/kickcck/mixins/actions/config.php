<?php
/**
 * Joomla! System plugin - KickCCK
 *
 * @author     Niels Nuebel <niels@niels-nuebel.de>
 * @copyright  Copyright 2015 Niels Nuebel. All rights reserved
 * @license    GNU Public License
 * @link       http://www.niels-nuebel.de
 */

// Namespace
namespace CCK\Actions;

use Joomla\Registry\Registry;

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class Config
 *
 * @package CCK\Actions
 */
class Config
{
	/**
	 * Task method to get the Config for the CCK Plugin
	 *
	 * @param   string  $configfile  config json file.
	 * @param   string  $configpath  Path to config json file.
	 *
	 * @return	Object
	 */
	public function loadCCKConfig($configfile, $configpath)
	{
		$app = \JFactory::getApplication();
		$path = JPATH_ROOT . '/' . $configpath . '/' . $configfile;

		if (!file_exists(\JPath::clean($path)))
		{
			$app->enqueueMessage(\JText::sprintf('PLG_SYSTEM_KICKCCK_ERROR_CONFIG_JSON_NOT_EXISTS' , $path), 'error');

			return false;
		}

		$registry = new Registry;
		$registry->loadFile($path);

		return $registry;
	}
}
