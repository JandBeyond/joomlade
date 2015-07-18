<?php
/**
 * JOOMLADE
 * 
 * @package     Joomla.Site
 * @subpackage  Templates.joomlade
 *
 * @author      Niels Nübel <n.nuebel@nn-medienagentur.de>
 * @copyright   Copyright (c) 2015 NN-Medienagentur.de
 * @license     GNU General Public License version 2 or later
 */

defined( '_JEXEC' ) or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;

// Getting params from template
$params = $app->getTemplate(true)->params;

// Set JOOMLADE Variables
$menu               = $app->getMenu();
$active             = $app->getMenu()->getActive();
$pageclass          = $app->getParams()->get('pageclass_sfx');
$tpath              = $this->baseurl.'/templates/'.$this->template;
$googlefont         = $params->get('googlefont');
$showsystemoutput   = $params->get('showsystemoutput', 1);

$isFrontpage        = false;
$active_alias       = '';

if ($active)
{
    $defaultmenuitems = array($menu->getDefault()->id, $menu->getDefault(JFactory::getLanguage()->getTag())->id);
    $isFrontpage = in_array($active->id, $defaultmenuitems);
    $active_alias = $active->alias;
}

// generator tag
$this->setGenerator(null);

if ($googlefont !='') $doc->addStyleSheet("https://fonts.googleapis.com/css?family=".$googlefont);

//Add CSS and Javascript
$doc->addStyleSheet($tpath . '/css/joomlade.css');
$doc->addScript($tpath.'/js/joomlade.js');

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
  <meta name="x-ua-compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <jdoc:include type="head" />
  <link rel="apple-touch-icon-precomposed" href="<?php echo $tpath; ?>/images/apple-touch-icon-57x57-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $tpath; ?>/images/apple-touch-icon-72x72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $tpath; ?>/images/apple-touch-icon-114x114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $tpath; ?>/images/apple-touch-icon-144x144-precomposed.png">
  <!--[if lte IE 9]>
  <script src="<?php echo $tpath; ?>/js/html5shiv.min.js"></script>
  <script src="<?php echo $tpath; ?>/js/respond.min.js"></script>
  <![endif]-->
</head>
<body>
  
</body>
<jdoc:include type="modules" name="debug" />
</html>