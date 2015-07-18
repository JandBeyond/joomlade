<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Provides an input field for files
 *
 * @link   http://www.w3.org/TR/html-markup/input.file.html#input.file
 * @since  11.1
 */
class JFormFieldCCKImage extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'CCKImage';

	/**
	 * The accepted file type list.
	 *
	 * @var    mixed
	 * @since  3.2
	 */
	protected $accept;

	/**
	 * Method to instantiate the form field object.
	 *
	 * @param   JForm  $form  The form to attach to the form field object.
	 *
	 * @since   11.1
	 */
	public function __construct($form = null)
	{
		parent::__construct($form);

		$doc = JFactory::getDocument();

		$stylsheet = JUri::root() . '/media/plg_system_kickcck/css/cropper.min.css';
		$doc->addStyleSheet($stylsheet);
		$javascript = JUri::root() . '/media/plg_system_kickcck/js/cropper.min.js';
		$doc->addScript($javascript);

	}

	/**
	 * Method to get certain otherwise inaccessible properties from the form field object.
	 *
	 * @param   string  $name  The property name for which to the the value.
	 *
	 * @return  mixed  The property value or null.
	 *
	 * @since   3.2
	 */
	public function __get($name)
	{
		switch ($name)
		{
			case 'accept':
				return $this->$name;
		}

		return parent::__get($name);
	}

	/**
	 * Method to set certain otherwise inaccessible properties of the form field object.
	 *
	 * @param   string  $name   The property name for which to the the value.
	 * @param   mixed   $value  The value of the property.
	 *
	 * @return  void
	 *
	 * @since   3.2
	 */
	public function __set($name, $value)
	{
		switch ($name)
		{
			case 'accept':
				$this->$accept = (string) $value;
				break;

			default:
				parent::__set($name, $value);
		}
	}

	/**
	 * Method to attach a JForm object to the field.
	 *
	 * @param   SimpleXMLElement  $element  The SimpleXMLElement object representing the <field /> tag for the form field object.
	 * @param   mixed             $value    The form field value to validate.
	 * @param   string            $group    The field name group control value. This acts as as an array container for the field.
	 *                                      For example if the field has name="foo" and the group value is set to "bar" then the
	 *                                      full field name would end up being "bar[foo]".
	 *
	 * @return  boolean  True on success.
	 *
	 * @see     JFormField::setup()
	 * @since   3.2
	 */
	public function setup(SimpleXMLElement $element, $value, $group = null)
	{
		$return = parent::setup($element, $value, $group);

		if ($return)
		{
			$this->accept = (string) $this->element['accept'];
		}

		return $return;
	}

	/**
	 * Method to get the field input markup for the file field.
	 * Field attributes allow specification of a maximum file size and a string
	 * of accepted file extensions.
	 *
	 * @return  string  The field input markup.
	 *
	 * @note    The field does not include an upload mechanism.
	 * @see     JFormFieldMedia
	 * @since   11.1
	 */
	protected function getInput()
	{
		// Initialize some field attributes.
		$accept    = !empty($this->accept) ? ' accept="' . $this->accept . '"' : '';
		$size      = !empty($this->size) ? ' size="' . $this->size . '"' : '';
		$class     = !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$disabled  = $this->disabled ? ' disabled' : '';
		$required  = $this->required ? ' required aria-required="true"' : '';
		$autofocus = $this->autofocus ? ' autofocus' : '';
		$multiple  = $this->multiple ? ' multiple' : '';

		// Initialize JavaScript field attributes.
		$onchange = $this->onchange ? ' onchange="' . $this->onchange . '"' : '';

		// Including fallback code for HTML5 non supported browsers.
		JHtml::_('jquery.framework');
		JHtml::_('script', 'system/html5fallback.js', false, true);

		$html = array();
		$html[] = '<input id="' . $this->id . '_nnimage_cropdata"" type="text" class="form-control" value="' . $this->value .'"">';
		$html[] = '<input id="' . $this->id . '_nnimage_src"" type="text" class="form-control">';

		$html[] = '<input type="file" name="' . $this->name . '" id="' . $this->id . '"' . $accept . $disabled . $class . $size . $onchange . $required . $autofocus . $multiple . ' />';
		$html[] = '<br>';
		$html[] = '<div class="img-container"><img src="' . JUri::root() . '/' .  $this->value . '" class="img-responsive nnimage" id="' . $this->id . 'nnimage"" /></div>';
		$html[] = '<script type="text/javascript">';
		$html[] = 'jQuery(function(){';
		$html[] = 'jQuery("#' . $this->id . 'nnimage").cropper({';
				$html[] = '
					minCanvasWidth: 320,
                    minCanvasHeight: 180,
                    minCropBoxWidth: 160,
                    minCropBoxHeight: 90,
                    minContainerWidth: 320,
                    minContainerHeight: 180,
                    aspectRatio: 16 / 9,
                    autoCropArea: 0.1,
                    strict:true,
                    responsive:false,
                    background:false,
                    guides:false,
                    rotatable:false,
                    crop: function(data) {
                    var json = [
                        \'{"x":\' + Math.round(data.x),
                        \'"y":\' + Math.round(data.y),
                        \'"height":\' + Math.round(data.height),
                        \'"width":\' + Math.round(data.width) + \'}\'
                    ].join();
                    jQuery("#' . $this->id . '_nnimage_cropdata").val(json);
                    }';
        $html[] = '});';
		$html[] = '});';
		$html[] = '</script>';


		return implode("\n", $html);


	}

	public function getAttributes()
	{
		if ($this->element instanceof SimpleXMLElement)
		{
			return $this->element->attributes();
		}
	}
}
