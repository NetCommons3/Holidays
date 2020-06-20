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
class Update2020AutumnalEquinoxDay extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'update_2020_autumnal_equinox_day';

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
 * @var Holiday
 */
	private $__Holiday;

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		$this->__HolidayRrule = $this->generateModel('HolidayRrule');
		$this->__Holiday = $this->generateModel('Holiday');
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
			$update = [
				'HolidayRrule.month_day' => "'2020-09-22'",
				'HolidayRrule.start_year' => "'2020-09-22'",
				'HolidayRrule.end_year' => "'2020-09-22'",
			];
			$conditions = [
				'HolidayRrule.id' => '142'
			];
			$this->__HolidayRrule->updateAll($update, $conditions);

			$update = [
				'Holiday.holiday' => "'2020-09-22'",
			];
			$conditions = [
				'Holiday.holiday_rrule_id' => '142'
			];
			$this->__Holiday->updateAll($update, $conditions);
		}
		return true;
	}

}
