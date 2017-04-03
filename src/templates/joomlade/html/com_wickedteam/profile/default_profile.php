<?php
/**
 * @package    Wicked.Team
 *
 * @author     Benjamin Trenkle <benjamin.trenkle@wicked-software.de>
 * @copyright  Copyright (C) 2016 Wicked Software Benjamin Trenkle. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Joomla\String\StringHelper;

$showtab = count($this->profiletabs) > 1;

foreach ($this->profiletabs as $profiletab) :

	if ($showtab) :
		echo JHtml::_('bootstrap.addTab', 'profile-tabs', 'cat-' . $this->escape($profiletab->alias), $this->escape($profiletab->title));
	endif;

		echo '<div class="container-fluid">';

		$toprow = (int) isset($profiletab->children['position-1']) + (int) isset($profiletab->children['position-2']);

		if ($toprow > 0) :

			$spanwidth = 12 / $toprow;

			echo '<div class="row">';

			if (isset($profiletab->children['position-1']) && is_array($profiletab->children['position-1'])) :
				echo '<div class="col-md-8 wicked-team-position-1">';
				foreach ($profiletab->children['position-1'] as $fieldset) :
					if (!isset($this->fields[$fieldset->id]) || !is_array($this->fields[$fieldset->id])) :
						continue;
					endif;

					for ($i = 0; $i <= $fieldset->maxinstance; ++$i) :

						echo '<div class="wt-' . $this->escape($fieldset->alias) . '">';
						echo '<h3>' . $this->escape($fieldset->title) . '</h3>';

						foreach ($this->fields[$fieldset->id] as $field) :

							$values = array();
							$skip = true;

							if (isset($this->values[$field->id][$i]) && count($this->values[$field->id][$i])) :
								foreach ($this->values[$field->id][$i] as $value) :
									$value = call_user_func(array($field->className, 'prepareBeforeOutput'), $value->value, $field, $this->item);

									if (StringHelper::strlen($value)) :
										$values[] = $value;
										$skip = false;
									endif;
								endforeach;
							else :
								$value = call_user_func(array($field->className, 'prepareBeforeOutput'), '', $field, $this->item);

								if (StringHelper::strlen($value)) :
									$values[] = $value;
									$skip = false;
								endif;
							endif;

							if ($skip) :
								continue;
							endif;

							foreach ($values as $value) :
								echo '<p>';
									echo $value;
								echo '</p>';
							endforeach;

						endforeach;
						echo '</div>';
					endfor;
				endforeach;
				echo '</div>';
			endif;

			if (isset($profiletab->children['position-2']) && is_array($profiletab->children['position-2'])) :
				echo '<div class="col-md-4 wicked-team-position-2">';
				foreach ($profiletab->children['position-2'] as $fieldset) :
					if (!isset($this->fields[$fieldset->id]) || !is_array($this->fields[$fieldset->id])) :
						continue;
					endif;

					for ($i = 0; $i <= $fieldset->maxinstance; ++$i) :

						echo '<div class="wt-' . $this->escape($fieldset->alias) . '">';

						foreach ($this->fields[$fieldset->id] as $field) :

							if (isset($this->values[$field->id][$i]) && count($this->values[$field->id][$i])) :
								foreach ($this->values[$field->id][$i] as $value) :
									echo '<p>';
										echo call_user_func(array($field->className, 'prepareBeforeOutput'), $value->value, $field, $this->item);
									echo '</p>';
								endforeach;
							else :
								echo '<p>';
									echo call_user_func(array($field->className, 'prepareBeforeOutput'), '', $field, $this->item);
								echo '</p>';
							endif;
						endforeach;
						echo '</div>';
					endfor;
				endforeach;
				if (isset($profiletab->children['position-3']) && is_array($profiletab->children['position-3'])) :
					foreach ($profiletab->children['position-3'] as $fieldset) :
						if (!isset($this->fields[$fieldset->id]) || !is_array($this->fields[$fieldset->id])) :
							continue;
						endif;
						for ($i = 0; $i <= $fieldset->maxinstance; ++$i) :
							echo '<div class="wt-' . $this->escape($fieldset->alias) . '">';
							echo '<h3>' . $this->escape($fieldset->title) . '</h3>';
							echo '<ul class="list-unstyled">';

							foreach ($this->fields[$fieldset->id] as $field) :

								if (!$field->hideLabel) :
									echo '<li><strong>';
										echo $this->escape($field->title);
									echo ': </strong>';
								else :
									echo '<li>';
								endif;
								if (isset($this->values[$field->id][$i]) && count($this->values[$field->id][$i])) :
									foreach ($this->values[$field->id][$i] as $value) :
											echo call_user_func(array($field->className, 'prepareBeforeOutput'), $value->value, $field, $this->item);
										echo '</li>';
									endforeach;
								else :
										echo call_user_func(array($field->className, 'prepareBeforeOutput'), '', $field, $this->item);
									echo '</li>';
								endif;
							endforeach;
							echo '</ul>';
							echo '</div>';
						endfor;
					endforeach;
				endif;

				echo '</div>';
			endif;
			echo '</div>';
		endif;

		$middlerow = (int) isset($profiletab->children['position-4']) + (int) isset($profiletab->children['position-5']);

		if ($middlerow > 0) :

			$spanwidth = 12 / $middlerow;

			echo '<div class="row">';

			if (isset($profiletab->children['position-4']) && is_array($profiletab->children['position-4'])) :
				echo '<div class="col-md-' . $spanwidth . ' wicked-team-position-4">';
				foreach ($profiletab->children['position-4'] as $fieldset) :
					if (!isset($this->fields[$fieldset->id]) || !is_array($this->fields[$fieldset->id])) :
						continue;
					endif;

					for ($i = 0; $i <= $fieldset->maxinstance; ++$i) :

						echo '<div class="wt-' . $this->escape($fieldset->alias) . '">';
						echo '<h3>' . $this->escape($fieldset->title) . '</h3>';
						echo '<ul class="list-unstyled">';

						foreach ($this->fields[$fieldset->id] as $field) :

							if (!$field->hideLabel) :
								echo '<li><strong>';
									echo $this->escape($field->title);
								echo ': </strong>';
							else :
								echo '<li>';
							endif;
							if (isset($this->values[$field->id][$i]) && count($this->values[$field->id][$i])) :
								foreach ($this->values[$field->id][$i] as $value) :
										echo call_user_func(array($field->className, 'prepareBeforeOutput'), $value->value, $field, $this->item);
									echo '</li>';
								endforeach;
							else :
									echo call_user_func(array($field->className, 'prepareBeforeOutput'), '', $field, $this->item);
								echo '</li>';
							endif;
						endforeach;
						echo '</ul>';
						echo '</div>';
					endfor;
				endforeach;
				echo '</div>';
			endif;

			if (isset($profiletab->children['position-5']) && is_array($profiletab->children['position-5'])) :
				echo '<div class="col-md-' . $spanwidth . ' wicked-team-position-5">';
				foreach ($profiletab->children['position-5'] as $fieldset) :
					if (!isset($this->fields[$fieldset->id]) || !is_array($this->fields[$fieldset->id])) :
						continue;
					endif;

					for ($i = 0; $i <= $fieldset->maxinstance; ++$i) :

						echo '<div class="wt-' . $this->escape($fieldset->alias) . '">';
						echo '<h3>' . $this->escape($fieldset->title) . '</h3>';
						echo '<ul class="list-unstyled">';

						foreach ($this->fields[$fieldset->id] as $field) :

							if (!$field->hideLabel) :
								echo '<li><strong>';
									echo $this->escape($field->title);
								echo ': </strong>';
							else :
								echo '<li>';
							endif;
							if (isset($this->values[$field->id][$i]) && count($this->values[$field->id][$i])) :
								foreach ($this->values[$field->id][$i] as $value) :
										echo call_user_func(array($field->className, 'prepareBeforeOutput'), $value->value, $field, $this->item);
									echo '</li>';
								endforeach;
							else :
									echo call_user_func(array($field->className, 'prepareBeforeOutput'), '', $field, $this->item);
								echo '</li>';
							endif;
						endforeach;
						echo '</ul>';
						echo '</div>';
					endfor;
				endforeach;
				echo '</div>';
			endif;

			echo '</div>';
		endif;

		if (isset($profiletab->children['position-6'])) :
			echo '<div class="row">';
			echo '<div class="col-md-12 wicked-team-position-6">';

			foreach ($profiletab->children['position-6'] as $fieldset) :
				if (!isset($this->fields[$fieldset->id]) || !is_array($this->fields[$fieldset->id])) :
					continue;
				endif;

				for ($i = 0; $i <= $fieldset->maxinstance; ++$i) :
					echo '<div class="wt-' . $this->escape($fieldset->alias) . '">';
					echo '<h3>' . $this->escape($fieldset->title) . '</h3>';
					foreach ($this->fields[$fieldset->id] as $field) :

						if (isset($this->values[$field->id][$i]) && count($this->values[$field->id][$i])) :
							foreach ($this->values[$field->id][$i] as $value) :
									echo call_user_func(array($field->className, 'prepareBeforeOutput'), $value->value, $field, $this->item);
							endforeach;
						else :
								echo call_user_func(array($field->className, 'prepareBeforeOutput'), '', $field, $this->item);
						endif;
					endforeach;
					echo '</div>';
				endfor;
			endforeach;
			echo '</div>';
		endif;

	echo '</div>';

	if ($showtab) :
		echo JHtml::_('bootstrap.endTab');
	endif;

endforeach;

?>
