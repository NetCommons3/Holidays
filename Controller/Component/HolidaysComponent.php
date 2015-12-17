<?php
/**
 * Holidays Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * HolidaysComponent
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Questionnaires\Controller
 */
class HolidaysComponent extends Component {

/**
 * holiday nth week
 *
 * @var string
 */
	const HOLIDAY_1ST_WEEK = 1;
	const HOLIDAY_2ND_WEEK = 2;
	const HOLIDAY_3RD_WEEK = 3;
	const HOLIDAY_4TH_WEEK = 4;
	const HOLIDAY_LAST_WEEK = -1;


/**
 * holiday weekday
 */
	const HOLIDAY_WEEKDAY_SUNDAY = 'SU';
	const HOLIDAY_WEEKDAY_MONDAY = 'MO';
	const HOLIDAY_WEEKDAY_TUESDAY = 'TU';
	const HOLIDAY_WEEKDAY_WEDNESDAY = 'WE';
	const HOLIDAY_WEEKDAY_THURSDAY = 'TH';
	const HOLIDAY_WEEKDAY_FRIDAY = 'FR';
	const HOLIDAY_WEEKDAY_SATURDAY = 'SA';

/**
 * getWeekSelectList
 *
 * @return array
 */
	public static function getWeekSelectList() {
		return array(
			self::HOLIDAY_1ST_WEEK => __d('holidays', 'First week'),
			self::HOLIDAY_2ND_WEEK => __d('holidays', 'Second week'),
			self::HOLIDAY_3RD_WEEK => __d('holidays', 'Third week'),
			self::HOLIDAY_4TH_WEEK => __d('holidays', 'Fourth week'),
			self::HOLIDAY_LAST_WEEK => __d('holidays', 'Last week'),
		);
	}

/**
 * getWeekdaySelectList
 *
 * @return array
 */
	public static function getWeekdaySelectList() {
		return array(
			self::HOLIDAY_WEEKDAY_SUNDAY => __d('holidays', 'Sunday'),
			self::HOLIDAY_WEEKDAY_MONDAY => __d('holidays', 'Monday'),
			self::HOLIDAY_WEEKDAY_TUESDAY => __d('holidays', 'Tuesday'),
			self::HOLIDAY_WEEKDAY_WEDNESDAY => __d('holidays', 'Wednesday'),
			self::HOLIDAY_WEEKDAY_THURSDAY => __d('holidays', 'Thursday'),
			self::HOLIDAY_WEEKDAY_FRIDAY => __d('holidays', 'Friday'),
			self::HOLIDAY_WEEKDAY_SATURDAY => __d('holidays', 'Saturday'),
		);
	}

}
