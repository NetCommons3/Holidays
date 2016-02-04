<?php
/**
 * holidays year picker template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->element('NetCommons.datetimepicker');
$pickerOpt = str_replace('"', "'", json_encode(array(
	'format' => 'YYYY',
	'minDate' => HolidaysAppController::HOLIDAYS_DATE_MIN,
	'maxDate' => HolidaysAppController::HOLIDAYS_DATE_MAX,
)));
?>

<div class="input-group">
	<?php echo $this->NetCommonsForm->input($fieldName,
	array(
		'div' => false,
		'label' => false,
		'type' => 'text',
		'datetimepicker' => 'datetimepicker',
		'datetimepicker-options' => $pickerOpt,
		'value' => (empty($year)) ? '' : intval($year),
		'ng-model' => $ngModel,
		'placeholder' => ($fieldName == 'start_year')? HolidaysAppController::HOLIDAYS_YEAR_MIN:HolidaysAppController::HOLIDAYS_YEAR_MAX,
		'error' => false,
		'ng-change' => 'changeTargetYear(intval($year))',
		//'ng-change' => $options['ng-change']
	));
	//print_r($fieldName);print_r($ngModel);print_r($year);
	?>
	<div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
</div>

