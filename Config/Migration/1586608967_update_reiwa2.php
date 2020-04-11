<?php
/**
 * 多言語化対応
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');
App::uses('CurrentLib', 'NetCommons.Lib');

/**
 * 多言語化対応
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Holidays\Config\Migration
 */
class UpdateReiwa2 extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'update_reiwa2';

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
			//体育の日⇒スポーツの日に更新
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
				'id' => '172',
				'input_month_day' => [
					'day' => '21',
					'month' => '7',
				],
				'can_substitute' => '0',
				'is_variable' => '1',
				'week' => '3',
				'day_of_the_week' => 'MO',
				'start_year' => '2003',
				'end_year' => '2019',
			],
			'Holiday' => [
				2 => [
					'id' => '1980',
					'key' => 'holiday_990',
					'language_id' => '2',
					'title' => '海の日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '1979',
					'key' => 'holiday_990',
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
				'id' => '',
				'is_variable' => '0',
				'input_month_day' => [
					'month' => '7',
					'day' => '23',
				],
				'can_substitute' => '0',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2020',
				'end_year' => '2020',
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
				'id' => '',
				'input_month_day' => [
					'day' => '19',
					'month' => '7',
				],
				'can_substitute' => '1',
				'is_variable' => '1',
				'week' => '3',
				'day_of_the_week' => 'MO',
				'start_year' => '2021',
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
					'day' => '10',
				],
				'can_substitute' => '0',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2020',
				'end_year' => '2020',
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
				'id' => '',
				'is_variable' => '0',
				'input_month_day' => [
					'month' => '8',
					'day' => '11',
				],
				'can_substitute' => '1',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2021',
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

		$params = [
			'HolidayRrule' => [
				'id' => '174',
				'is_variable' => '0',
				'input_month_day' => [
					'month' => '8',
					'day' => '11',
				],
				'can_substitute' => '1',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2016',
				'end_year' => '2019',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => 'holiday_994',
					'language_id' => '2',
					'title' => '山の日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => 'holiday_994',
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
 * 体育の日⇒スポーツの日に更新
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
					'day' => '24',
				],
				'can_substitute' => '0',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2020',
				'end_year' => '2020',
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
				'id' => '',
				'input_month_day' => [
					'day' => '11',
					'month' => '10',
				],
				'can_substitute' => '0',
				'is_variable' => '1',
				'week' => '2',
				'day_of_the_week' => 'MO',
				'start_year' => '2021',
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

		$params = [
			'HolidayRrule' => [
				'id' => '31',
				'input_month_day' => [
					'day' => '9',
					'month' => '10',
				],
				'can_substitute' => '0',
				'is_variable' => '1',
				'week' => '2',
				'day_of_the_week' => 'MO',
				'start_year' => '2000',
				'end_year' => '2019',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => 'holiday_592',
					'language_id' => '2',
					'title' => '体育の日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => 'holiday_592',
					'language_id' => '1',
					'title' => 'Sports Day Holiday',
					'is_origin' => false,
					'is_translation' => true,
				],
			],
		];
		$this->__HolidayRrule->create(null);
		$this->__HolidayRrule->saveHolidayRrule($params);
	}

}
