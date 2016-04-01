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
for ($i = HolidaysAppController::HOLIDAYS_YEAR_MIN; $i <= HolidaysAppController::HOLIDAYS_YEAR_MAX; $i++) {
	$yearArray[$i] = $i;
}
?>
<div class="form-group">
	<?php echo $this->NetCommonsForm->select($fieldName, $yearArray,
	Hash::merge(
	array(
		'label' => false,
		'empty' => false,
		'class' => 'form-control',
		'value' => (empty($year)) ? '' : intval($year),
		'ng-model' => $ngModel,
		'error' => false,
	), $options));
	?>
</div>

