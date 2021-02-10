<?php
/**
 * 令和３年の祝日の修正
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');
App::uses('CurrentLib', 'NetCommons.Lib');

/**
 * 令和３年の祝日の修正
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Holidays\Config\Migration
 * @see https://github.com/NetCommons3/NetCommons3/issues/1621
 */
class Update2021Holidays extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'update_2021_holidays';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
		),
	);

/**
 * HolidayRruleモデル
 *
 * @var HolidayRrule
 */
	private $__HolidayRrule;

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		$this->__HolidayRrule = ClassRegistry::init('Holidays.HolidayRrule');
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		if ($direction === 'up') {
			CurrentLib::write('Language.id', 2);
			//海の日の更新
			$this->__updateMarineDayHoliday();
			//山の日の更新
			$this->__updateMountainDayHoliday();
			//スポーツの日に更新
			$this->__updateSportsDayHoliday();
		}
		return true;
	}

/**
 * 海の日の更新
 *
 * @return void
 */
	private function __updateMarineDayHoliday() {
		$params = [
			'HolidayRrule' => [
				'id' => '',
				'is_variable' => '0',
				'input_month_day' => [
					'month' => '7',
					'day' => '22',
				],
				'can_substitute' => '0',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2021',
				'end_year' => '2021',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => '',
					'language_id' => '2',
					'title' => '海の日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => '',
					'language_id' => '1',
					'title' => 'Marine Day',
					'is_origin' => false,
					'is_translation' => true,
				],
			],
		];
		$this->__HolidayRrule->create(null);
		$this->__HolidayRrule->saveHolidayRrule($params);

		$params = [
			'HolidayRrule' => [
				'id' => '178',
				'input_month_day' => [
					'day' => '18',
					'month' => '7',
				],
				'can_substitute' => '1',
				'is_variable' => '1',
				'week' => '3',
				'day_of_the_week' => 'MO',
				'start_year' => '2022',
				'end_year' => '2033',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => '',
					'language_id' => '2',
					'title' => '海の日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => '',
					'language_id' => '1',
					'title' => 'Marine Day',
					'is_origin' => false,
					'is_translation' => true,
				],
			],
		];
		$this->__HolidayRrule->create(null);
		$this->__HolidayRrule->saveHolidayRrule($params);
	}

/**
 * 山の日の更新
 *
 * @return void
 */
	private function __updateMountainDayHoliday() {
		$params = [
			'HolidayRrule' => [
				'id' => '',
				'is_variable' => '0',
				'input_month_day' => [
					'month' => '8',
					'day' => '8',
				],
				'can_substitute' => '1',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2021',
				'end_year' => '2021',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => '',
					'language_id' => '2',
					'title' => '山の日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => '',
					'language_id' => '1',
					'title' => 'Mountain Day',
					'is_origin' => false,
					'is_translation' => true,
				],
			],
		];
		$this->__HolidayRrule->create(null);
		$this->__HolidayRrule->saveHolidayRrule($params);

		$params = [
			'HolidayRrule' => [
				'id' => '180',
				'is_variable' => '0',
				'input_month_day' => [
					'month' => '8',
					'day' => '11',
				],
				'can_substitute' => '1',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2022',
				'end_year' => '2033',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => '',
					'language_id' => '2',
					'title' => '山の日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => '',
					'language_id' => '1',
					'title' => 'Mountain Day',
					'is_origin' => false,
					'is_translation' => true,
				],
			],
		];
		$this->__HolidayRrule->create(null);
		$this->__HolidayRrule->saveHolidayRrule($params);
	}

/**
 * スポーツの日に更新
 *
 * @return void
 */
	private function __updateSportsDayHoliday() {
		$params = [
			'HolidayRrule' => [
				'id' => '',
				'is_variable' => '0',
				'input_month_day' => [
					'month' => '7',
					'day' => '23',
				],
				'can_substitute' => '0',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2021',
				'end_year' => '2021',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => '',
					'language_id' => '2',
					'title' => 'スポーツの日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => '',
					'language_id' => '1',
					'title' => 'Sports Day',
					'is_origin' => false,
					'is_translation' => true,
				],
			],
		];
		$this->__HolidayRrule->create(null);
		$this->__HolidayRrule->saveHolidayRrule($params);

		$params = [
			'HolidayRrule' => [
				'id' => '182',
				'input_month_day' => [
					'day' => '10',
					'month' => '10',
				],
				'can_substitute' => '0',
				'is_variable' => '1',
				'week' => '2',
				'day_of_the_week' => 'MO',
				'start_year' => '2022',
				'end_year' => '2033',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => '',
					'language_id' => '2',
					'title' => 'スポーツの日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => '',
					'language_id' => '1',
					'title' => 'Sports Day',
					'is_origin' => false,
					'is_translation' => true,
				],
			],
		];
		$this->__HolidayRrule->create(null);
		$this->__HolidayRrule->saveHolidayRrule($params);
	}

}
