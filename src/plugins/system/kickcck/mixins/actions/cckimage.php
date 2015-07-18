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

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class CCKImage
 *
 * @package CCK\Actions
 */
class CCKImage
{
	public function generateCCKImageForm ($cckimageconfig)
	{
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$xml .= '<form>';
		$xml .= '<fieldset name="cckimages">';

		foreach ($cckimageconfig as $name => $element) {

			$xml .= '<field name="' . $name . '" type="cckimage"';
			$xml .= ' size="40" label="' . $element->label . '"';
			$xml .= ' description="' . $element->description . '"';
			$xml .= ' path="' . $element->path . '"';
			$xml .= ' folder="' . $element->folder . '"';
			$xml .= ' thumbnails="' . $element->thumbnails . '"';
			$xml .= ' thumbcrop="' . $element->thumbcrop . '"';
			$xml .= ' onchange="jQuery(this).closest(\'form\').attr(\'enctype\',\'multipart/form-data\')"';
			$xml .= ' />';
		}

		$xml .= '</fieldset>';
		$xml .= '</form>';

		return $xml;
	}

	public function loadCCKImageContent($data, $config)
	{
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($config->select)
			->from($db->quoteName('#__kickcck_images') . ' AS i')
			->join('LEFT', $db->quoteName($config->join) . ' AS content ON content.id = i.content_id')
			->where($db->quoteName('i.content_id') . '=' . $data->id)
			->where($db->quoteName('i.context') . '=' . $db->quote($config->contextwhere));
		;
		$db->setQuery($query);
		$cckdata = $db->loadAssoc();

		$data = $this->DBMapping($data, $cckdata, $config->mappings);

		return $data;
	}

	public function saveCCKImageContent($content_id, $context, $cckimages)
	{
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('content_id'))
			->from($db->quoteName('#__kickcck_images'))
			->where($db->quoteName('content_id') . '=' . $content_id)
			->where($db->quoteName('context') . '=' . $db->quote($context));

		$db->setQuery($query);
		$db->execute();
		$exists = (bool) $db->getNumRows();

		$data = new \stdClass;
		$data->content_id = $content_id;
		$data->context = $context;
		$data->cckimages = $cckimages;

		if ($exists)
		{
			$result = $db->updateObject('#__kickcck_images', $data, 'content_id');
		}
		else
		{
			$result = $db->insertObject('#__kickcck_images', $data);
		}
		return $result;
	}

	protected function DBMapping ($data, $cckdata, $mappings = array())
	{
		if(!count($mappings))
			return $data;

		foreach($mappings as $mapping)
		{
			if($cckdata != null)
			{
				$data->$mapping = $cckdata[$mapping];
				$data = $this->extractData($data, $data->$mapping);
			}
			else
				$data->$mapping = null;
		}

		return $data;
	}

	protected function extractData($data, $json)
	{
		$images = json_decode($json);
		foreach($images as $key => $image)
		{
			$value = (isset($image->thumbs->thumb_1)) ? $image->thumbs->thumb_1 : $image->image;
			$data->$key = $value;
		}

		return $data;
	}


	//TODO löschen funktion einbauen
	public function deleteCCKImages($id,$context)
	{
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true)
			->delete($db->quoteName('#__kickcck_images'))
			->where($db->quoteName('context') . '=' . $db->quote($context))
			->where($db->quoteName('id') . '=' . $id);
		$db->setQuery($query);
		$db->execute();
	}

	public function deleteCCKImage($id,$filename,$context)
	{
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('cckimages'))
			->from($db->quoteName('#__kickcck_images'))
			->where($db->quoteName('context') . '=' . $db->quote($context))
			->where($db->quoteName('content_id') . '=' . $id);
		$db->setQuery($query);
		$result = $db->loadAssoc();

		$registry = new \JRegistry;
		$registry->loadString($result['cckimages']);

		$oldimage = $registry->get($filename . '.image',false);
		if($oldimage)
		{
			$deleteimages[] = $oldimage;

			foreach($registry->get($filename . '.thumbs', array()) as $oldthumb)
			{
				$deleteimages[] = $oldthumb;
			}
		}
		$this->deleteOldImages($deleteimages);

		$cleanObject = $registry->toObject();
		unset($cleanObject->$filename);

		$query = $db->getQuery(true);
		$query->update('#__kickcck_images');
			$query = $db->getQuery(true);
			$query->update('#__kickcck_images')
			->set('cckimages = ' . $db->quote((string) $registry))
			->where($db->quoteName('context') . '=' . $db->quote($context))
			->where($db->quoteName('content_id') . '=' . $id);
		$db->setQuery($query);

		$db->execute();
		echo implode("\n", $deleteimages);
	}

	protected function deleteOldImages($images)
	{
		foreach($images as $image)
		{
			\JFile::delete(\JPath::clean(JPATH_ROOT . '/' . $image));
		}
		return true;
	}
}
