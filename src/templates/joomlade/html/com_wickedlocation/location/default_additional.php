<?php
/**
 * @package    Wicked.Location
 *
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-chick.de>
 * @copyright  Copyright (C) 2015 Wicked Software Benjamin Trenkle. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

if (!empty($this->item->type) && !empty($this->item->additional)):

	try {
		$additional = $this->loadTemplate($this->escape($this->item->type));

		echo '<div id="wickedlocation-addtype-' . $this->escape($this->item->type) . '">';
			echo $additional;
		echo '</div>';
	} catch (Exception $ex) {

	}

endif;
