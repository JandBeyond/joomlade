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
namespace CCK\Checks;

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class Ajax
 *
 * @package NN\Checks
 */
class CanUpload
{
	/**
	 * Checks if the file can be uploaded
	 *
	 * @param   array   $file  File information
	 * @param   string  $err   An error message to be returned
	 *
	 * @return  boolean
	 *
	 * @since   3.2
	 */
	public static function canUpload($file, $err = '', $params = array(), $field)
	{
		if (empty($file['name']))
		{
			$app = \JFactory::getApplication();
			$app->enqueueMessage(\JText::_('JLIB_MEDIA_ERROR_UPLOAD_INPUT'), 'error');

			return false;
		}

		// Media file names should never have executable extensions buried in them.
		$executable = array(
			'exe', 'phtml','java', 'perl', 'py', 'asp','dll', 'go', 'jar',
			'ade', 'adp', 'bat', 'chm', 'cmd', 'com', 'cpl', 'hta', 'ins', 'isp',
			'jse', 'lib', 'mde', 'msc', 'msp', 'mst', 'pif', 'scr', 'sct', 'shb',
			'sys', 'vb', 'vbe', 'vbs', 'vxd', 'wsc', 'wsf', 'wsh'
		);
		$explodedFileName = explode('.', $file['name']);

		if (count($explodedFileName) > 2)
		{
			foreach ($executable as $extensionName)
			{
				if (in_array($extensionName, $explodedFileName))
				{
					$app = \JFactory::getApplication();
					$app->enqueueMessage(\JText::_('PLG_SYSTEM_KICKCCK_ERROR_EXECUTABLE'), 'error');

					return false;
				}
			}
		}

		if ($file['name'] !== \JFile::makeSafe($file['name']) || preg_match('/\s/', \JFile::makeSafe($file['name'])))
		{
			$app = \JFactory::getApplication();
			$app->enqueueMessage(\JText::_('JLIB_MEDIA_ERROR_WARNFILENAME'), 'error');

			return false;
		}

		$format = strtolower(\JFile::getExt($file['name']));

		$sourceTypes	= explode(',', $params->get('source_formats'));

		if ($format == '' || $format == false || (!in_array($format, $sourceTypes)))
		{
			$app = \JFactory::getApplication();
			$app->enqueueMessage(\JText::_('JLIB_MEDIA_ERROR_WARNFILETYPE'), 'error');

			return false;
		}


		// Max upload size set to 2 MB for File Manager
		$maxSize = (int) ($params->get('upload_limit') * 1024 * 1024);

		if ($maxSize > 0 && (int) $file['size'] > $maxSize)
		{
			$app = \JFactory::getApplication();
			$app->enqueueMessage(\JText::_('JLIB_MEDIA_ERROR_WARNFILETOOLARGE'), 'error');

			return false;
		}

		$imagecheck  = \JImage::getImageFileProperties($file['tmp_name']);

		$memorycheck = ($imagecheck->width * $imagecheck->height * $imagecheck->bits) / (1024 * 1024);

		if($memorycheck > $params->get('memory_limit',128))
		{
			$app = \JFactory::getApplication();
			$app->enqueueMessage(\JText::sprintf('PLG_SYSTEM_NNEDITTEMPLATE_ERROR_TO_BIG' ,$file['name'],$memorycheck, $params->get('memory_limit',128)), 'error');

			return true;
		}

		return true;
	}
}
