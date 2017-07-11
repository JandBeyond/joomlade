<?php
/**
 * @package    Wicked.Location
 *
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-chick.de>
 * @author     Christiane Maier-Stadtherr <christiane.maier-stadtherr@wicked-chick.de>
 * @copyright  Copyright (C) 2015 Wicked Software Benjamin Trenkle. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$nullDate	= JFactory::getDbo()->getNullDate();
$item		= $this->item;
$params		= $this->params;

if ( (int) $params->get('span_address_block') == 0) :
	$span_info = '12';
	$span_addr = '12"';
else :
	$span_addr = $this->params->get('span_address_block', '3');
	$span_info =  12 - $span_addr ;
endif;
?>

<address>
	<?php
	echo '<strong>'
	. $this->escape(trim($this->item->address) . ' ' . trim($this->item->addr_no))
	. '<br />'
	. $this->escape(trim($this->item->zip_code) . ' ' . trim($this->item->city))
	. '</strong><br />';

	if ($this->item->addr_addinfo && $this->params->get('show_country', '1')) :
		echo $this->escape(trim($this->item->region)) . '<br />' . $this->escape(trim($this->item->country) ). '<br />';
	endif;

	if ($this->item->addr_addinfo && $this->params->get('show_addr_addinfo', '1')) :
		echo $this->escape(trim($this->item->addr_addinfo)) . '<br>';
	endif;

	if (!empty($this->item->phone)) :
			echo '<br>' . JText::_('COM_WICKEDLOCATION_LOCATION_PHONE') . ': ';
			if ($span_addr < 6):
				echo '<br>';
			endif;
			echo $this->escape(trim($this->item->phone));
	endif;

	if (!empty($this->item->email)) :
		echo '<br>' . JText::_('COM_WICKEDLOCATION_LOCATION_EMAIL') . ': ';
		if ($span_addr < 6):
			echo '<br>';
		endif;
		if (JMailHelper::isEmailAddress($this->item->email)):
			echo JHtml::_('email.cloak', $this->item->email);
		else:
			echo $this->escape($this->item->email);
		endif;
	endif;

	if (!empty($this->item->url)) :
		if (strpos($this->item->url, 'http://')):
			$prefix = 'http://';
		elseif (strpos($this->item->url, 'https://')):
			$prefix = 'https://';
		else:
			$prefix = '';
		endif;
			echo '<br>' . JHtml::_('link', $prefix . $this->escape($this->item->url), JText::_('COM_WICKEDLOCATION_LOCATION_HOMEPAGE'), 'target="_blank"');
	endif; ?>
	<br><br>
</address>
