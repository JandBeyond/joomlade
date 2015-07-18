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
 * Class AddMenu
 *
 * @package CCK\Actions
 */
class AddMenu
{
	public function checkCCKMenu($cckmenu)
	{
		$user  = \JFactory::getUser();

		if($cckmenu->check) {
			if ((count($user->getAuthorisedCategories($cckmenu->AuthorisedCategories, 'core.create'))) > 0 )
			{
				$this->addCCKMenu($cckmenu->buttontext, $cckmenu->links);
			}
		}
		else
			$this->addCCKMenu($cckmenu->buttontext, $cckmenu->links);
	}

	protected function addCCKMenu($alt,$links)
	{
		$title = \JText::_($alt);

		$dhtml = '<div class="btn-group">
                <button class="btn dropdown-toggle btn-small" data-toggle="dropdown">' . $title . ' <span class="caret"></span></button>
                <ul class="dropdown-menu">';

		foreach($links as $link)
		{
			$dhtml .= '<li><a href="' .$link->link . '">'. \JText::_($link->linktext) .'</a></li>';
		}
		$dhtml .= '</ul></div>';
		$bar = \JToolbar::getInstance('toolbar');
		$bar->appendButton('Custom', $dhtml, $alt);
	}
}
