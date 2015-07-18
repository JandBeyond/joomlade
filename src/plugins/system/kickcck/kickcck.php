<?php
/**
 * Joomla! System plugin - KickCCK
 *
 * @author     Niels Nuebel <niels@niels-nuebel.de>
 * @copyright  Copyright 2015 Niels Nuebel. All rights reserved
 * @license    GNU Public License
 * @link       http://www.niels-nuebel.de
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

// Require the parent
require_once __DIR__ . '/abstract.php';

jimport('joomla.image.image');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
/**
 * KickCCK System Plugin
 */
class plgSystemKickCCK extends plgSystemKickCCKAbstract
{
	/**
	 * Collection of mixins used in this plugin
	 */
	protected $mixins = array(
		'actions/config',
		'checks/canupload',
		'actions/addmenu',
		'actions/cck',
		'actions/upload',
		'actions/cckimage'
	);

	/**
	 * A Registry array holding the form name.
	 *
	 * @var    Registry
	 * @since  1.5
	 */
	protected $configpath = 'media/plg_system_kickcck/config';

	/**
	 * A Registry array holding the form name.
	 *
	 * @var    Registry
	 * @since  1.5
	 */
	protected $forms = null;

	/**
	 * A Registry array holding the form name.
	 *
	 * @var    Registry
	 * @since  1.5
	 */
	public $cckconfig = null;

	/**
	 * Constructor
	 *
	 * @param object $subject
	 * @param array  $config
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);

		$this->loadLanguage();


		$configfile = $this->params->get('cckconfigfile', 'demo.json');
		$this->cckconfig = $this->loadCCKConfig($configfile, $this->configpath);

		$this->forms = $this->cckconfig->get('forms', array());

		if($this->cckconfig->get('addFieldPath',false))
		{
			$fieldspath = JPATH_ROOT . '/' . $this->cckconfig->get('FieldPath', 'plugins/system/kickcck/fields');
			JFormHelper::addFieldPath($fieldspath);
		}

		if($this->cckconfig->get('language',false))
		{
			$language = JFactory::getLanguage();
			$language->load($this->cckconfig->get('language'), JPATH_ROOT . '/' . $this->cckconfig->get('languagepath'));
		}
	}

	/**
	 * Event method that runs on content preparation
	 *
	 * @param   JForm    $form  The form object
	 * @param   integer  $data  The form data
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

		$jsonname = str_replace('.','_',$name);

		if (in_array($name, $this->forms))
		{
			if (empty($data))
			{
				$input = JFactory::getApplication()->input;
				$data = (object)$input->post->get('jform', array(), 'array');
			}
			// Fix wrong data in onContentPrepareForm() (see Programming Joomla! Plugins (Jisse Reitsma) page 92)
			if (is_array($data))
			{
				$data = JArrayHelper::toObject($data);
			}

			if(!$formconfig = $this->cckconfig->get($jsonname, false))
			{
				return true;
			}

			if(isset($formconfig->FormPath) and $formPath = $formconfig->FormPath)
			{
				JForm::addFormPath(JPATH_ROOT . '/' . $formPath);

				$form = $this->generateCCKForm($form, $formconfig);

				$data = $this->getCCK($data, $name, $this->app);

				$cck= $data->cck;
				$cckconfig = (isset($formconfig->$cck)) ? $formconfig->$cck : false;

				//ADD Custom JLayout Path and set to null onAfterDispatch
				if(isset($formconfig->LayoutPath) and $layoutPath = $formconfig->LayoutPath)
				{
					JLayoutHelper::$defaultBasePath = JPATH_ROOT . '/' . $layoutPath . '/' . $data->cck;
				}

				if (!$cckconfig) return true;

				if($cckconfig->cck_content and !empty($data->id))
					$data = $this->loadCCKContent($data, $formconfig);

				// Load CCKIMAGES
				if(isset($cckconfig->cckimages) and $cckimageconfig = $cckconfig->cckimages->fields)
				{
					$xml = $this->generateCCKImageForm($cckimageconfig);

					$form->load($xml,false);

					if(!empty($data->id))
						$data = $this->loadCCKImageContent($data, $cckconfig->cckimages);
				}

				//Load XML File
				$form->loadFile($cck, false);
			}

			if(isset($formconfig->CCKMenu) and $cckmenu = $formconfig->CCKMenu)
				$this->checkCCKMenu($cckmenu);

			return true;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Smart Search before save content method.
	 * Content is passed by reference. Method is called before the content is saved.
	 *
	 * @param   string  $context  The context of the content passed to the plugin (added in 1.6).
	 * @param   object  $data  A JTableContent object.
	 * @param   bool    $isNew    If the content is just about to be created.
	 *
	 * @return  void
	 *
	 * @since   2.5
	 */
	public function onContentBeforeSave($context, $data, $isNew)
	{
		if (in_array($context, $this->forms))
		{
			$jsonname = str_replace('.','_',$context);

			//Haben wir ein Configuration für das Form
			if(!$formconfig = $this->cckconfig->get($jsonname, false))
			{
				return true;
			}

			$form = $this->app->input->get('jform',false,'ARRAY');
			$cck = $form['cck'];

			$cckconfig = (isset($formconfig->$cck)) ? $formconfig->$cck : false;

			if (!$cckconfig) return true;

			//CCK Data
			if(is_array($form))
			{
				//check for article_layout
				$article_layout = $form['attribs']['article_layout'];
				$attribs = json_decode($data->attribs);

				if(!$article_layout){

					if(isset($cckconfig->article_layout))
						$attribs->article_layout = $cckconfig->article_layout;

					$data->attribs = json_encode($attribs);
				}
			}

			//CCK Images
			$images = $this->app->input->files->get('jform');
			if(is_array($images))
			{
				if(isset($cckconfig->cckimages) and $cckimageconfig = $cckconfig->cckimages->fields)
				{
					$xml = $this->generateCCKImageForm($cckimageconfig);
					$form = JForm::getInstance('test', $xml, $options = array(), $replace = true, $xpath = false);
				}

				foreach($images as $key => $image)
				{
					$field = $form->getField($key);

					if($field->getAttribute('type') == 'cckimage' and $image['error'] == 0)
					{
						if (!$this->canUpload($image, '', $this->params))
						{
							return false;
						};
					}
					else {
						continue;
					}
				}
			}
		}

		return true;
	}

	/**
	 * Event method that is run after an item is saved
	 *
	 * @param   string   $context  The context of the content
	 * @param   object   $item     A JTableContent object
	 * @param   boolean  $isNew    If the content is just about to be created
	 *
	 * @return	boolean  Return value
	 */
	public function onContentAfterSave($context, $item, $isNew)
	{
		if (in_array($context, $this->forms))
		{
			$jsonname = str_replace('.','_',$context);

			//Haben wir ein Configuration für das Form
			if(!$formconfig = $this->cckconfig->get($jsonname, false))
			{
				return true;
			}

			$form = $this->app->input->get('jform',false,'ARRAY');

			$cck= $form['cck'];
			$cckconfig = (isset($formconfig->$cck)) ? $formconfig->$cck : false;

			if (!$cckconfig) return true;

			$content_id = $item->id;
			$this->saveCCK($content_id, $context, $form);

			//CCK Daten
			if (is_array($form))
			{
				if($cckconfig->cck_content)
				{
					$this->saveCCKContent($content_id, $context, $form, $formconfig);
				}
			}

			//CCK Images
			$images = $this->app->input->files->get('jform');
			if(is_array($images))
			{
				if(isset($cckconfig->cckimages) and $cckimageconfig = $cckconfig->cckimages->fields)
				{
					$xml = $this->generateCCKImageForm($cckimageconfig);
					$form = JForm::getInstance('test', $xml, $options = array(), $replace = true, $xpath = false);
				}

				$olddata = 	$this->loadCCKImageContent($item, $cckconfig->cckimages);


				foreach($images as $key => $image)
				{
					$field = $form->getField($key);

					if($field->getAttribute('type') == 'cckimage' and $image['error'] == 0)
					{
						$olddata = $this->uploadImage($key. '_' .$content_id, $image, $field, $olddata, $this->params);
					}
					else {
						continue;
					}
				}

				if($olddata->cckimages !== null)
				{
					$this->saveCCKImageContent($content_id, $context, $olddata->cckimages);
				}
			}

		}
		return true;
	}

	/**
	 * Event method run after content is deleted
	 *
	 * @param   string  $context  The context for the content passed to the plugin.
	 * @param   object  $item     A JTableContent object
	 *
	 * @return null
	 */
	public function onContentAfterDelete($context, $item)
	{
		$this->deleteCCKItem($item->id,$context);
		$this->deleteCCKContent($item->id,$context);

		//TODO-Niels IMAGES LÖSCHEN
	}

	/**
	 * Event method run before content is displayed
	 *
	 * @param   string  $context  The context for the content passed to the plugin.
	 * @param   object  &$item    The content to be displayed
	 * @param   mixed   &$params  The article params
	 * @param   int     $page     Current page
	 *
	 * @return	null
	 */
	public function onContentBeforeDisplay($context, &$item, &$params, $page = 0)
	{
		//Get Data in content Category view
		switch($context)
		{
			case "com_content.category":
				$context = "com_content.article";
				break;
		}

		if (!empty($item->id))
		{
			$jsonname = str_replace('.','_',$context);

			if(!$formconfig = $this->cckconfig->get($jsonname, false))
			{
				return;
			}

			$item = $this->getCCK($item, $context, $this->app);

			$cck= $item->cck;
			$cckconfig = (isset($formconfig->$cck)) ? $formconfig->$cck : false;

			if (!$cckconfig) return;

			if($cckconfig->cck_content)
				$item = $this->loadCCKContent($item, $formconfig);

			// Load CCKIMAGES
			if(isset($cckconfig->cckimages) and $cckimageconfig = $cckconfig->cckimages->fields)
			{
				$item = $this->loadCCKImageContent($item, $cckconfig->cckimages);
			}

		}
	}

	public function onAfterDispatch()
	{
		JLayoutHelper::$defaultBasePath = "";
	}

	public function onAfterInitialise()
	{
		$app = JFactory::getApplication();
		$context = $app->input->get('context',false);
		if (in_array($context, $this->forms))
		{
			jimport('joomla.application.component.model');
			$id       = $app->input->get('id', false);
			$filename = $app->input->get('filename', false);

			$this->deleteCCKImage($id,$filename,$context);

			$app->close();
		}

	}

}
