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
class Update2024Holidays extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'update_2024_holidays';

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
 * Holidayモデル
 *
 * @var HolidayRrule
 */
	private $__Holiday;

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		$this->__HolidayRrule = ClassRegistry::init('Holidays.HolidayRrule');
		$this->__Holiday = ClassRegistry::init('Holidays.Holiday');
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
			//秋分日の更新
			$this->__updateAutumnalEquinoxDay();
		}
		return true;
	}

/**
 * 秋分日の更新
 *
 * @return void
 */
	private function __updateAutumnalEquinoxDay() {
		$count = $this->__Holiday->find('count', array(
			'conditions' => array(
				'holiday' => '2024-09-23',
			),
			'recursive' => -1,
		));
		if ($count > 0) {
			return;
		}

		$params = [
			'HolidayRrule' => [
				'id' => '146',
				'input_month_day' => [
					'day' => '22',
					'month' => '9',
				],
				'can_substitute' => '1',
				'is_variable' => '0',
				'week' => '1',
				'day_of_the_week' => 'SU',
				'start_year' => '2024',
				'end_year' => '2024',
			],
			'Holiday' => [
				2 => [
					'id' => '',
					'key' => '',
					'language_id' => '2',
					'title' => '秋分の日',
					'is_origin' => true,
					'is_translation' => true,
				],
				1 => [
					'id' => '',
					'key' => '',
					'language_id' => '1',
					'title' => 'Autumnal Equinox Day',
					'is_origin' => false,
					'is_translation' => true,
				],
			],
		];
		$this->__HolidayRrule->create(null);
		$this->__HolidayRrule->saveHolidayRrule($params);
	}

}
