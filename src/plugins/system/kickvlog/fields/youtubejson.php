<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');


class JFormFieldYoutubeJSON extends JFormField {

	protected $type = 'YoutubeJSON';

	public function getInput() {

		$doc = JFactory::getDocument();
		$js = array();

		$js[] = 'jQuery(function () {';
		$js[] = "jQuery('#youtubejson').click(function(){";
		$js[] = "jQuery.ajax({";
		$js[] = "type: 'POST',";
		$js[] = "url: '".JUri::root(false)."index.php?option=com_ajax&plugin=YoutubeJSON&format=raw',";
		$js[] = "data: {";
		$js[] = "youtube_id: encodeURIComponent(jQuery('#jform_attribs_youtube_id').val())";
		$js[] = "},";
		$js[] = "dataType: 'json',";
		$js[] = "success: function (data) {";
		$js[] = "jQuery('#jform_title,#jform_attribs_youtube_title').val(data.title);";
		$js[] = "jQuery('#jform_attribs_youtube_desc').val(data.description);";
		$js[] = "}";
		$js[] = "});";
		$js[] = "});";
		$js[] = '});';

		$js =  implode("\n",$js);
		$doc->addScriptDeclaration($js);

		$html = array();
		$html[] = '<input type="button" class="btn btn-success" value="'.JText::_('PLG_KICKVLOG_YOUTUBEJSON') .'" id="youtubejson">';

		return implode("\n",$html);
	}
}