<?php use Joomla\Registry\Registry;

defined('_JEXEC') or die;

/**
 * Class ModJVersionHelper
 */
class ModJVersionHelper
{
    protected $xmlParser;

    /**
     * Get the latest joomla release from github api
     */
    public function latestRelease()
    {
        // Get the latest version
        $latestVersion = $this->latestVersion();

        // Setup JHttp
        $options       = new Registry();
        $options->def('userAgent', 'JVersion/1.0');
        $transport = new JHttpTransportStream($options);
        $http      = new JHttp($options, $transport);

        // Get the latest release from github api
        $url      = 'https://api.github.com/repos/joomla/joomla-cms/releases/tags/' . $latestVersion;
        $response = $http->get($url);
        $release  = json_decode($response->body);

        // Prepare the release
        $release->downloads = 0;
        foreach ($release->assets as $asset)
        {
            $release->downloads = $release->downloads + $asset->download_count;
            if ($asset->content_type == 'application/zip' && strpos($asset->name, 'Full') !== false)
            {
                $release->downloadUrl = $asset->browser_download_url;
            }
        }

        return $release;
    }

    /**
     * Gets the latest joomla version from the update server xml file
     *
     * @return string
     */
    protected function latestVersion()
    {
        $versions   = [];
        $url        = 'https://update.joomla.org/core/sts/list_sts.xml';
        $extensions = new SimpleXMLElement($url, 0, true);
        foreach ($extensions as $extension)
        {
            $version = (string) $extension['version'];
            if (!in_array($version, $versions))
            {
                $versions[] = $version;
            }
        }
        usort($versions, 'version_compare');

        return array_pop($versions);
    }
}
