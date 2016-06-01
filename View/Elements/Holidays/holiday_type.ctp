<?php
/**
 * 祝日タイプの備考
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php if ($holiday['HolidayRrule']['is_variable']) : ?>
	<?php
		$weekdays = HolidaysComponent::getWeekdaySelectList();
		$weekdayStr = Hash::get($weekdays, Hash::get($holiday, 'HolidayRrule.day_of_the_week'));

		$weeks = HolidaysComponent::getWeekSelectList();
		$weekStr = Hash::get($weeks, Hash::get($holiday, 'HolidayRrule.week'));

		echo $weekStr . ' ' . $weekdayStr;
	?>

<?php else : ?>
	<?php if ($holiday['HolidayRrule']['can_substitute']) : ?>
		<?php echo __d('holidays', 'In the case of Sunday, it will be with the next weekday transfer holiday'); ?>
	<?php endif; ?>
<?php endif;
