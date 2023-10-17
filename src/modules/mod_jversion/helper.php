<?php

use Joomla\Registry\Registry;

defined('_JEXEC') or die;

/**
 * Class ModJVersionHelper
 */
class ModJVersionHelper
{
	/**
	 * The Base url of joomla downloads api
	 */
	const API_BASE_URL = 'https://downloads.joomla.org/api/v1/';

	/**
	 * Get the latest joomla release from github api
	 */
	public function latestRelease()
	{
		$versions = [];
		$client   = $this->httpClient();
		$response = $client->get(self::API_BASE_URL . 'releases/cms/');
		$releases = json_decode($response->body);

		// Add each release to a versions array
		foreach ($releases->releases as $release)
		{
			if ($release->version[0] === "3"
			    || $release->version[0] === "4")
			{
				continue;
			}

			$versions[$release->version] = $release;
		}

		// Sort the versions
		uksort($versions, 'version_compare');

		// Get the latest release
		$latestRelease = array_pop($versions);

		// Get the number of downloads
		$latestRelease->downloads = $this->downloads($latestRelease->version);

		// Get the download Url for the zip file
		$latestRelease->downloadUrl = $this->fullPackageZipDownloadUrl($latestRelease->version);

		return $latestRelease;
	}

	/**
	 * Get the number of downloads for a specific version
	 *
	 * @param string $version
	 *
	 * @return int|null
	 */
	protected function downloads($version)
	{
		// Joomla Api uses version branch names (ie '30' for all 3.x.x releases)
		$versionBranch = $version[0] . '0';

		$client    = $this->httpClient();
		$response  = $client->get(self::API_BASE_URL . 'downloads/cms/' . $versionBranch);
		$downloads = json_decode($response->body);

		foreach ($downloads->versions as $versionDownloads)
		{
			if ($version == $versionDownloads->version)
			{
				return $versionDownloads->count;
			}
		}
	}

	/**
	 * Get the download url for a specific version
	 *
	 * @param $version
	 *
	 * @return string|null
	 */
	protected function fullPackageZipDownloadUrl($version)
	{
		$dashedVersion = str_replace('.', '-', $version);
		$client        = $this->httpClient();
		$response      = $client->get(self::API_BASE_URL . 'signatures/cms/' . $dashedVersion);
		$signatures    = json_decode($response->body);

		foreach ($signatures->files as $file)
		{
			if (strpos($file->filename, 'Full') !== false && strpos($file->filename, '.zip'))
			{
				return $this->prependDownloadPath($file->filename, $version);
			}
		}
	}

	/**
	 * Get the http client
	 *
	 * @return JHttp
	 */
	protected function httpClient()
	{
		// Setup JHttp
		$options = new Registry();
		$options->def('userAgent', 'JVersion/2.0');
		$transport = new JHttpTransportStream($options);

		return new JHttp($options, $transport);
	}

	/**
	 * Prepend the joomla download path to a file name
	 *
	 * @param $fileName
	 * @param $version
	 *
	 * @return string
	 */
	protected function prependDownloadPath($fileName, $version)
	{

		$baseUrl       = 'https://downloads.joomla.org/cms';
		$major         = $version[0];
		$dashedVersion = str_replace('.', '-', $version);

		return $baseUrl . '/joomla' . $major . '/' . $dashedVersion . '/' . $fileName;
	}
}
