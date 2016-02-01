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
			'fieldName' => 'start_year',
			'year' => $this->request->data['HolidayRrule']['start_year'],
			'ngModel' => 'holidayRrule.startYear',
		)); ?>

		<?php echo __d('holidays', '-'); ?>

		<?php echo $this->element('Holidays.Holidays/year_picker', array(
			'fieldName' => 'end_year',
			'year' => $this->request->data['HolidayRrule']['end_year'],
			'ngModel' => 'holidayRrule.endYear',
		)); ?>
		<?php echo $this->NetCommonsForm->error('end_year'); ?>
	</div>
</div>
