<?php use Joomla\Registry\Registry;

defined('_JEXEC') or die;

/**
 * Class ModJVersionHelper
 */
class ModJVersionHelper
{
    /**
     * Get the latest joomla release
     */
    public function latest()
    {
        $options = new Registry();
        $options->def('userAgent', 'JGitHub/2.0');
        $transport = new JHttpTransportStream($options);
        $http      = new JHttp($options, $transport);
        $response  = $http->get('https://api.github.com/repos/joomla/joomla-cms/releases/latest');
        $release   = json_decode($response->body);

        $release->downloads = 0;
        foreach ($release->assets as $asset) {
            $release->downloads = $release->downloads + $asset->download_count;
            if ($asset->content_type == 'application/zip' && strpos($asset->name, 'Full') !== false) {
                $release->downloadUrl = $asset->browser_download_url;
            }
        }

        return $release;
    }
}
