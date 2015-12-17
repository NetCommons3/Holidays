<?php
/**
 * holidays year select template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<div class="form-inline">
	<label><?php echo __d('holidays', 'Year'); ?></label>
    <?php echo $this->element('Holidays.Holidays/year_picker', array(
		'fieldName' => 'targetYear',
		'year' => $targetYear,
		'ngModel' => 'targetYear',
		'options' => array('ng-change' => 'changeTargetYear'))); ?>
 </div>