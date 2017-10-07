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
$googlefont         = $params->get('googlefont', 'Open+Sans:400,800');
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

//Add CSS
$doc->addStyleSheet($tpath . '/css/joomlade.css');

//Add Apple touch Icon
$doc->addHeadLink($tpath.'/images/apple-touch-icon.png', 'apple-touch-icon');
$doc->addHeadLink($tpath.'/images/favicon.ico', 'shortcut icon', 'rel', array('type' => 'image/vnd.microsoft.icon'));

?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <!--<![endif]-->
<head>
  <meta name="x-ua-compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="<?php echo $tpath; ?>/js/joomlade.min.js?v=2"></script>

  <jdoc:include type="head" />

  <meta property="og:image" content="<?php echo $tpath; ?>/images/og-logo.png" />
  <!--[if lte IE 9]>
  <script src="<?php echo $tpath; ?>/js/html5shiv.min.js"></script>
  <script src="<?php echo $tpath; ?>/js/respond.min.js"></script>
  <![endif]-->
</head>
<body class="<?php echo $pageclass ?>">
  <!-- Hidden anchor links for accessibility -->
  <a href="#mainnav" class="skiplink"><?php echo JText::_('TPL_JOOMLADE_ANCHOR_NAV'); ?></a>
  <a href="#maincontent" class="skiplink"><?php echo JText::_('TPL_JOOMLADE_ANCHOR_CONTENT'); ?></a>

  <div id="outerwrapper" class="container-fluid">
    <div class="fullwidth">
      <header id="header">
        <a href="/"><img id="logo" src="<?php echo $tpath; ?>/images/logo.svg" alt="Logo des Joomla Projekts" /></a>

        <button id="navtoggler" class="visible-xs-block">
          <span class="fa fa-bars"><span class="sr-only"><?php echo JText::_('TPL_JOOMLADE_SHOWHIDENAV'); ?></span></span>
        </button>

        <nav id="mainnav">
          <jdoc:include type="modules" name="nav" />
        </nav>



        <jdoc:include type="modules" name="header" />
      </header>
    </div>

    <?php if($this->countModules('top-stack')):  ?>
      <div id="top-stack" class="row">
        <jdoc:include type="modules" name="top-stack" style="html5" />
      </div>
    <?php endif; ?>

    <?php if($this->countModules('top-a')):  ?>
      <div id="top-a" class="row">
        <jdoc:include type="modules" name="top-a" style="joomlade" width="col-lg-<?php echo round(12 / $this->countModules('top-a')); ?>"  />
      </div>
    <?php endif; ?>
    <?php if($this->countModules('top-b')):  ?>
      <div id="top-b" class="row">
        <jdoc:include type="modules" name="top-b" style="joomlade" width="col-md-<?php echo round(12 / $this->countModules('top-b')); ?>"  />
      </div>
    <?php endif; ?>
    <?php if($this->countModules('top-c')):  ?>
      <div id="top-c" class="row">
        <jdoc:include type="modules" name="top-c" style="joomlade" width="col-lg-<?php echo round(12 / $this->countModules('top-c')); ?>"  />
      </div>
    <?php endif; ?>

    <?php if(!$isFrontpage): ?>
        <div id="mainwrapper" class="row">
            <main id="maincontent" class="<?php if($this->countModules('aside')) {echo 'col-lg-9';} else {echo 'col-lg-12';} ?>">
                <jdoc:include type="message" />
                <jdoc:include type="component" />
                <jdoc:include type="modules" name="mainbody-bottom" style="html5" />
            </main>

            <?php if($this->countModules('aside')): ?>
                <section id="aside" class="col-lg-3">
                    <jdoc:include type="modules" name="aside" style="html5" />
                </section>
            <?php endif; ?>
        </div>
    <?php endif ;?>

    <?php if($this->countModules('events')):  ?>
      <div id="events" class="row area-events">
        <div class="col-lg-12">
          <h3 class="moduleheading fullwidth"><?php echo JText::_('TPL_JOOMLADE_HEADING_EVENTS'); ?></h3>
        </div>
        <jdoc:include type="modules" name="events" style="joomlade" width="col-lg-<?php echo round(12 / $this->countModules('events')); ?>"  />
      </div>
    <?php endif; ?>

    <?php if($this->countModules('bottom-a')):  ?>
      <div id="bottom-a" class="row">
        <jdoc:include type="modules" name="bottom-a" style="joomlade" width="col-lg-<?php echo round(12 / $this->countModules('bottom-a')); ?>"  />
      </div>
    <?php endif; ?>
    <?php if($this->countModules('bottom-b')):  ?>
      <div id="bottom-b" class="row">
        <jdoc:include type="modules" name="bottom-b" style="joomlade" width="col-lg-<?php echo round(12 / $this->countModules('bottom-b')); ?>"  />
      </div>
    <?php endif; ?>
    <?php if($this->countModules('bottom-c')):  ?>
      <div id="bottom-c" class="row">
        <jdoc:include type="modules" name="bottom-c" style="joomlade" width="col-lg-<?php echo round(12 / $this->countModules('bottom-c')); ?>"  />
      </div>
    <?php endif; ?>

    <?php if($this->countModules('bottom-stack')):  ?>
      <div id="bottom-stack" class="row">
        <jdoc:include type="modules" name="bottom-stack" style="html5" />
      </div>
    <?php endif; ?>

      <div class="fullwidth">
        <footer id="footer">
          <jdoc:include type="modules" name="footer" style="html5" />
        </footer>
      </div>
  </div>
  <!-- Piwik -->
  <script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(["setDomains", ["*.www.joomla.de"]]);
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
      var u="//stats.joomla.de/";
      _paq.push(['setTrackerUrl', u+'piwik.php']);
      _paq.push(['setSiteId', 3]);
      var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
      g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
  </script>
  <noscript><p><img src="//stats.joomla.de/piwik.php?idsite=3" style="border:0;" alt="" /></p></noscript>
  <!-- End Piwik Code -->
</body>
<jdoc:include type="modules" name="debug" />
</html>
