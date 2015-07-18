<?php
/**
 * @version 1.0.0
 * @package NNEditTemplate
 * @copyright 2015 Niels Nübel- NN-Medienagentur
 * @license GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.nn-medienagentur.de
 */

defined('_JEXEC') or die;


/**
 * Class plgSystemNNEditTemplate
 *
 * @category NNEditTemplate
 * @package NNEditTemplate
 * @author Niels Nübel <n.nuebel@nn-medienagentur.de>
 * @license GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.nn-medienagentur.de
 * @since 1.0.0
 */
class plgSystemNNEdittemplate extends JPlugin
{
	public function __construct(& $subject, $config) {
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	function onAfterRoute() {
		$app    = JFactory::getApplication();
		$controller = $app->input->getCmd('controller', '');
		$option = $app->input->getCmd('option', '');
		$aid    = $app->input->getCmd('a_id', 0);
		$id    = $app->input->getCmd('id', 0);
		$layout   = $app->input->getCmd('layout', '');
		$tid    = $this->params->get('edittemplateid',0);
		if($option == 'com_content' && $layout == 'edit' && $aid > 0)
		{
			$app->input->set('templateStyle', $tid);
		}
		elseif($option == 'com_config' && $controller == 'config.display.modules' && $id > 0)
		{
			$app->input->set('templateStyle', $tid);
		}
	}
}