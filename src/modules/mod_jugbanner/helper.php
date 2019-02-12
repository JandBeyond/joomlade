<?php
/**
 * @copyright   Copyright (C) 2018 Benjamin Trenkle. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Filesystem\File;
use Joomla\Filesystem\Path;
use Joomla\Filesystem\Folder;
use Joomla\CMS\Uri\Uri;
use Joomla\Image\Image;
use Joomla\CMS\Factory;
use Joomla\CMS\Http\HttpFactory;

/**
 * Helper for mod_jugbanner
 *
 * @since  1.0
 */
class ModJugbannerHelper
{
	protected static $bannerurl = 'https://jug-banners.wicked-software.de/banners.xml';

	protected static $verificationurl = 'https://jug-verification.wicked-software.de/verification';

	protected static $banners = __DIR__ . '/banners/';
	protected static $hash = 'sha512';

	public static function getBanners($params)
	{
		$xml = self::getXml($params);

		$result = [];

		if ($xml === false || !$xml instanceof SimpleXMLElement)
		{
			return $result;
		}

		foreach ($xml->children() as $banner)
		{
			if (is_file(static::$banners . $banner->image))
			{
				$result[] = (object) [
					'image' => Uri::root() . '/modules/mod_jugbanner/banners/' . (string) $banner->image,
					'link' => (string) $banner->link
				];
			}
		}

		return $result;
	}

	private static function getXml($params)
	{
		$xml = static::$banners . 'banners.xml';

		$now = Factory::getDate()->toUnix();

		$updatetime = (int) $params->get('updateinterval');

		$xmlcontent = false;

		$file_exists = is_file($xml);

		$lastchange = $file_exists && filemtime($xml);

		if (!$file_exists || ((int) $lastchange > 0 && (int) $updatetime > 0 && $now - $updatetime > $lastchange))
		{
			self::loadXml($params);
		}

		if (is_file($xml))
		{
			$xmlcontent = simplexml_load_file($xml);
		}

		return $xmlcontent;
	}

	private static function loadXml($params)
	{
		try
		{
			$http = HttpFactory::getHttp();

			$content = $http->get(static::$bannerurl);

			$valid = true;

			if ($params->get('verifyfile'))
			{
				$verify = $http->get(static::$verificationurl);

				$valid = $verify->code == 200 && $content->code == 200 && hash(static::$hash, $content->body) == $verify->body;
			}

			if ($content->code == 200 && $valid)
			{
				$xml = simplexml_load_string($content->body);

				if (is_dir(static::$banners))
				{
					Folder::delete(static::$banners);
				}

				Folder::create(static::$banners);

				$banners = [];

				foreach ($xml->children() as $banner)
				{
					$ext = pathinfo($banner->image, PATHINFO_EXTENSION);
					$filename = basename($banner->image);

					switch ($ext)
					{
						case 'jpg':
							$type = IMAGETYPE_JPEG;
							break;
						case 'png':
							$type = IMAGETYPE_PNG;
							break;
						case 'gif':
							$type = IMAGETYPE_GIF;
							break;

						default:
							continue 2;
					}

					$image = $http->get((string) $banner->image);

					if ($image->code !== 200)
					{
						continue;
					}

					if (strlen($banner->verify) && (string) $banner->verify !== hash(static::$hash, $image->body))
					{
						continue;
					}

					$res = imagecreatefromstring($image->body);

					$img = new Image($res);

					$path = Path::check(static::$banners . $filename);

					if ($img->toFile($path, $type))
					{
						$banners[] = (object) array(
							'image' => $filename,
							'link' => (string) $banner->link
						);
					}
				}

				$newxml = new SimpleXMLElement('<banners></banners>');

				foreach ($banners as $banner)
				{
					$bxml = $newxml->addChild('banner');

					$bxml->addChild('image', $banner->image);
					$bxml->addChild('link', $banner->link);
				}

				$newxml->asXML(static::$banners . 'banners.xml');
			}

		} catch (Exception $ex) {

		}
	}
}
