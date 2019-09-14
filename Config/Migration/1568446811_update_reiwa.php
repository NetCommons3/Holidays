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
class UpdateReiwa extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'update_reiwa';

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
			//昭和天皇誕生日の更新
			$this->__updateEmperorShowaBirthdayHoliday();
			//令和天皇誕生日の追加
			$this->__addEmperorReiwaBirthdayHoliday();
			//即位礼正殿の儀の行われる日の追加
			$this->__addThroneDay();
		}
		return true;
	}

/**
 * 昭和天皇誕生日の更新
 *
 * @return void
 */
	private function __updateEmperorShowaBirthdayHoliday() {
		$params = [
			'HolidayRrule' => [
				'id' => '36',
				'is_variable' => '0',
				'input_month_day' => [
					'month' => '12',
					'day' => '23',
				],
				'can_substitute' => '1',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '1989',
				'end_year' => '2018',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => 'holiday_803',
					'language_id' => '2',
					'title' => '天皇誕生日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => 'holiday_803',
					'language_id' => '1',
					'title' => 'Emperor\'s Birthday Holiday',
					'is_origin' => false,
					'is_translation' => true,
				],
			],
		];
		$this->__HolidayRrule->saveHolidayRrule($params);
	}

/**
 * 令和天皇誕生日の追加
 *
 * @return void
 */
	private function __addEmperorReiwaBirthdayHoliday() {
		$params = [
			'HolidayRrule' => [
				'id' => '',
				'is_variable' => '0',
				'input_month_day' => [
					'month' => '2',
					'day' => '23',
				],
				'can_substitute' => '1',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2020',
				'end_year' => '2033',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => '',
					'language_id' => '2',
					'title' => '天皇誕生日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => '',
					'language_id' => '1',
					'title' => 'Emperor\'s Birthday Holiday',
					'is_origin' => false,
					'is_translation' => true,
				],
			],
		];
		$this->__HolidayRrule->saveHolidayRrule($params);
	}

/**
 * 即位礼正殿の儀の行われる日の追加
 *
 * @return void
 */
	private function __addThroneDay() {
		$params = [
			'HolidayRrule' => [
				'id' => '',
				'is_variable' => '0',
				'input_month_day' => [
					'month' => '10',
					'day' => '22',
				],
				'can_substitute' => '0',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2019',
				'end_year' => '2019',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => '',
					'language_id' => '2',
					'title' => '即位礼正殿の儀の行われる日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => '',
					'language_id' => '1',
					'title' => 'The day of the throne',
					'is_origin' => false,
					'is_translation' => true,
				],
			],
		];
		$this->__HolidayRrule->saveHolidayRrule($params);
	}

}
