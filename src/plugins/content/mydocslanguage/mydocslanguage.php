<?php
/**
 * JoomlaDE MyDocsLanguage Plugin
 *
 * @copyright  Copyright (C) 2017 JandBeyond e.V. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt GNU General Public License Version 2 or Later
 */

defined('_JEXEC') or die;

/**
 * Plugin adding Special:MyLanguage to joomla docs page links.
 *
 * @since  1.0
 */
class PlgContentMyDocsLanguage extends JPlugin
{
	/**
	 * The snipped what should be extended
	 *
	 * @var    string
	 * @since  1.0
	 */
	private $baseTag = 'href="https://docs.joomla.org';

	/**
	 * The string that be added after the main page URL.
	 *
	 * @var    string
	 * @since  1.0
	 */
	private $tagToBeAdded = '/Special:MyLanguage';

	/**
	 * Listener for the `onContentBeforeSave` event
	 * Content is passed by reference. Method is called before the content is saved.
	 *
	 * @param   string  $context  The context of the content passed to the plugin.
	 * @param   object  $article  A JTableContent object.
	 * @param   bool    $isNew    If the content is just about to be created.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onContentBeforeSave($context, $article, $isNew)
	{
		// Does the current text include the docs tag? If not there is nothing todo
		if (strpos($article->fulltext, $this->baseTag) === false && strpos($article->introtext, $this->baseTag) === false)
		{
			return;
		}

		// Create the new link
		$newlink = $this->baseTag . $this->tagToBeAdded;

		// Replace the old value with the new
		$article->fulltext  = str_replace($this->baseTag, $newlink, $article->fulltext);
		$article->introtext = str_replace($this->baseTag, $newlink, $article->introtext);	

		$dublicatelink = $this->tagToBeAdded . $this->tagToBeAdded;

		// If we have two occurrence of the tag remove it.
		$article->fulltext  = str_replace($dublicatelink, $this->tagToBeAdded, $article->fulltext);
		$article->introtext = str_replace($dublicatelink, $this->tagToBeAdded, $article->introtext);
	}
}
