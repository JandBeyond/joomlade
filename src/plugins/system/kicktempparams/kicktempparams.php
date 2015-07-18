<?php
/**
 * @version 1.0.0
 * @package Kicktempparams
 * @copyright 2014 Niels Nübel- NN-Medienagentur
 * @license GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.nn-medienagentur.de
 */

defined('_JEXEC') or die;


/**
 * Class plgSystemKicktempparams
 *
 * @category Kicktempparams
 * @package Kicktempparams
 * @author Niels Nübel <n.nuebel@nn-medienagentur.de>
 * @license GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.nn-medienagentur.de
 * @since 1.0.0
 */
class plgSystemKicktempparams extends JPlugin
{
	public function __construct(& $subject, $config) {
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	public function onContentPrepareForm($form, $data) {
		if ($form->getName() == 'com_modules.module' or $form->getName() == 'com_advancedmodules.module') {
			JForm::addFormPath(__DIR__ . '/params');
			if ($this->params->get('add_bootstrap',1))
				$form->loadFile('bootstrap', false);
			if ($this->params->get('add_onepage',1))
				$form->loadFile('onepage', false);
		}
		if ($form->getName() == 'com_menus.item') {
			JForm::addFormPath(__DIR__ . '/params');
			if ($this->params->get('add_menu',1))
				$form->loadFile('kicktempmenu', false);
		}
	}
}
