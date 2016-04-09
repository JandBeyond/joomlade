<?php defined('_JEXEC') or die; ?>
<?php if ($params->get('show_version', true)) : ?>
    <p class="name"><?php echo JText::_('MOD_JVERSION_VERSION_PREFIX'); ?><?php echo $release->tag_name; ?></p>
<?php endif; ?>
<?php if ($params->get('show_download', true)) : ?>
    <p>
        <a href="<?php echo $release->downloadUrl; ?>" class="btn btn-primary download blue">
            <span class="fa fa-cloud-download"></span> <?php echo JText::_('MOD_JVERSION_DOWNLOAD'); ?>
        </a>
    </p>
<?php endif; ?>
<?php if ($params->get('show_download_count', true)) : ?>
    <p class="downloads">
        <?php echo number_format($release->downloads, 0, ',', '.') ?> <?php echo JText::_('MOD_JVERSION_DOWNLOADS'); ?>
    </p>
<?php endif; ?>
<p class="name">N&auml;chste Version</p>
<p>Beim Testen helfen</p>
<p class="area-community"><a href="https://docs.joomla.org/Testing_Joomla!_patches/de" target="_blank" class="btn btn-primary download orange"><span class="fa fa-code-fork">&nbsp; </span>So geht's</a></p>


