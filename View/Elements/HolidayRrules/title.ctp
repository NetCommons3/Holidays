<?php
/**
 * holidays edit_form title template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<div class="form-group">
	<?php
		foreach ($this->request->data['Holiday'] as $index => $holiday) {
			$languageId = $holiday['language_id'];
			if (! isset($languages[$languageId])) {
				continue;
			}

			echo $this->NetCommonsForm->hidden('Holiday.' . $index . '.id');
			echo $this->NetCommonsForm->hidden('Holiday.' . $index . '.key');
			echo $this->NetCommonsForm->hidden('Holiday.' . $index . '.language_id');

			echo '<div class="form-group" ng-show="activeLangId === \'' . (string)$languageId . '\'" ng-cloak>';
			echo $this->NetCommonsForm->input('Holiday.' . $index . '.' . 'title', array(
				'type' => 'text',
				'label' => $this->SwitchLanguage->inputLabel(__d('holidays', 'title'), $languageId),
				'error' => array(
					'ng-show' => 'activeLangId === \'' . (string)$languageId . '\'',
				),
				'required' => true,
			));
			echo '</div>';
		}
	?>
</div>