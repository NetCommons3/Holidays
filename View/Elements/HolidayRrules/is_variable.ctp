<?php
/**
 * holidays edit_form type template
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
		<?php echo __d('holidays', 'holiday specification type'); ?>
		<?php echo $this->element('NetCommons.required'); ?>
	</label>
	<div>
		<label class="radio-inline">
			<?php echo $this->NetCommonsForm->input('is_variable',
				array(
				'type' => 'radio',
				'div' => '',
				'label' => false,
				'class' => '',
				'options' => array(HolidaysAppController::HOLIDAYS_FIXED => ''),
				'ng-model' => 'holidayRrule.isVariable',
				'hiddenField' => false,
				));
			?>
			<?php echo __d('holidays', 'Date fixed'); ?>
		</label>
		<label class="radio-inline">
			<?php echo $this->NetCommonsForm->input('is_variable',
				array(
				'type' => 'radio',
				'div' => '',
				'label' => false,
				'class' => '',
				'options' => array(HolidaysAppController::HOLIDAYS_VARIABLE => ''),
				'ng-model' => 'holidayRrule.isVariable',
				'hiddenField' => false,
				));
			?>
			<?php echo __d('holidays', 'Specified week and day of the week'); ?>
		</label>
	</div>
</div>

<div class="form-group">
	<div class="form-inline holidays-sub-setting" ng-show="holidayRrule.isVariable==<?php echo HolidaysAppController::HOLIDAYS_FIXED; ?>">
		<div class="form-group">
			<?php echo $this->NetCommonsForm->input('input_month_day', array(
				'type' => 'date',
				'div' => '',
				'label' => __d('holidays', 'month and day'),
				'class' => 'form-control',
				'dateFormat' => 'MD',
				'monthNames' => false,
				'separator' => '/',
				'required' => true,

			));
			?>
		</div>
		<div class="form-group holidays-sub-setting">
			<label class="checkbox-inline">
				<?php echo $this->NetCommonsForm->input('can_substitute', array(
					'type' => 'checkbox',
					'value' => true,
					'div' => '',
					'label' => false,
					'class' => '',
				));?>
				<?php echo __d('holidays', 'In the case of Sunday , it will be with the next weekday transfer holiday'); ?>
			</label>
		</div>
	</div>

	<div class="form-inline holidays-sub-setting" ng-show="holidayRrule.isVariable==<?php echo HolidaysAppController::HOLIDAYS_VARIABLE; ?>">
		<div class="form-group">
			<?php echo $this->NetCommonsForm->input('input_month_day', array(
					'type' => 'date',
					'label' => __d('holidays', 'Month , week, day of the week'),
					'dateFormat' => 'M',
					'monthNames' => false,
					'separator' => '/',
					'required' => true,
					'error' => false,
					'ng-disabled' => 'holidayRrule.isVariable==' . HolidaysAppController::HOLIDAYS_FIXED
				));
			?>
		</div>
		<div class="form-group holidays-sub-setting">
			<?php echo $this->NetCommonsForm->input('week', array(
					'type' => 'select',
					'label' => false,
					'options' => HolidaysComponent::getWeekSelectList(),
				));
			?>
			<?php echo $this->NetCommonsForm->input('day_of_the_week', array(
					'type' => 'select',
					'label' => false,
					'options' => HolidaysComponent::getWeekdaySelectList(),
				));
			?>
		</div>
	</div>
</div>