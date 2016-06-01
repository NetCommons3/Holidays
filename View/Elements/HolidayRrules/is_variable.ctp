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
$months = array(
	1 => __d('holidays', 'January'),
	2 => __d('holidays', 'February'),
	3 => __d('holidays', 'March'),
	4 => __d('holidays', 'April'),
	5 => __d('holidays', 'May'),
	6 => __d('holidays', 'June'),
	7 => __d('holidays', 'July'),
	8 => __d('holidays', 'August'),
	9 => __d('holidays', 'September'),
	10 => __d('holidays', 'October'),
	11 => __d('holidays', 'November'),
	12 => __d('holidays', 'December'),
);
for ($i = 1; $i <= 31; $i++) {
	$days[$i] = $i . __d('holidays', 'day');
}
?>

<div class="form-group">
	<?php echo $this->NetCommonsForm->label('is_variable', __d('holidays', 'holiday specification type')); ?>

	<div class="form-radio-outer">
		<?php
			echo $this->NetCommonsForm->radio('is_variable',
				array(HolidaysAppController::HOLIDAYS_FIXED => __d('holidays', 'Date fixed')),
				array(
					'ng-model' => 'holidayRrule.isVariable',
				)
			);
		?>
		<div class="row form-group"
				ng-show="holidayRrule.isVariable == <?php echo HolidaysAppController::HOLIDAYS_FIXED ?>">
			<div class="col-xs-11 col-xs-offset-1 form-inline">
				<?php
					echo $this->NetCommonsForm->month('input_month_day', array(
						'div' => false,
						'label' => __d('holidays', 'month and day'),
						'class' => 'form-control',
						'monthNames' => $months,
						'required' => true,
						'empty' => false,
						'ng-disabled' => 'holidayRrule.isVariable != ' . HolidaysAppController::HOLIDAYS_FIXED,
						'ng-show' => 'holidayRrule.isVariable == ' . HolidaysAppController::HOLIDAYS_FIXED,
					));
				?>

				<?php
					echo $this->NetCommonsForm->select('input_month_day.day', $days, array(
						'div' => false,
						'label' => false,
						'class' => 'form-control',
						'required' => true,
						'empty' => false,
						'ng-show' => 'holidayRrule.isVariable == ' . HolidaysAppController::HOLIDAYS_FIXED,
					));
				?>

				<div class="checkbox holidays-sub-setting"
						ng-show="holidayRrule.isVariable == <?php echo HolidaysAppController::HOLIDAYS_FIXED ?>">
					<?php
						echo $this->NetCommonsForm->checkbox('HolidayRrule.can_substitute', array(
							'type' => 'checkbox',
							'value' => true,
							'label' => __d('holidays', 'In the case of Sunday, it will be with the next weekday transfer holiday'),
							'div' => false,
						));
					?>
				</div>
			</div>
		</div>

		<?php
			echo $this->NetCommonsForm->radio('is_variable',
				array(HolidaysAppController::HOLIDAYS_VARIABLE => __d('holidays', 'Specified week and day of the week')),
				array(
					'ng-model' => 'holidayRrule.isVariable',
				)
			);
		?>

		<div class="row form-group"
				ng-show="holidayRrule.isVariable == <?php echo HolidaysAppController::HOLIDAYS_VARIABLE ?>">
			<div class="col-xs-11 col-xs-offset-1 form-inline">
				<?php
					echo $this->NetCommonsForm->month('input_month_day', array(
						'div' => false,
						'label' => __d('holidays', 'month and day'),
						'class' => 'form-control',
						'monthNames' => $months,
						'required' => true,
						'empty' => false,
						'ng-disabled' => 'holidayRrule.isVariable != ' . HolidaysAppController::HOLIDAYS_VARIABLE,
						'ng-show' => 'holidayRrule.isVariable == ' . HolidaysAppController::HOLIDAYS_VARIABLE,
					));
				?>

				<?php echo $this->NetCommonsForm->input('week', array(
						'type' => 'select',
						'label' => false,
						'class' => 'form-control holidays-sub-setting',
						'options' => HolidaysComponent::getWeekSelectList(),
						'ng-show' => 'holidayRrule.isVariable == ' . HolidaysAppController::HOLIDAYS_VARIABLE,
					));
				?>
				<?php echo $this->NetCommonsForm->input('day_of_the_week', array(
						'type' => 'select',
						'label' => false,
						'options' => HolidaysComponent::getWeekdaySelectList(),
						'ng-show' => 'holidayRrule.isVariable == ' . HolidaysAppController::HOLIDAYS_VARIABLE,
					));
				?>
			</div>
		</div>
	</div>
</div>
