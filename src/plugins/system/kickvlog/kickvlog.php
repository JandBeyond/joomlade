<?php
/**
 * Joomla! System plugin - KickVlog
 *
 * @author     Niels Nuebel <info@kicktemp.com>
 * @copyright  Copyright 2016 Kicktemp. All rights reserved
 * @license    GNU Public License
 * @link       http://www.kicktemp.com
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * KickVlog System Plugin
 */
class plgSystemKickVlog extends JPlugin
{
	/**
	 * A Registry array holding the form name.
	 *
	 * @var    Registry
	 * @since  1.5
	 */
	protected $forms = array('com_content.article', 'com_content.articles.filter');

	protected $app;

	/**
	 * Constructor
	 *
	 * @param   object &$subject Instance of JEventDispatcher
	 * @param   array  $config   Configuration
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

	/**
	 * Event method that runs on content preparation
	 *
	 * @param   JForm   $form The form object
	 * @param   integer $data The form data
	 *
	 * @return bool
	 */
	public function onContentPrepareForm($form, $data)
	{
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');

			return false;
		}

		$name = $form->getName();

		if (!in_array($name, $this->forms))
		{
			return true;
		}

		JForm::addFormPath(__DIR__ . '/form');

		if ($name == 'com_content.article')
		{
			$form->loadFile('kickvlog', false);
		}
	}

	public function onContentBeforeSave($context, $data, $isNew)
	{
		$form = $this->app->input->get('jform',false,'ARRAY');

		if ($context == 'com_content.article')
		{
			$article_layout = $form['attribs']['article_layout'];

			if (isset($data->attribs))
			{
				$attrname = "attribs";
			}
			else
			{
				$attrname = "params";
			}

			$attribs = json_decode($data->$attrname);

			if (!$article_layout && $attribs->youtube_id != '')
			{
				$attribs->article_layout = 'joomlade:youtube';
			}

			$data->$attrname = json_encode($attribs);
		}
	}
}
