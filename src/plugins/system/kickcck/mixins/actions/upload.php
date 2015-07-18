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
 * Class Upload
 *
 * @package NN\Actions
 */
class Upload
{
	/**
	 *
	 * @param array $image
	 * @param object $field
	 * @throws \Exception
	 *
	 * @return bool
	 */
	public function uploadImage($id, $image, $field, $olddata, $params)
	{
		$attributes = $field->getAttributes();
		$app = \JFactory::getApplication();

		if(isset($attributes['folder']) && $attributes['folder'] != '')
			$path               = \JPath::clean( $attributes['path'] . '/' . $id . '/' . $attributes['folder']);
		else
			$path               = \JPath::clean( $attributes['path'] . '/' . $id);

		$absolutepath       = \JPath::clean(JPATH_ROOT . '/' . $path);

		$fileName = \JFile::makeSafe($image['name']);

		if(!\JFolder::exists($absolutepath))
		{
			\JFolder::create($absolutepath);
		}

		if($params->get('override_image',0))
		{
			if (file_exists(\JPath::clean($absolutepath . '/' . $image['name'])))
			{
				$app->enqueueMessage(\JText::sprintf('PLG_SYSTEM_KICKCCK_ERROR_IMAGE_EXISTS' ,$image['name']), 'error');

				return false;
			}
		}

		if (!\JFile::upload($image['tmp_name'], \JPath::clean($absolutepath . '/' . $fileName)))
		{
			$app->enqueueMessage(JText::_('PLG_SYSTEM_KICKCCK_ERROR_UPLOAD_ERROR'), 'error');

			return false;
		}

		$image = new \JImage(\JPath::clean($absolutepath . '/' . $fileName));

		if($attributes['thumbnails'])
		{
			// 1 SCALE_FILL = Wird auf das ThumbFormat gezogen
			// 2 SCALE_INSIDE =  Größte Ecke wird an das Thumbnail angepasst
			// 3 SCALE_OUTSIDE = Kleinste Ecke wird auf thumb genommen nachteil der Dateiname ist nicht wie der andere
			// 4 CROP =  Original Größe bleibt nur der Ausschnitt wird angepasst
			// 5 CROP_RESIZE =  mit runten rechnen
			// 6 SCALE_FIT =  Bild hält das Format wie angeben SCHWARZ
			if(isset($attributes['thumbcrop']))
			{
				$creationMethods = explode(',', $attributes['thumbcrop']);
			}
			else {
				$creationMethods = array(2);
			}
			$thumbSizesArry = explode('|', $attributes['thumbnails']);

			$thumbs = new \StdClass();
			foreach($creationMethods as $key => $creationMethod)
			{
				if(isset($thumbSizesArry[$key]))
				{
					$thumbSizes = explode(',', $thumbSizesArry[$key]);
				}
				else
					$thumbSizes = explode(',', $thumbSizesArry[0]);

				if(!$thumbsresult = $image->createThumbs($thumbSizes, $creationMethod, $absolutepath . '/thumbs'))
					return false;
				else
				{
					foreach($thumbsresult as $thumbr)
					{
						$imgProperties = \JImage::getImageFileProperties($thumbr->getPath());
						switch ($imgProperties->type)
						{
							case IMAGETYPE_GIF:
								$thumbr->toFile($thumbr->getPath(),$imgProperties->type);
								break;

							case IMAGETYPE_PNG:
								$thumbr->toFile($thumbr->getPath(),$imgProperties->type, array("quality" => 3));
								break;

							case IMAGETYPE_JPEG:
							default:
								$thumbr->toFile($thumbr->getPath(),$imgProperties->type, array("quality" => 75));
						}

					}
					$thumbs = (object) array_merge((array) $thumbs, (array)$thumbsresult);
				}
			}

			/*$creationMethod = $attributes['thumbcrop'] ? (int) $attributes['thumbcrop'] : 2;
			$thumbSizes = explode(',', $attributes['thumbnails']);
			if(!$thumbs = $image->createThumbs($thumbSizes, $creationMethod, $absolutepath . '/thumbs'))
				return false;*/

			$imagearray = array();

			$counter = 1;
			foreach($thumbs as $key => $thumb)
			{
				$imagepath = $thumb->getPath();
				$imagepath = str_replace($absolutepath, $path, $imagepath);

				$imagearray['thumb_' . $counter] = $imagepath;

				$counter++;
			}

		}
		$image->destroy();

		$registry = new \JRegistry;
		$registry->loadString($olddata->cckimages);


		if($oldimages = $registry->get($attributes['name'],false))
		{
			$deleteimages[] = $oldimages->image;

			foreach($oldimages->thumbs as $oldthumb)
			{
				$deleteimages[] = $oldthumb;
			}
		}

		$url = \JPath::clean($path . '/' . $fileName);

		if($oldimages->image and $oldimages->image != $url)
			$this->deleteOldImages($deleteimages);

		$registry->set($attributes['name'] . '.image', $url);
		$registry->set($attributes['name'] . '.thumbs',$imagearray);
		$olddata->cckimages = (string) $registry;


		return $olddata;
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
