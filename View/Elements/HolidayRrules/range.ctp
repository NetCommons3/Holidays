<?php
/**
 * holidays edit_form range template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<div class="form-group">
	<label>
		<?php echo __d('holidays', 'Specified target range'); ?>
	</label>

	<div class="form-inline">
		<?php echo $this->element('Holidays.Holidays/year_picker', array(
			'fieldName' => 'start',
			'year' => $this->request->data['HolidayRrule']['from'],
			'ngModel' => 'holidayRrule.from',
			'options' => array('ng-change' => 'changeTargetYear'))); ?>

		<?php echo __d('holidays', '-'); ?>

		<?php echo $this->element('Holidays.Holidays/year_picker', array(
			'fieldName' => 'end',
			'year' => $this->request->data['HolidayRrule']['to'],
			'ngModel' => 'holidayRrule.to',
		)); ?>
	</div>
</div>
