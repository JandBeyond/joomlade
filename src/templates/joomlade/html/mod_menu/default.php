<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$mega = false;
$megatitle = false;
// Note. It is important to remove spaces between elements.
?>
<?php // The menu class is deprecated. Use nav instead. ?>
<ul class="level_1 <?php echo $class_sfx;?>"<?php
$tag = '';

if ($params->get('tag_id') != null)
{
	$tag = $params->get('tag_id') . '';
	echo ' id="' . $tag . '"';
}
?>>
<?php
foreach ($list as $i => &$item)
{

	//Codestyle
	$spacer = '    ';
	for ($i = 1; $i < $item->level; $i++)
	{
		$spacer .= '    ';
	}
	if ($item->level > 1)
	{
		$spacer .= '    ';
	}

	//$class = 'item-' . $item->id;
	$class = '';
	$ulclass = '';

	if (($item->id == $active_id) OR ($item->type == 'alias' AND $item->params->get('aliasoptions') == $active_id))
	{
		$class .= ' current';
	}

	if (in_array($item->id, $path))
	{
		$class .= ' active';
	}
	elseif ($item->type == 'alias')
	{
		$aliasToId = $item->params->get('aliasoptions');

		if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
		{
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path))
		{
			$class .= ' alias-parent-active';
		}
	}

	if ($item->type == 'separator')
	{
		$class .= ' divider';
	}

	if ($item->deeper)
	{
		$class .= ' dropdown';
		$item->anchor_css = 'dropdown-toggle' . $item->anchor_css;
	}

	if ($item->params->get('li_class', ''))
	{
		$class .= ' ' . $item->params->get('li_class', '');
	}

	if ($item->params->get('sr_only', 0))
	{
		$class .= ' sr-only';
	}
	if ($item->params->get('megamenu', 0))
	{
		$class .= ' mega-menu narrow';
		$mega = true;
	}

	if ($item->params->get('to_left', 0))
	{
		$ulclass .= ' to-left';
	}

	if ($item->params->get('scrollto', 0))
	{
		$item->anchor_css = 'scrollto' . $item->anchor_css;
	}

	if (!empty($class))
	{
		$class = ' class="' . trim($class) . '"';
	}
	if (!$item->params->get('megamenu', 0) && $item->params->get('megaclass', false) && $mega)
	{
		echo "\n" . $spacer . '    </ul></div><div class="'. $item->params->get('megaclass', 'col-md-6'). '"><div class="divider"></div><ul class="menu">' . "\n";
	}
	echo $spacer . '<li' . $class . '>';

	//MODUL LOAD HACK
	if($item->params->get('loadmodule', 0))
	{
		$item->type = 'modules';
	}
	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
		case 'heading':
		case 'modules':
			require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
			break;
	endswitch;



	// The next item is deeper.
	if ($item->deeper)
	{
		echo "\n" . $spacer . '    <ul class="level_' . ($item->level + 1) . ' dropdown-menu ' . $ulclass . '">' . "\n";
		if ($item->params->get('megamenu', 0))
		{
			echo "\n" . $spacer . '    <li>' . "\n";
			if ($item->params->get('megatitle', ''))
			{
				if($icontype = $item->params->get('megatitleicon', ''))
				{
					$icon = '<i class="' . $icontype . ' pr-10"></i>';
				}
				else $icon = '';
				echo "\n" . $spacer . '    <div class="row"><div class="col-md-12"><h4 class="title">' . $icon . ' ' . $item->params->get('megatitle', '') . '</h4>' . "\n";
				$megatitle = true;
			}
			echo "\n" . $spacer . '    <div class="row"><div class="'. $item->params->get('megaclass', 'col-md-6'). '"><div class="divider"></div><ul class="menu">' . "\n";
		}
	}
	elseif ($item->shallower)
	{
		if($mega)
		{
			$mega = false;
			echo '</ul></div></div>' . "\n";
			if($megatitle)
			{
				$mega = false;
				echo '</div></div>' . "\n";
			}
			echo '</li>' . "\n";
		}
		// The next item is shallower.
		echo str_repeat(substr($spacer, 0, -4) . '</ul><!-- ul.level_' . ($item->level) . ' -->' . "\n" . substr($spacer, 0, -8) . '</li><!-- li.deeper -->' . "\n", $item->level_diff);

	}
	else
	{
		// The next item is on the same level.
		echo '</li>' . "\n";
	}
}
?>
</ul><!-- end .nav.menu -->