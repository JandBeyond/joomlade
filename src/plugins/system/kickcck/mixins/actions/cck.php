<?php
/**
 * Joomla! System plugin - KickCCK
 *
 * @author     Niels Nuebel <niels@niels-nuebel.de>
 * @copyright  Copyright 2015 Niels Nuebel. All rights reserved
 * @license    GNU Public License
 * @link       http://www.niels-nuebel.de
 */

// Namespace
namespace CCK\Actions;

// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Class CCK
 *
 * @package CCK\Actions
 */
class CCK
{
	/**
	 * Task method to save the content value to the database
	 *
	 * @param   int     $content_id  Content ID in the #__kickcck_content table
	 * @param   string  $context     The context for the content passed to the plugin.
	 * @param   mixed   $contact_id  Contact/Author value
	 *
	 * @return	bool
	 */
	public function saveCCKContent($content_id, $context, $form, $config)
	{

		$cck= $form['cck'];
		$cckconfig = (isset($config->$cck)) ? $config->$cck : false;

		if (!$cckconfig) return true;

		if (!$cckconfig->cck_content)
		{
			$this->deleteCCKItem($content_id,$context);
			return true;
		}

		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('content_id'))
			->from($db->quoteName('#__kickcck_content'))
			->where($db->quoteName('content_id') . '=' . $content_id)
			->where($db->quoteName('context') . '=' . $db->quote($context));

		$db->setQuery($query);
		$db->execute();
		$exists = (bool) $db->getNumRows();

		$data = new \stdClass;
		$data->content_id = $content_id;
		$data->context = $context;

		$data = $this->DBMapping($data, $form, $cckconfig->mappings);

		if ($exists)
		{
			$result = $db->updateObject('#__kickcck_content', $data, 'content_id');
		}
		else
		{
			$result = $db->insertObject('#__kickcck_content', $data);
		}
		return $result;
	}

	public function loadCCKContent($data, $config)
	{
		$cck= $data->cck;
		$cckconfig = (isset($config->$cck)) ? $config->$cck : false;

		if (!$cckconfig) return $data;

		if (empty($data->id) or !$cckconfig->cck_content)
		{
			return $data;
		}

		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($cckconfig->select)
			->from($db->quoteName('#__kickcck_content') . ' AS co')
			->join('LEFT', $db->quoteName($cckconfig->join) . ' AS content ON content.id = co.content_id')
			->where($db->quoteName('co.content_id') . '=' . $data->id)
			->where($db->quoteName('co.context') . '=' . $db->quote($cckconfig->contextwhere));
		;
		$db->setQuery($query);
		$cckdata = $db->loadAssoc();

		$data = $this->DBMapping($data,$cckdata, $cckconfig->mappings);

		return $data;
	}

	protected function DBMapping ($data, $cckdata, $mappings = array())
	{
		if(!count($mappings))
			return $data;

		foreach($mappings as $mapping)
		{
			$data->$mapping = $cckdata[$mapping];
		}

		return $data;
	}

	/**
	 * Task method to save the content and cck value to the database
	 *
	 * @param   int     $content_id  Content ID in the #__kickcck_content table
	 * @param   string  $context     The context for the content passed to the plugin.
	 * @param   mixed   $form  Content value
	 *
	 * @return	bool
	 */
	public function saveCCK($id, $context, $form)
	{
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName('cck'))
			->from($db->quoteName('#__kickcck_cck'))
			->where($db->quoteName('context') . '=' . $db->quote($context))
			->where($db->quoteName('id') . '=' . $id);
		$db->setQuery($query);
		$db->execute();
		$exists = (bool) $db->getNumRows();

		$data = new \stdClass;
		$data->id = $id;
		$data->context = $context;

		$data->cck = $form['cck'];

		if ($exists)
		{
			$result = $db->updateObject('#__kickcck_cck', $data, array('id','context'));
		}
		else
		{
			$result = $db->insertObject('#__kickcck_cck', $data);
		}
		return $result;
	}

	/**
	 * Task method to load the cck value from the database
	 *
	 * @param   object  $item  The content that is being loaded
	 * @param   object  $formname  The formularname that is being loaded
	 *
	 * @return mixed
	 */
	public function getCCK($data, $formname, $app)
	{
		if (!empty($data->id))
		{
			$db = \JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('cck')
				->from($db->quoteName('#__kickcck_cck'))
				->where($db->quoteName('context') . '=' . $db->quote($formname))
				->where($db->quoteName('id') . '=' . $data->id);
			$db->setQuery($query);

			$cck = $db->loadResult();

			if($cck == null ) $cck = 'none';

			$data->cck = $cck;
		}
		else
		{
			$cck = $app->input->get('cck','none');
			$data->cck = $cck;
		}

		return $data;
	}

	public function generateCCKForm ($form, $config)
	{
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		$xml .= '<form>';
		$xml .= '<fields>';
		$xml .= '<fieldset name="jmetadata">';

		if($config->change_cck)
		{
			$xml .= '<field name="' . $config->field_name . '" type="list" label="' . $config->field_label . '" description="' . $config->field_desc . '" class="chzn-color-state" size="1" default="' . $config->field_default . '">';
			foreach ($config->options as $option)
			{
				$xml .= '<option value="' . $option->value . '">' . $option->text . '</option>';
			}
			$xml .= '</field>';

		}
		else {
			$xml .= '<field name="cck" type="hidden" filter="unset" />';
		}

		$xml .= '</fieldset>';
		$xml .= '</fields>';
		$xml .= '</form>';

		$form->load($xml,false);

		return $form;
	}

	public function deleteCCKItem($id,$context)
	{
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true)
			->delete($db->quoteName('#__kickcck_cck'))
			->where($db->quoteName('context') . '=' . $db->quote($context))
			->where($db->quoteName('id') . '=' . $id);
		$db->setQuery($query);
		$db->execute();
	}

	public function deleteCCKContent($id,$context)
	{
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true)
			->delete($db->quoteName('#__kickcck_content'))
			->where($db->quoteName('context') . '=' . $db->quote($context))
			->where($db->quoteName('content_id') . '=' . $id);
		$db->setQuery($query);
		$db->execute();
	}
}
